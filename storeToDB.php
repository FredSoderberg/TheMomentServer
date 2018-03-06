
<?php

require 'dbConnect.php';
require 'storeToDBWorkers.php';
require 'getFromDBWorkers.php';

header('Content-Type: application/json');

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
            break;
        case 'updatePlayerScore' :
            updatePlayerScore($json);
            break;
        case 'updateClaim' :
            updateClaim($json);
            break;
        case 'newClaim' :
            newClaim($json);
            break;
        case 'storePlayerRound':
            storePlayerRound($json);
            break;
        case 'removeStragglers':
            removeStragglers($json);
            break;
        case 'updateClaimNo':
            updateClaimNo($json);
            break;

    }
}


/**
 * updates database room with new size
 * @param $json string contains roomID and size to set
 */
function updateRoomSize($json) {
    $list = json_decode($json,true);
    $roomID = $list[0];
    $roomSize = $list[1];
    $connection = db_connect();
    setRoomSizeWorker($connection,$roomID,$roomSize);
    mysqli_close($connection);
    echo true;
}


function storePlayerRound($json){
    $list = json_decode($json,true);
    $playerId = $list[0];
    $playerRound = $list[1];
    $connection = db_connect();

    setPlayersRoundWorker($connection,$playerId,$playerRound);
    echo $playerRound;
}

/**
 * creates a new player in db, depending on json it also assigns a room to player
 * @param $json string will contain either just a player name or name and room to add to
 */
function storePlayer($json) {
    $list = json_decode($json,true);
    $lenghtOfList = count($list);
    $name = $list[0]['name'];
    $roomID = $list[1];
    $connection = db_connect();
    $playerID = storeNewPlayerWorker($connection,$name);
    if ($lenghtOfList === 2) {
        setPlayersRoomIDWorker($connection,$playerID,$roomID);
    }
    mysqli_close($connection);
    echo $playerID;
}

/**
 * Updates a claim in DB, echoes id
 * @param $json string will contain the claim
 */

function updateClaim($json) {
    $list = json_decode($json, true);
    $list = $list[0];
    $claimID = $list['id'];
    $theClaim = $list['claim'];
    $corrAnsw = $list['correctAnswer'];

    $connection = db_connect();
    setClaimWorker($connection, $claimID, $theClaim, $corrAnsw);
    echo $claimID;
}

/**
 * Creates a new claim and connects it with the player who wrote it
 * @param $json string will contain the claim to create and the player that wrote it
 */
function newClaim($json){
    $list = json_decode($json, true);
    $claimList = $list[0];
    $player = $list[1];
    $connection = db_connect();
    $id = createClaimWorker($connection, $claimList['claim'], $claimList['correctAnswer']);
    updatePlayerClaimWorker($connection, $id, $player['id']);
    echo $id;
}

/**
 * Updates a players score
 * @param $json string will contain player ID and the players new score
 */
function updatePlayerScore($json){
    $list = json_decode($json);
    $playerID = $list[0];
    $newScore = $list[1];
    $connection = db_connect();
    updateScoreWorker($connection, $playerID, $newScore);

}

function updateRoom($json){
	//TODO, add changes to Room, request room by id and then loop values and if changes are detected insert new value
    //TODO probably gonna need a help function to handle players and claims.
}

/**
 * creates a new room in db and returns the ID.
 */
function createRoom(){
    $connection = db_connect();
    $nbrPlayers = 0;
    if ($query = mysqli_prepare($connection, "INSERT INTO Room (numOfPlayers) Values(?)")) {
        mysqli_stmt_bind_param($query, "s",$nbrPlayers);
        $id = dbQueryStoreGetId($query,$connection);
        echo $id;
    }
}

/**
 * removes player by id from DB and if room is after empty it will be removed. echoes succes bool.
 * @param $json string in JSON format containing [roomID,playerID] or just [playerID]
 */
function removePlayerByID($json) {
    $list = json_decode($json);
    if (count($list) > 1) {
        $roomID = $list[0];
        $playerID = $list[1];
    } else {
        $playerID = $list[0];
    }

    $connection = db_connect();
    if ($query = mysqli_prepare($connection, "DELETE FROM Player WHERE id=?")) {
        mysqli_stmt_bind_param($query, "s", $playerID);
        $resultPlayer =  dbQueryRemove($query);
    }
    if (count($list) > 1) {
        if ($query = mysqli_prepare($connection, "SELECT * FROM Player WHERE roomID=?")) {
            mysqli_stmt_bind_param($query, "s", $roomID);
            $playersInRoom =  dbQueryGetResult($query);
        }
        if (count($playersInRoom) == 0) {
            removeRoomByIDWorker($roomID,$connection);
        }
    }


    mysqli_close($connection);
    //$result = $playersInRoom && $resultPlayer;
    $result = true;
    //TODO FIX IF FAIL!
    echo $result;
}

/**
 * traverses the given room and deletes players with a lower round then given
 * @param $json string in format [roomID,roundNo]
 */
function removeStragglers($json) {
    $list = json_decode($json);
    $roomID = $list[0];
    $roundNo = $list[1];
    $connection = db_connect();
    if ($query = mysqli_prepare($connection, "DELETE FROM Player WHERE roomID=? AND round < ?")) {
        mysqli_stmt_bind_param($query, "ii",$roomID,$roundNo);
        dbQueryRemove($query);
        //TODO handle failure
    }
}

/**
 * updates claim in given room
 * @param $json string in format [roomID,currentClaimNo]
 */
function updateClaimNo($json) {
    $list = json_decode($json);
    $roomID = $list[0];
    $claimNo = $list[1];
    $connection = db_connect();
    if ($query = mysqli_prepare($connection, "UPDATE Room SET currentClaimNo=? WHERE id=?")) {
        mysqli_stmt_bind_param($query, "ii",$claimNo,$roomID);
        dbQuery($query);
        //TODO handle failure
    }
}