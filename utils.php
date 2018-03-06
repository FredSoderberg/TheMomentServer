<?php

require 'dbConnect.php';

header('Content-Type: application/json');

$form_action_func = $_GET['function'];
if( isset($_GET['jsonobj']) )
{
    $json = $_GET['jsonobj'];
}
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

/**
 * Gets all players from room with id provided in json.
 * Then checks the one by round attribute, if one is on a lower round then one in json
 * that round is considered not done yet and a false (0) will be echoed
 * otherwise if all is on roundNo or above true will be echoed.
 * @param $json containing [roomID,roundNo].
 */
function isRoundDone($json) {
    $list = json_decode($json);
    $roomID = $list[0];
    $roundNo = $list[1];

    $connection = db_connect();
    if ($query = mysqli_prepare($connection, "SELECT * FROM Player WHERE roomID=?")) {
        mysqli_stmt_bind_param($query, "i", $roomID);
        $rows = dbQueryGetResult($query);
    }
    mysqli_close($connection);

    foreach ($rows as $row) {
        if ($row['round'] < $roundNo) {
            echo false;
            return;
        }
    }
    echo true;
}

/**
 * A simple function that checks if the servers db is up.
 */
function isServerAndDBUp() {
    $config = parse_ini_file('../dbConnection/config.ini');
    $connection = mysqli_connect('localhost:3306',$config['username'],$config['password'],$config['dbname']);
    if($connection) {
        echo true;
        return;
    }
    echo false;
}
?>