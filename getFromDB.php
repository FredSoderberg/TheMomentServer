<?php
/**
 * Created by PhpStorm.
 * User: Nhunter
 * Date: 2018-02-14
 * Time: 14:54
 */
$form_action_func = $_GET['function'];

if(isset($form_action_func))
{
    switch ($form_action_func) {
        case 'getRandomRoom':
            getRandomRoom();
            break;
    }
}

function getRandomRoom() {
    //echo '{"ID": 1, "numOfPlayers": 1, "playerList": [ {"Player": {"id": 1, "name": "Uffe", "score": 10, "answer": true, "claim": {"claim": "Vi har", "correctAnswer": true }}}]}';
    echo '{
        "ID": 1,
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
        }
      }
    }
  ]
}';
}
?>