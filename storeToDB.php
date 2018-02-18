<?php
/**
 * Created by PhpStorm.
 * User: Nhunter
 * Date: 2018-02-14
 * Time: 13:11
 */

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
    }
}

function storePlayer($json) {
    //TODO save to DB and return ID!
    echo "1";
}

function updateRoom($json){
	//TODO, add changes to Room
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
    },
    {
      "id": 2,
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
}

function createRoom($json){
	//TODO create room and return room
	echo  '{
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
    },
    {
      "id": 2,
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
}


?>