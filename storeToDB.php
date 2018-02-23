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
        case 'updatePlayer' :
            updatePlayer($json);
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



//updatePlayer('[{"answer":false,"claim":{"ID":0,"claim":"Erika fes","correctAnswer":true},"id":0,"isPlayer":true,"name":"Skitungen","round":0,"score":0}]');
updateClaim('[{"ID":1, "claim":"noooooff","correctAnswer":true}]');

function updateClaim($json)
{
//Change to take in a claim instead, also change on client side to look if a claim exists, then update otherwise create a new claim.
    $list = json_decode($json, true);
    $list = $list[0];
    print_r($list['ID']);
    print_r($list['claim']);
    print_r($list['correctAnswer']);
    $claimID = $list['ID'];
    $theClaim = $list['claim'];
    $corrAnsw = $list['correctAnswer'];
    print_r($claimID);
    print_r($theClaim);
    print_r($corrAnsw);

    $connection = mysqli_connect('localhost', 'root', 'Skumbanan1', 'themomentdb');
    if ($query = mysqli_prepare($connection, "UPDATE claim SET Claim=?, CorrectAnswer=? WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "sss", $theClaim, $corrAnsw, $claimID);
        return $claimID;
    }
}
   /*  $list = $list[0];
    print_r($list['name']);
    print_r($list['claim']['claim']);
*/
   /* $list = $list[0];
    $playerID = $list['id'];
    $claimToUpdateTo = $list['claim'];
    $connection = mysqli_connect('localhost', 'root', 'Skumbanan1', 'themomentdb');
    print_r('hej');
        if ($query = mysqli_prepare($connection, "UPDATE player SET claim=? WHERE ID=?")) {
            mysqli_stmt_bind_param($query, 'ss',  $claimToUpdateTo, $playerID);
            print_r('inne');
            print_r($playerID);
            return $playerID;
        }
*/


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
function createRoom(){
    $connection = db_connect();
    if ($query = mysqli_prepare($connection, "INSERT INTO Room () Values()")) {
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
    if ($query = mysqli_prepare($connection, "DELETE FROM Player WHERE ID=?")) {
        mysqli_stmt_bind_param($query, "s", $playerID);
        $resultPlayer =  dbQueryRemove($query);
    }
    if (count($list) > 1) {
        if ($query = mysqli_prepare($connection, "SELECT * FROM Player WHERE RoomID=?")) {
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