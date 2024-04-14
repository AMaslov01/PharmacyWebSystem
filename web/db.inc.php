<?php
$hostname = "localhost:3306";

$username = "root"; // username for local db

$password = ""; // password for local db

$dbname = "PharmacyWebSystem2";
// $dbname = "PharmacyWebSystem";

$con = mysqli_connect($hostname, $username, $password, $dbname) or die ("Failed to connect to MySQL: ".mysqli_connect_error());
