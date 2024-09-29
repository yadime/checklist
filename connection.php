<?php

$servername = "127.0.0.1";
$username = "yadi";
$password = "";
$dbname = "checklist_1";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



?>