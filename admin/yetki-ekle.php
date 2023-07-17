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
  <div class="navbar navbar-light bg-light"><a class="navbar-brand" href="adminpanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	</div>
<br>
    	<div class="container">
			 <div class="page-header">
			 		<h1>Yeni Yetkilendirme Ekle</h1>
			 </div>
			 
			
			<?php
			if($_POST){
				 // veritabanı yapılandırma dosyasını dahil et
				 include '../pdoconfig.php';
				 try{
				 // kayıt ekleme sorgusu
				 	$sorgu = "INSERT INTO permission SET kullanici_id=:kullanici_id, urun_id=:urun_id";
				 // sorguyu hazırla
				 	$stmt = $con->prepare($sorgu);
				 // post edilen değerler
					$kullanici_id=htmlspecialchars(strip_tags($_POST['kullanici_id']));
					$urun_id=htmlspecialchars(strip_tags($_POST['urun_id']));
					 
				 // parametreleri bağla
					$stmt->bindParam(':kullanici_id', $kullanici_id);
					$stmt->bindParam(':urun_id', $urun_id);
					 
				 // sorguyu çalıştır
				 if($stmt->execute()){
				 	echo "<div class='alert alert-success'>Ürün kaydedildi.</div>";
				 }
				 else{
				 	echo "<div class='alert alert-danger'>Ürün kaydedilemedi.</div>";
				 }
				 }
				 // hatayı göster
				 catch(PDOException $exception){
				 	die('ERROR: ' . $exception->getMessage());
				 }
				}
			?>
			
			
			 <!-- Ürün bilgilerini girmek için kullanılacak html formu -->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
			method="post">
			 	<table class='table table-hover table-responsive table-bordered'>	
					<tr>
						 <td>Ürün ID - Marka - Model</td>
						 <td>
							 <?php
								 // veritabanı yapılandırma dosyasını dahil et
								 include '../pdoconfig.php';
								 // kayıt listeleme sorgusu
								 $sorgu='SELECT id, marka, model, seri FROM urunler';
								 $stmt = $con->prepare($sorgu); // sorguyu hazırla
								 $stmt->execute(); // sorguyu çalıştır
								 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
								 ?>
								 <select name='urun_id' class='form-control'>
								 <?php foreach ($veri as $kayit) { ?>
								 	<option value="<?php echo $kayit[("id")] ?>">
										(<?php echo $kayit['id'] ?>) 
										(<?php echo $kayit['marka'] ?>) 
										(<?php echo $kayit['model'] ?>)
								 	</option>
								 <?php } ?>
								 </select>
						 </td>
					</tr> 
					
					<tr>
						 <td>Kullanıcı ID - Ad Soyad - Kullanıcı Adı</td>
						 <td>
							 <?php
								 // veritabanı yapılandırma dosyasını dahil et
								 include '../pdoconfig.php';
								 // kayıt listeleme sorgusu
								 $sorgu='SELECT id, kadi, adsoyad FROM kullanicilar';
								 $stmt = $con->prepare($sorgu); // sorguyu hazırla
								 $stmt->execute(); // sorguyu çalıştır
								 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
								 ?>
								 <select name='kullanici_id' class='form-control'>
								 <?php foreach ($veri as $kayit) { ?>
								 	<option value="<?php echo $kayit["id"] ?>">
										(<?php echo $kayit["id"] ?>)
										(<?php echo $kayit["adsoyad"] ?>)
										(<?php echo $kayit["kadi"] ?>)
								 	</option>
								 <?php } ?>
								 </select>
						 </td>
					</tr>

					<tr>
			 			<td></td>
			 			<td>
			 				<input type='submit' value='Kaydet' class='btn btn-primary' />
			 				<a href='yetkiler.php' class='btn btn-danger'>Tüm Yetki Listesi</a>
							<a href='adminpanel.php' class='btn btn-warning'>Ana Sayfa</a>
			 			</td>
					</tr>
			 	</table>
			</form>
			
	  	</div> <!-- container -->
	  
		

  </body>
</html>

<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>