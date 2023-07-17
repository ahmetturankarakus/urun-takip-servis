<?php 
session_start();
ob_start();

if (isset($_SESSION['id']) && isset($_SESSION['kadi'])) {

 ?>

<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inncrea Ürün Takip Sistemi</title>
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="../public/sytle.css" rel="stylesheet">
    <link href="../public/bootstrapssss/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    
  <!-- Default panel contents -->
  <div class="navbar navbar-dark bg-dark"><a class="navbar-brand" href="musteripanel.php">
    <img src="../img/inncrealogo.png" width="100" height="35" class="d-inline-block align-top" alt=""></a>
	  
	</div>
<br>
  <div class="panel-body">

  <br>

       <div class="container">
		   
		   
		   <h2> HOŞGELDİNİZ SAYIN <?php echo $_SESSION['kadi']?> </h2>
           <h5> <b>Aşağıda ürünleriniz listelenmektedir. </b></h5>
		    
		   
		   
           <?php
		
            include("../pdoconfig.php");
		   
		    $kullanicisor = $_SESSION['id'];
			$sorgu1 = ("SELECT permission.urun_id, urunler.marka, urunler.model, urunler.seri, urunler.demirbas, urunler.firma, urunler.calisma, durum.adi FROM permission 
            LEFT JOIN urunler ON permission.urun_id = urunler.id 
            LEFT JOIN durum ON urunler.durum_id = durum.id WHERE permission.kullanici_id={$kullanicisor} ORDER BY permission.urun_id ASC");
			
			$stmt = $con->prepare($sorgu1);
            $stmt ->execute();
			$sayi1 = $stmt->rowCount();
	
	
			if($sayi1>0){

				echo "<table class='table table-hover table-responsive table-bordered'>";
					//tablo başlangıcı
 					//tablo başlıkları
 				echo "<tr>";
 					echo "<th>ID</th>";
                     echo "<th>Marka</th>";
                     echo "<th>Model</th>";
                     echo "<th>Seri No</th>";
                     echo "<th>Demirbaş No</th>";
                     echo "<th>Firma</th>";
                     echo "<th>Çalışma</th>";
                     echo "<th>Durum</th>";
                     echo "<th>İşlem</th>";

				echo "</tr>";
				
 					while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
 					// tablo alanlarını değişkene dönüştürür
 					// $kayit['urunadi'] => $urunadi
 						extract($kayit);
						
 						// her kayıt için yeni bir tablo satırı oluştur
 						echo "<tr>";
 							echo "<td>{$urun_id}</td>";
                            echo "<td>{$marka}</td>";
                            echo "<td>{$model}</td>";
                            echo "<td>{$seri}</td>";
                            echo "<td>{$demirbas}</td>";
                            echo "<td>{$firma}</td>";
                            echo "<td>{$calisma}</td>";
                            echo "<td>{$adi}</td>";
                            echo "<td>";
                            // kayıt detay sayfa bağlantısı
 								echo "<a href='urun-detay.php?id={$urun_id}' class='btn btn-info'><span class='glyphicon glyphicon glyphicon-eye-open'></span> Detay</a>";
								
                                 echo "<a href='qr-olustur.php?id={$urun_id}' class='btn btn-warning'><span class='glyphicon glyphicon glyphicon-eye-open'></span> QR Oluştur</a>";
 
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
	  <div class="container">
      
              <center>
                  <a href="../logout.php" class="btn btn-danger"  role="button">Çıkış Yap</a>
              </center>

        </div>
	 
	  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	  
	  
	  <?php
	
}else{
		header("Location: index.php");
		exit();
}

?>