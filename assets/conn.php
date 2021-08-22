<?php 
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "kozosseg";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die($conn->connect_error);
}
$conn->set_charset("utf8");

?>