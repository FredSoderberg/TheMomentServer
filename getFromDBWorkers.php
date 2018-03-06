<?php
//Dont know if dbconnect is needed, but upon failure include it
//require 'dbConnect.php';
/**
 * worker function to get all rooms with available slots
 * @param $connection mysqli, needed for db talk
 * @return array contains all rows with rooms available
 */
function getRoomsWithEmptySlotsWorker($connection) {
    if ($query = mysqli_prepare($connection, "
                            SELECT a.id ID, count(p.id) players, a.numOfPlayers freeSlots 
                            FROM Room a LEFT OUTER JOIN Player p ON a.ID = p.roomID 
                            group by a.id HAVING count(p.id) < a.numOfPlayers 
                            ORDER BY a.numOfPlayers DESC")) {
        return dbQueryGetResult($query);
    }
}

/**
 * The worker process for getting the room in array form
 * @param $roomID int, is the id of the room to get
 * @param $connection mysqli, needed for db talk
 * @return array which contains an array of arrays representing the room
 */
function getRoomByIDWorker($roomID, $connection) {
    if ($query = mysqli_prepare($connection, "SELECT * FROM Room WHERE id=?")) {
        mysqli_stmt_bind_param($query, "i", $roomID);
        $room = dbQueryGetResult($query);
        $room = $room[0];
        if ($room === NULL) {
            return NULL;
        }
    }
    if ($query = mysqli_prepare($connection, "SELECT * FROM Player WHERE roomID=?")) {
        mysqli_stmt_bind_param($query, "i", $roomID);
        $playerRows = dbQueryGetResult($query);
    }
    $playerList = [];
    foreach ($playerRows as $row) {
        unset($row['roomID']);
        $claim = getClaimByIDWorker($row['claim'],$connection);
        $claim = $claim[0];
        $claim['correctAnswer'] = (bool)$claim['correctAnswer'];
        $row['answer'] = (bool)$row['answer'];
        $row['isPlayer'] = (bool)$row['isPlayer'];
        $row['claim'] = $claim;
        $playerList[] = $row;
    }
    $room['playerList'] = $playerList;
    mysqli_close($connection);
    return $room;
}

/**
 * The worker process for getting the claim in array form
 * @param $claimID int the id to be searched with, unique
 * @param $connection mysqli, for db talk
 * @return array which contains claim
 */
function getClaimByIDWorker($claimID, $connection) {
    if ($query = mysqli_prepare($connection, "SELECT * FROM Claim WHERE id=?")) {
        mysqli_stmt_bind_param($query, "i", $claimID);
        return dbQueryGetResult($query);
    }
}

/**
 * checks if room is holding more people then the limit
 * @param $roomID int for the id of the room to check
 * @return bool true if its crowded else false
 */
function isRoomToFullWorker($connection, $roomID) {
    if ($query = mysqli_prepare($connection, "SELECT numOfPlayers AS size FROM Room WHERE id=?")) {
        mysqli_stmt_bind_param($query, "i", $roomID);
        $roomSize = dbQueryGetResult($query)[0]['size'];
    }
    if ($query = mysqli_prepare($connection, "SELECT COUNT(Player.roomID) AS amount FROM Player WHERE roomID = ?")) {
        mysqli_stmt_bind_param($query, "i", $roomID);
        $playersInRoom = dbQueryGetResult($query)[0]['amount'];
    }
    return ($roomSize <= $playersInRoom);
}