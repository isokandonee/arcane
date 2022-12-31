<?php

// get environment variables 
require "variables.php";

/* Connecting to the database. */
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check if connection to db is successful
if (!$conn){
    die("Connection failed" .mysqli_connect_error());
}
