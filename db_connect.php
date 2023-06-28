<?php

// Database credentials
$servername = "localhost";
$username = "fannise_charactereditor";
$password = "St3oQftL%3WTRG";
$dbname = "fannise_charactersheets";

// Create database connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>