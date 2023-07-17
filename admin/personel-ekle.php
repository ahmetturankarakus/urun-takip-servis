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
 <h1>Personel Ekle</h1>
 </div>

<?php
	if($_POST){
	 // veritabanı yapılandırma dosyasını dahil et
	 include '../pdoconfig.php';
	 try{
		 // kayıt ekleme sorgusu
		 $sorgu = "INSERT INTO personel SET personeladi=:personeladi,
		aciklama=:aciklama";
		 
		 // sorguyu hazırla
		 $stmt = $con->prepare($sorgu);
		 
		 // post edilen değerler
		 $personeladi=htmlspecialchars(strip_tags($_POST['personeladi']));
		 $aciklama=htmlspecialchars(strip_tags($_POST['aciklama']));
		 
		 // parametreleri bağla
		 $stmt->bindParam(':personeladi', $personeladi);
		 $stmt->bindParam(':aciklama', $aciklama);
		 
		 // sorguyu çalıştır
		 if($stmt->execute()){
		 echo "<div class='alert alert-success'>Personel kaydedildi.</div>";
		 }
		 
		 else{
			 
		 echo "<div class='alert alert-danger'>Personel kaydedilemedi.</div>";
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
			 <td>Personel Ad Soyad</td>
			 <td><input type='text' name='personeladi' class='form-control' /></td>
		 </tr>
		 <tr>
			 <td>Görevi</td>
			 <td><textarea name='aciklama' class='form-control'></textarea></td>
		 </tr>
		 <tr>
		 <td></td>
			 <td>
			 <input type='submit' value='Kaydet' class='btn btn-primary' />
			 <a href='personel-liste.php' class='btn btn-danger'>Personel Listesi</a>
			 <a href='adminpanel.php' class='btn btn-warning'>Ana Sayfa</a>
			 </td>
			 
		 </tr>
	 </table>
</form>

</div> <!-- container -->
	  
	  
	  
	  
<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>