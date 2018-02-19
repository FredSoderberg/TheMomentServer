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
 * This will probably change or be replaced when mysql injection guarding is implemented
 * @param $query is a string or prepared sql query for the db
 * @return bool|mysqli_result returns the result from the query
 */
function db_query($query) {
    $connection = db_connect();
    $result = mysqli_query($connection,$query);
    return $result;
}

/**
 * use this method if you are creating a new entry and need to return the id
 * @param $query a prepared sql query
 * @return int|string, id assigned by db upon creation of new line in db
 */
function db_query_ID($query) {
    $connection = db_connect(false);
    $result = mysqli_query($connection,$query);
    if ($result) {
        return mysqli_insert_id($connection);
    }
    else {
        return -1;
    }
}