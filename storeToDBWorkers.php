<?php
//Dont know if dbconnect is needed, but upon failure include it
//require 'dbConnect.php';

/**
 * worker function for storing new player in db
 * @param $connection mysqli, needed for db talk
 * @param $name string for players name
 * @return int which is new players id
 */
function storeNewPlayerWorker($connection,$name){
    if ($query = mysqli_prepare($connection, "INSERT INTO Player (Name) Values(?)")) {
        mysqli_stmt_bind_param($query, "s", $name);
        $id = dbQueryStoreGetId($query,$connection);
        //TODO Guard for db failure
        return $id;
    }
}

/**
 * worker function for setting which room player belongs to
 * @param $connection mysqli, needed for db talk
 * @param $playerID int indicating id
 * @param $roomID int indicating id
 */
function setPlayersRoomIDWorker($connection,$playerID,$roomID) {
    if ($query = mysqli_prepare($connection, "UPDATE Player SET RoomID=? WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "ss", $roomID,$playerID);
        dbQuery($query);
        //TODO Guard for db failure
    }
}

/**
 * worker function querying db to change roomsize of a room
 * @param $connection mysqli, needed for db talk
 * @param $roomID int indicating id
 * @param $roomSize int indicating size
 */
function setRoomSizeWorker ($connection,$roomID,$roomSize) {
    if ($query = mysqli_prepare($connection, "UPDATE Room SET numOfPlayers=? WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "ss", $$roomSize,$$roomID);
        dbQuery($query);
        //TODO Guard for db failure
    }
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