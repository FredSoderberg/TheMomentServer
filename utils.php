<?php
/**
 * Created by PhpStorm.
 * User: Nhunter
 * Date: 2018-02-13
 * Time: 20:53
 */
$form_action_func = $_GET['function'];
if(isset($form_action_func))
{
    switch ($form_action_func) {
        case 'isServerAndDBUp':
            isServerAndDBUp();
            break;
    }
}

function isServerAndDBUp() {
    //TODO: Actually check if DB is online
    echo "True";
}
?>