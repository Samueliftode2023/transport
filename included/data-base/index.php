<?php
$serverName = 'localhost';
$dBUser = 'root';
$dBNume = 'transport';
$parola ='';

$conectareDB = mysqli_connect($serverName, $dBUser, $parola ,$dBNume);

if ($conectareDB->connect_error) {
    die("Connection failed: " . $conectareDB->connect_error);
}

?>