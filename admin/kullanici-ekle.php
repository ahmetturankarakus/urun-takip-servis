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
		 <h1>Kullanıcı Ekle</h1>
	 </div>
	 
	<?php
	 if($_POST){
	 // veritabanı yapılandırma dosyasını dahil et
	 include '../pdoconfig.php';
	 try{
		 // kayıt ekleme sorgusu
		 $sorgu = "INSERT INTO kullanicilar SET adsoyad=:adsoyad, kadi=:kadi,
		sifre=:sifre, yetki=:yetki";
		 
		 // sorguyu hazırla
		 $stmt = $con->prepare($sorgu);
		 
		 // post edilen değerler
		 $adsoyad=htmlspecialchars(strip_tags($_POST['adsoyad']));
		 $kadi=htmlspecialchars(strip_tags($_POST['kadi']));
		 $sifre=htmlspecialchars(strip_tags($_POST['sifre']));
		 $yetki=htmlspecialchars(strip_tags($_POST['yetki']));
		 
		 // parametreleri bağla
		 $stmt->bindParam(':adsoyad', $adsoyad);
		 $stmt->bindParam(':kadi', $kadi);
		 $stmt->bindParam(':sifre', $sifre);
		 $stmt->bindParam(':yetki', $yetki);
		 
		 // sorguyu çalıştır
		 if($stmt->execute()){
		 	echo "<div class='alert alert-success'>Kullanıcı kaydedildi.</div>";
		 }else{
		 	echo "<div class='alert alert-danger'>Kullanıcı kaydedilemedi.</div>";
		 }
		 }
		 // hatayı göster
	 catch(PDOException $exception){
	 die('ERROR: ' . $exception->getMessage());
	 }
	 }
	?>  


		  
	 <!-- Kategori bilgilerini girmek için kullanılacak html formu -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		 <table class='table table-hover table-responsive table-bordered'>
			 <tr>
				 <td>Ad ve Soyad</td>
				 <td><input type='text' name='adsoyad' class='form-control' /></td>
			 </tr>
			 <tr>
				 <td>Kullanıcı adı</td>
				 <td><input type='text' name='kadi' class='form-control' /></td>
			 </tr>
			 <tr>
				 <td>Şifre</td>
				 <td><input type='password' name='sifre' class='form-control' /></td>
			 </tr>
			 <tr>
				 <td>Yetki</td>
				 <td><input type='text' name='yetki' class='form-control' /></td>
			 </tr>
			 <tr>
				 <td></td>
				 <td>
				 <input type='submit' value='Kaydet' class='btn btn-primary' />
				 <a href='kullanici-liste.php' class='btn btn-danger'>Kullanıcı listesi</a>
				 <a href='adminpanel.php' class='btn btn-warning'>Ana Sayfa</a>
				 </td>
			 </tr>
		 </table>
	</form>

		  
</div> <!-- container -->

<div class="container">
	<h3><font color="#ff0000"> Not:</font> <font color="#ff0000"> Supervisor Yetki Kodu : 1</font> <br>
	<font color="#ff0000"> Editör Yetki Kodu : 2</font><br>
	<font color="#ff0000"> Müşteri Yetki Kodu : 3</font><br></h3>

</div>
	  
	  
	  
	  <?php
	
}else{
		header("Location: index.php");
		exit();
}

?>