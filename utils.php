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

isRoundDone("[6,1]");

function isRoundDone($json) {
    $list = json_decode($json);
    $roomID = current($list);
    next($list);
    $roundNo = current($list);

    $connection = db_connect();
    if ($query = mysqli_prepare($connection, "SELECT * FROM Player WHERE RoomID=?")) {
        /* bind parameters for markers */
        mysqli_stmt_bind_param($query, "i", $roomID);

        /* execute query */
        if(!mysqli_stmt_execute($query)) {
            echo "Failed";
        }
        /* bind result variables */
        mysqli_stmt_bind_result($stmt, $district);

        /* fetch value */
        mysqli_stmt_fetch($stmt);

        printf("GOT - %s",$district);
        /* close statement */
        mysqli_stmt_close($query);
    }
    /* close connection */
    mysqli_close($connection);
    //TODO loop over all players in in room id and check if all players are round in json or above. if so echo true otherwise false! :D


/*
    $string = $roomID;
    $string .= "-";
    $string .= $roundNo;
    echo $string;
*/
}

function isServerAndDBUp() {
    //TODO: Actually check if DB is online
    echo "True";
}
?>