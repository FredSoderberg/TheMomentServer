<?php

header('Content-Type: application/json');

require 'dbConnect.php';

$form_action_func = $_GET['function'];
$json = $_GET['jsonobj'];

if(isset($form_action_func))
{
    switch ($form_action_func) {
        case 'getRandomRoom':
            getRandomRoom($json);
            break;

        case 'getRoomByID':
            getRoomByID($json);
            break;
    }
}

/**
 * will take player id and try to match it into a room with available slots
 * @param $json
 */
function getRandomRoom($json) {
    $list = json_decode($json,true);
    $playerID = $list[0];
    $connection = db_connect();
    $availableRooms = getRoomsWithEmptySlots($connection);



}

function getRoomsWithEmptySlots($connection) {
    if ($query = mysqli_prepare($connection, "
                            SELECT a.ID room, count(p.id) players, a.numOfPlayers freeSlots 
                            FROM Room a LEFT OUTER JOIN Player p ON a.ID = p.RoomID 
                            group by a.id HAVING count(p.ID) < a.numOfPlayers 
                            ORDER BY a.numOfPlayers DESC")) {
        return dbQueryGetResult($query);
    }
}


/**
 * Collects the complete room by id from the DB.
 * @param $roomID int, matching the ID of a room in DB
 * @return string in json format which is the room object client side.
 */
function getRoomByID($roomID) {
    $connection = db_connect();
    $room = getRoomByIDWorker($roomID,$connection);
    echo json_encode($room);

}

/**
 * The worker process for getting the room in array form
 * @param $roomID int, is the id of the room to get
 * @param $connection mysqli, needed for db talk
 * @return array which contains an array of arrays representing the room
 */
function getRoomByIDWorker($roomID, $connection) {
    if ($query = mysqli_prepare($connection, "SELECT * FROM Room WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "i", $roomID);
        $room = dbQueryGetResult($query);
        $room = $room[0];
    }
    if ($query = mysqli_prepare($connection, "SELECT * FROM Player WHERE RoomID=?")) {
        mysqli_stmt_bind_param($query, "i", $roomID);
        $playerRows = dbQueryGetResult($query);
    }
    $playerList = [];
    foreach ($playerRows as $row) {
        unset($row['RoomID']);
        $claim = getClaimByIDWorker($row['Claim'],$connection);
        $claim = $claim[0];
        $row['Claim'] = $claim;
        $playerList[] = $row;
    }
    $room['playerList'] = $playerList;
    mysqli_close($connection);
    return $room;
}

/**
 * The function being called to get the claim and will echo in JSON format
 * @param $claimID mysqli, the unique id to search with.
 * @room json formatted claim
 */
function getClaimByID($claimID) {
    $connection = db_connect();
    $claim = getClaimByIDWorker($claimID,$connection);
    mysqli_close($connection);
    echo json_encode($claim);
}

/**
 * The worker process for getting the claim in array form
 * @param $claimID int the id to be searched with, unique
 * @param $connection mysqli, for db talk
 * @return array which contains claim
 */
function getClaimByIDWorker($claimID, $connection) {
    if ($query = mysqli_prepare($connection, "SELECT * FROM Claim WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "i", $claimID);
        return dbQueryGetResult($query);
    }
}