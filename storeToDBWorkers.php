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
        mysqli_stmt_bind_param($query, "ss", $roomSize,$roomID);
        dbQuery($query);
        //TODO Guard for db failure
    }
}

/**
 * Updates an existing claim in DB with a new "phrase" and changes what the correct answer is
 * @param $connection mysqli, needed for db talk
 * @param $claimID the id of claim to update
 * @param $theClaim the phrase that should be changed
 * @param $corrAnsw updates the correct answer to suit the new claim
 */
function setClaim($connection, $claimID, $theClaim, $corrAnsw) {
    if ($query = mysqli_prepare($connection, "UPDATE Claim SET Claim=?, CorrectAnswer=? WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "sss", $theClaim, $corrAnsw, $claimID);
        dbQuery($query);
    }
}

/**
 * creates a new claim in DB and returns its ID
 * @param $connection mysqli, needed for db talk
 * @param $claim string containing the actual claim
 * @param $correctAnswer the correct answer of the claim
 * @return int the id of the new created claim
 */
function createClaim($connection, $claim, $correctAnswer){
    if ($query = mysqli_prepare($connection, "INSERT INTO claim (Claim, CorrectAnswer)VALUES (?, ?)")){
        mysqli_stmt_bind_param($query, "ss",$claim, $correctAnswer);
        $id = dbQueryStoreGetId($query, $connection);
        return $id;
    }
}

/**
 * Updates a players claim with new claim id
 * @param $connection mysqli, needed for db talk
 * @param $claimID string with the Claims ID
 * @param $playerID the ID belonging to the player thats claim should be updated
 */

function updatePlayerClaim($connection, $claimID, $playerID){
    if ($query = mysqli_prepare($connection, "UPDATE Player SET Claim=? WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "ss", $claimID,$playerID);
        dbQuery($query);
    }
}

/**
 * Updates a players score
 * @param $connection mysqli, needed for db talk
 * @param $playerID string with Players ID
 * @param $newScore the players new score that the DB should be updated with
 */

function updateScore($connection, $playerID, $newScore){
    if ($query = mysqli_prepare($connection, "UPDATE Player SET Score=? WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "ss", $newScore,$playerID);
        dbQuery($query);
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