<?php

$form_action_func = $_GET['function'];
$json = $_GET['jsonobj'];
if(isset($form_action_func))
{
    switch ($form_action_func) {
        case 'isServerAndDBUp':
            isServerAndDBUp();
            break;
        case 'isRoundDone':
            isRoundDone($json);
            break;
    }
}

function isRoundDone($json) {
    //TODO loop over all players in in room id and check if all players are round in json or above. if so echo true otherwise false! :D
    echo $json;
}

function isServerAndDBUp() {
    //TODO: Actually check if DB is online
    echo "True";
}
?>