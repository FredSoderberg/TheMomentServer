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
        	createRoom($json);
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
	//TODO, add changes to Room
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

function createRoom($json){
    echo 200;
	//TODO create room
    //- NO DONT! -> and return room
    //RETURN ID!
/*
 echo  '{
  "ID": 10,
  "numOfPlayers": 1,
  "playerList": [
    {
      "id": 1,
      "name": "Torkel",
      "score": 3,
      "answer": true,
      "claim": {
        "claim": "Vi har",
        "correctAnswer": true
      },
      "isPlayer": false
    }
  ]
}';
*/
}

function temp($json) {
    //EXAMPLE CODE!
    $connection = db_connect();
    /* create a prepared statement */
    if ($query = mysqli_prepare($connection, "SELECT District FROM City WHERE Name=?")) {

        /* bind parameters for markers */
        mysqli_stmt_bind_param($query, "s", $city);

        /* execute query */
        mysqli_stmt_execute($query);

        /* bind result variables */
        mysqli_stmt_bind_result($query, $district);

        /* fetch value */
        mysqli_stmt_fetch($query);

        printf("%s is in district %s\n", $city, $district);

        /* close statement */
        mysqli_stmt_close($query);
    }

    /* close connection */
    mysqli_close($connection);
}


?>