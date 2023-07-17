<?php

try {
	
	$baglanti = new PDO("mysql:host=localhost;dbname=inncreal_cihaztakip","inncreal_uruntakipuser","inncreatakip.58!@");
}

catch (PDOExpception $e) {

	echo $e->getMessage();
}

 ?>