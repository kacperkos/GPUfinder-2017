<?php
// Enter your MySL configuration data below
$db_server = "localhost";
$db_user = "";
$db_pass = "";
$db_name = "";
$mysqli = new mysqli($db_server, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    echo 'Error: not connected to database (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
    die;
}