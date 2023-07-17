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
  <div class="navbar navbar-dark bg-dark"><a class="navbar-brand" href="adminpanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	</div>
<br>
<div class="container">
	
	
	
 	<div class="page-header">
 		<h1>Servis Düzenle</h1>
 	</div>
	
	
	
	<?php
	
	
		
		 // gelen parametre değerini oku, bizim örneğimizde bu Id bilgisidir
		$id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');	
		 // veritabanı bağlantı dosyasını dahil et
		 include "../pdoconfig.php";

		 // aktif kayıt bilgilerini oku
		 try {
				 // seçme sorgusunu hazırla
				 $sorgu = "SELECT*FROM servis_".$_SESSION['urunid']." WHERE id = ? LIMIT 0,1";
				 
			 	 $stmt = $con->prepare( $sorgu );

				 // id parametresini bağla (? işaretini id değeri ile değiştir)
				 $stmt->bindParam(1, $id);

				 // sorguyu çalıştır
				 $stmt->execute();

				 // okunan kayıt bilgilerini bir değişkene kaydet
				 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

				 // formu dolduracak değişken bilgileri
			 				   
				
				 $aciklama= $kayit["aciklama"];
			 	 $fiyat= $kayit["fiyat"];
			 	 $tarih = $kayit['tarih'];
		}
				 // hatayı göster
		 catch(PDOException $exception){
		 	die('HATA: ' . $exception->getMessage());
		 }
 	?>

	
	
	
 	<!-- kaydı güncelleyecek PHP kodu burada yer alacak -->
	<?php
		 // Kaydet butonu tıklanmışsa
		 if($_POST){

		 try{
			 // güncelleme sorgusu
			 // çok fazla parametre olduğundan karışmaması için
			 // soru işaretleri yerine etiketler kullanacağız
			 $sorgu = "UPDATE servis_".$_SESSION['urunid']." SET
			aciklama=:aciklama,
			fiyat=:fiyat,
			tarih=:tarih
			WHERE 
			id=:id";
			 // sorguyu hazırla
			 $stmt = $con->prepare($sorgu);

			 // gelen bilgileri değişkenlere kaydet
	
			 $aciklama=htmlspecialchars(strip_tags($_POST['aciklama']));
			 $fiyat=htmlspecialchars(strip_tags($_POST['fiyat']));
			 $tarih=htmlspecialchars(strip_tags($_POST['tarih']));



			 // parametreleri bağla
			 $stmt->bindParam(':id', $id);
			 $stmt->bindParam(':aciklama', $aciklama);
			 $stmt->bindParam(':fiyat', $fiyat);
			 $stmt->bindParam(':tarih', $tarih);



			 // sorguyu çalıştır
			 if($stmt->execute()){
			 	echo "<div class='alert alert-success'>Kayıt güncellendi.</div>";
			 }
			 
			 else{
			 	echo "<div class='alert alert-danger'>Kayıt
			güncellenemedi.</div>";
			 }

			 }
			 // hata varsa göster
		 catch(PDOException $exception){
		 	die('HATA: ' . $exception->getMessage());
		 }
	 }
 ?>

	
	
	
	 <!-- kayıt bilgilerini güncelleyebileceğimiz HTML formu -->
	 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] .
	"?id={$id}");?>" method="post">
			 <table class='table table-hover table-responsive table-bordered'>
				 
				 
				<tr>
					 <td>Açıklama</td>
					 <td><input type='text' name='aciklama' value="<?php echo
					htmlspecialchars($aciklama, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr> 
				 
				 
				<tr>
					 <td>Fiyat</td>
					 <td><input type='text' name='fiyat' value="<?php echo
					htmlspecialchars($fiyat, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr>
				
				<tr>
					<td>Tarih</td>
					 <td><input type='text' name='tarih' value="<?php echo
					htmlspecialchars($tarih, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr>

				 <tr>
					 <td></td>
					 <td>
					 <input type='submit' value='Düzenle' class='btn btn-primary' />
					 <a href='tum-urunler.php' class='btn btn-danger'>Cihaz Listesi</a>
					 <a href='adminpanel.php' class='btn btn-warning'>Ana Sayfa</a>
					 </td>
				 </tr>
			 </table>
	 </form>

</div>
	  
	  
	  <?php
	
}else{
		header("Location: index.php");
		exit();
}

?>