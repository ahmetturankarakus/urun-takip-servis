<?php 
session_start();
ob_start();

if (isset($_SESSION['id']) && isset($_SESSION['kadi'])) {

 ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inncrea Ürün Takip Sistemi</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


    <link href="../public/sytle.css" rel="stylesheet">
    <link href="../public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    
  <!-- Default panel contents -->
  <div class="navbar navbar-light bg-light"><a class="navbar-brand" href="musteripanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	</div>
<br>
<div class="container">
	
	
	
 	<div class="page-header">
 		<h1>Ürün Servis Geçmişi</h1>
 	</div>
	
	<div class="row"> 
	
		<?php
		
		$id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');	
		$sonid = $id;
	
		?>
	
	</div>
	 <br>
	
<?php

	// veritabanı bağlantı dosyasını çağır
 	include "../pdoconfig.php";
	  
            $sorgu = ("SELECT*FROM servis_".$sonid."");
		    $stmt = $con->prepare($sorgu);
            $stmt ->execute();
			$yeniid=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');
			
		    $sayi = $stmt->rowCount();

		   		
	
	if($sayi>0){

				echo "<table class='table table-hover table-responsive table-bordered'>";
					//tablo başlangıcı
 					//tablo başlıkları
 				echo "<tr>";
 					echo "<th>ID</th>";
 					echo "<th>Açıklama</th>";
					echo "<th>Tarih</th>";
					echo "<th>Fotoğraf</th>";
				echo "</tr>";

 					while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
 					// tablo alanlarını değişkene dönüştürür
 					// $kayit['urunadi'] => $urunadi
 						extract($kayit);

 						// her kayıt için yeni bir tablo satırı oluştur
 						echo "<tr>";
 							echo "<td>{$id}</td>";
							echo "<td>{$aciklama}</td>";
							echo "<td>{$tarih}</td>";
							echo "<td><img src='../img/servisfoto/{$resim}' style='width:75px;'</td>";
							
 						echo "</tr>";
						
 					}
				

 				echo "</table>"; // tablo sonu

				
			}
		   
		    else{
 			echo "<div class='alert alert-danger'>Listelenecek servis kaydı bulunamadı.</div>";
 			}

 ?>
 
</div>

	  <script type='text/javascript'>
 			// kayıt silme işlemini onayla
 			function silme_onay( id ){

 				var cevap = confirm('Kaydı silmek istiyor musunuz?');
 				if (cevap){
					 // kullanıcı evet derse,
					 // id bilgisini sil.php sayfasına yönlendirir
 					window.location = 'servis-sil.php?id=' + id;
 				}
 			}
		  </script>
	  
	  
<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>
