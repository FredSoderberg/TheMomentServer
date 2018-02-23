<?php
require 'dbConnect.php';

$form_action_func = $_GET['function'];
if( isset($_GET['jsonobj']) )
{
    $json = $_GET['jsonobj'];
}

if(isset($form_action_func))
{
    switch ($form_action_func) {
        case 'storePlayer':
            storePlayer($json);
            break;
        case 'updateRoom':
        	updateRoom($json);
        	break;
        case 'createRoom' :
        	createRoom();
        	break;
        case 'updateRoomSize':
            updateRoomSize($json);
            break;
        case 'removePlayerByID':
            removePlayerByID($json);
    }
}

function updateRoomSize($json) {
    echo $json;
}

function storePlayer($json) {
    $list = json_decode($json,true);
    $lenght = count($list);
    $name = $list[0]['name'];
    $roomID = $list[1];
    $roomSize = $list[2];
    $connection = db_connect();
    $playerID = storeNewPlayerWorker($connection,$name);
    if ($lenght === 2) {
        setPlayersRoomID($connection,$playerID,$roomID);
    }
    if ($lenght === 3) {
        setRoomSize($connection,$roomID,$roomSize);
    }
    mysqli_close($connection);
    echo $playerID;
}

function storeNewPlayerWorker($connection,$name){
    if ($query = mysqli_prepare($connection, "INSERT INTO Player (Name) Values(?)")) {
        mysqli_stmt_bind_param($query, "s", $name);
        $id = dbQueryStoreGetId($query,$connection);
        //TODO Guard for db failure
        return $id;
    }
}

function setPlayersRoomID($connection,$playerID,$roomID) {
    if ($query = mysqli_prepare($connection, "UPDATE Player SET RoomID=? WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "ss", $roomID,$playerID);
        dbQuery($query);
        //TODO Guard for db failure
    }
}

function setRoomSize ($connection,$roomID,$roomSize) {
    if ($query = mysqli_prepare($connection, "UPDATE Room SET numOfPlayers=? WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "ss", $$roomSize,$$roomID);
        dbQuery($query);
        //TODO Guard for db failure
    }
}

function updateRoom($json){
	//TODO, add changes to Room, request room by id and then loop values and if changes are detected insert new value
    //TODO probably gonna need a help function to handle players and claims.
    //dont return a room!
    /*
	echo '{
  "ID": 10,
  "numOfPlayers": 1,
  "playerList": [
    {
      "id": 1,
      "name": "Uffe",
      "score": 10,
      "answer": true,
      "claim": {
        "claim": "Vi har",
        "correctAnswer": true
      },
      "isPlayer": true
    }    
  ]
}';
    */
}

/**
 * creates a new room in db and returns the ID.
 */
function createRoom($size){
    $connection = db_connect();
    /* create a prepared statement */
    if ($query = mysqli_prepare($connection, "INSERT INTO Room (numOfPlayers) Values(?)")) {
        /* bind parameters for markers */
        mysqli_stmt_bind_param($query, "s", $size);
        $id = dbQueryStoreGetId($query,$connection);
        echo $id;
    }
}

/**
 * removes player by id from DB and if room is after empty it will be removed. echoes succes bool.
 * @param $json string in JSON format containing [roomID,playerID]
 */
function removePlayerByID($json) {
    $list = json_decode($json);
    $roomID = $list[0];
    $playerID = $list[1];

    $connection = db_connect();
    if ($query = mysqli_prepare($connection, "DELETE FROM Player WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "s", $playerID);
        $resultPlayer =  dbQueryRemove($query);
    }
    if ($query = mysqli_prepare($connection, "SELECT * FROM Player WHERE RoomID=?")) {
        mysqli_stmt_bind_param($query, "s", $roomID);
        $playersInRoom =  dbQueryGetResult($query);
    }

    echo count($playersInRoom);
    if (count($playersInRoom) == 0) {
        print removeRoomByIDWorker($roomID,$connection);
    }
    mysqli_close($connection);
    //$result = $playersInRoom && $resultPlayer;
    $result = true;
    //TODO FIX IF FAIL!
    echo $result;
}

/**
 * Removes the room with id roomID from DB
 * @param $roomID string to query with
 * @param $connection mysqli, needed for db talk
 * @return bool if success or not
 */
function removeRoomByIDWorker($roomID,$connection) {
    if ($query = mysqli_prepare($connection, "DELETE FROM Room WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "s", $roomID);
        return dbQueryRemove($query);
    }

}