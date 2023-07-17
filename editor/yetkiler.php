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

    <link href="../public/sytle.css" rel="stylesheet">
    <link href="../public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    
  <!-- Default panel contents -->
  <div class="navbar navbar-light bg-light"><a class="navbar-brand" href="editorpanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	  
	</div>
<br>
  <div class="panel-body">

  <br>
	   <div class="container">
		       <?php echo "<a href='yetki-ekle.php' class='btn btn-danger'>Yeni Yetkilendirme Ekle</a>"; ?>
		        </div>
		        <br>
       <div class="container">
           <?php		   

		   
            include("../pdoconfig.php");
		   	
		   
		   	$islem = isset($_GET['islem']) ? $_GET['islem'] : "";
		    $sorgu = ("SELECT permission.id, permission.kullanici_id, permission.urun_id, kullanicilar.kadi, urunler.model
			FROM permission
			INNER JOIN kullanicilar
			ON permission.kullanici_id = kullanicilar.id
			INNER JOIN urunler
			ON permission.urun_id= urunler.id");
		    $stmt = $con->prepare($sorgu);
            $stmt ->execute();
		    $sayi = $stmt->rowCount();


		   		
		   //kayıt varsa listele
		    if($sayi>0){


				echo "<table class='table table-hover table-responsive table-bordered'>";
					//tablo başlangıcı
 					//tablo başlıkları
 				echo "<tr>";
					echo "<th>Yetkili Kullanıcı ID</th>";
					echo "<th>Yetkili Olduğu Ürün ID</th>";
					echo "<th>İşlem</th>";
				echo "</tr>";

 					while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
 					// tablo alanlarını değişkene dönüştürür
 					// $kayit['urunadi'] => $urunadi
 						extract($kayit);

 						// her kayıt için yeni bir tablo satırı oluştur
 						echo "<tr>";
							echo "<td>({$kullanici_id}) ({$kadi})</td>";
							echo "<td>({$urun_id}) ({$model})</td>";
 							echo "<td>";
 							// kayıt detay sayfa bağlantısı
								echo "<a href='yetki-duzenle.php?id={$id}' class='btn btn-success'><span
class='glyphicon glyphicon glyphicon-edit'></span>Düzenle</a>";
						
								echo "<a href='#' onclick='silme_onay({$id});' class='btn btn-danger'><span
class='glyphicon glyphicon glyphicon-remove-circle'></span> Sil</a>";

							echo "</td>";
 						echo "</tr>";
 					}
				
				

 				echo "</table>"; // tablo sonu
				
			}
		
		    else{
 			echo "<div class='alert alert-danger'>Listelenecek kayıt bulunamadı.</div>";
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
 					window.location = 'yetki-sil.php?id=' + id;
 				}
 			}
		  </script>
	  
	  <?php
	
}else{
		header("Location: index.php");
		exit();
}

?>