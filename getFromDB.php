<?php
/**
 * Created by PhpStorm.
 * User: Nhunter
 * Date: 2018-02-14
 * Time: 14:54
 */
$form_action_func = $_GET['function'];
$json = $_GET['jsonobj'];

if(isset($form_action_func))
{
    switch ($form_action_func) {
        case 'getRandomRoom':
            getRandomRoom();
            break;

        case 'getRoomByID':
            getRoomByID($json);
            break;
    }
}

function getRandomRoom() {
    //TODO add player to random room and confirm it doesnt exced max
    //echo '{"ID": 1, "numOfPlayers": 1, "playerList": [ {"Player": {"id": 1, "name": "Uffe", "score": 10, "answer": true, "claim": {"claim": "Vi har", "correctAnswer": true }}}]}';
    echo '{
  "ID": 10,
  "numOfPlayers": 1,
  "playerList": [
    {
      "Player": {
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
    }
  ]
}';
}

function getRoomByID($json) {
    //TODO query server with $json for room and encode it and send it back
    echo '{
  "ID": 10,
  "numOfPlayers": 1,
  "playerList": [
    {
      "Player": {
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
    }
  ]
}';
}
?>