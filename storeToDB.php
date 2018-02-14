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
    }
}

function storePlayer($json) {
    //TODO save to DB and return ID!
    echo "1";
}

?>