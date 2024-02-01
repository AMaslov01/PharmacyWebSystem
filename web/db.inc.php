<?php
$hostname = "localhost:3306";
$username = "healthfirst";
$password = "bsw81@6M1";

$dbname = "PharmacyWebSystem";

$con = mysqli_connect($hostname, $username, $password, $dbname);

if (!$con)
{
	die ("Failed to connect to MySQL: ".mysqli_connect_error());
}
?>