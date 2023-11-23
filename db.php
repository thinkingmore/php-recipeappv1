<?php

// database information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipes";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn -> connect_error){
    die("Failed to establish connection" .  $conn-> connect_error);
}

?>