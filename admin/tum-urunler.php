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
    <link href="../public/bootstrapssss/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    
  <!-- Default panel contents -->
  <div class="navbar navbar-dark bg-dark"><a class="navbar-brand" href="adminpanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	  
	</div>
<br>
  <div class="panel-body">

  <br>

		
		<br>

		<div class="panel-body">
    

			<?php
	
		 include "../pdoconfig.php";
			
		 // bütün kayıtları seç
		 $sorgu = "SELECT*FROM kategoriler ORDER BY id ASC";
		 $stmt = $con->prepare($sorgu);
		 $stmt->execute();

		 // geriye dönen kayıt sayısı
		 $sayi = $stmt->rowCount();


		 //kayıt varsa listele
		 if($sayi>0){

			 echo "<table class='table table-hover table-responsive table-bordered'>";
			 //tablo başlangıcı
			 //tablo başlıkları
		

			 // tablo verilerinin okunması
			 while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
				 // tablo alanlarını değişkene dönüştürür
				 // $kayit['kategoriadi'] => $kategoriadi
				 extract($kayit);

				 // her kayıt için yeni bir tablo satırı oluştur
				 echo "<tr>";
				 	
				 	 echo "<td class='bg-warning'> <a href='kategori.php?id={$id}'><img src='../img/kategorifoto/{$resim}' style='width:150px;' </td>";
				 
					 echo "<td class='bg-info'>";
						 echo "<a href='kategori.php?id={$id}' class='btn btn-warning'> {$kategoriadi}</a>";
					 echo "</td>";
				 
				 echo "</tr>";
			 }


			 echo "</table>"; // tablo sonu
			

		 }
		 // kayıt yoksa mesajla bildir
		 else{
		 		echo "<div class='alert alert-danger'>Listelenecek kayıt bulunamadı.</div>";
		 }
		
		
			
			?>
			
			
			
			
			
			
	<!--<div class="row">


		<div class="col-sm-6 col-md-4" >
		 <div class="thumbnail">
		   <img src="../public/img/elektro.png" style="height: 170px;" alt="...">
		   <div class="caption">
		   
			 <center><a href="santrifuj.php" class="btn btn-success"  role="button">Santrifüj</a> </center>
		   </div>
		 </div>
	   </div>

	   <div class="col-sm-6 col-md-4">
		 <div class="thumbnail">
		   <img src="../public/img/elektro2.png"  style="height: 170px;" alt="...">
		   <div class="caption">
		   
			 <center><a href="power.php" class="btn btn-success" role="button">Power</a> </center>
		   </div>
		 </div>
	   </div>
		
		
		<div class="col-sm-6 col-md-4">
		 <div class="thumbnail">
		   <img src="../public/img/elektro3.png" style="height: 170px;" alt="...">
		   <div class="caption">
		   
			 <center><a href="elektronik.php" class="btn btn-success"  role="button">Elektronik</a> </center>
		   </div>
		 </div>
	   </div> 
</div>-->

       
		   
		   
		<script type='text/javascript'>
 			// kayıt silme işlemini onayla
 			function silme_onay( id ){

 				var cevap = confirm('Kaydı silmek istiyor musunuz?');
 				if (cevap){
					 // kullanıcı evet derse,
					 // id bilgisini sil.php sayfasına yönlendirir
 					window.location = 'urun-sil.php?id=' + id;
 				}
 			}
		  </script>

		   
<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>