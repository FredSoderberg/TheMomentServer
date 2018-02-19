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
    }
}

function updateRoomSize($json) {
    echo $json;
}

function storePlayer($json) {
    //TODO save to DB and return ID!
    echo "1";
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

function createRoom(){
    //This is standard for us on creating, but if needed we can insert the actual numOfPlayers
    $val = null;
    $connection = db_connect();
    /* create a prepared statement */
    if ($query = mysqli_prepare($connection, "INSERT INTO Room (numOfPlayers) Values(?)")) {
        /* bind parameters for markers */
        mysqli_stmt_bind_param($query, "s", $val);

        /* execute query */
        if(mysqli_stmt_execute($query)) {
            echo mysqli_insert_id($connection);
        } else {
            echo "Failed";
        }
        /* close statement */
        mysqli_stmt_close($query);
    }
    /* close connection */
    mysqli_close($connection);
}