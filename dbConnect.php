<?php

/**
 * Sets up a connection to the database. Remember to reuse and terminate it when done
 * @return mysqli|string, basically a connection to the database
 */
function db_connect() {
    // Define connection as a static variable, to avoid connecting more than once
    static $connection;
    // Try and connect to the database, if a connection has not been established yet
    if(!isset($connection)) {
        // Load configuration as an array. Use the actual location of your configuration file
        $config = parse_ini_file('../dbConnection/config.ini');
        $connection = mysqli_connect('localhost:3306',$config['username'],$config['password'],$config['dbname']);
    }
    // If connection was not successful, handle the error
    if($connection === false) {
        // Handle error - notify administrator, log to a file, show an error screen, etc.
        return mysqli_connect_error();
    }
    return $connection;
}

/**
 * querys the DB and fetches one or multiple rows from the response.
 * @param $query the query which must be prepared before.
 * @return array which contains rows at indexes, traverse with a foreach for example.
 */
function db_query($query) {
    if(!mysqli_stmt_execute($query)) {
        echo "Failed";
    }
    $result = mysqli_stmt_get_result($query);
    $rows = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $rows[] = $row;
    }
    mysqli_stmt_close($query);
    return $rows;
}