<?php

$sname= "localhost";
$unmae= "inncreal_uruntakipuser";
$password = "inncreatakip.58!@";
$db_name = "inncreal_cihaztakip";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}