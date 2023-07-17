<?php
	// veritabanı bağlantısı için gerekli parametreler
	$host = "localhost";
	$vt_adi = "inncreal_cihaztakip";
	$kullanici_adi = "inncreal_uruntakipuser";
	$sifre = "inncreatakip.58!@";

	try {
		 $con = new PDO("mysql:host={$host};dbname={$vt_adi}", $kullanici_adi, $sifre,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}
	// hatayı göster
	catch(PDOException $exception){
	 	 echo "Bağlantı hatası: " . $exception->getMessage();
	}
?>