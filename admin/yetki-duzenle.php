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
 		<h1>Yetki Düzenle</h1>
 	</div>
	
	
	
	<?php
		 // gelen parametre değerini oku, bizim örneğimizde bu Id bilgisidir
		 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');

		 // veritabanı bağlantı dosyasını dahil et
		 include "../pdoconfig.php";

		 // aktif kayıt bilgilerini oku
		 try {
				 // seçme sorgusunu hazırla
				 $sorgu = "SELECT id, kullanici_id, urun_id FROM permission WHERE id = ? LIMIT 1";
				 
			 	 $stmt = $con->prepare( $sorgu );

				 // id parametresini bağla (? işaretini id değeri ile değiştir)
				 $stmt->bindParam(1, $id);

				 // sorguyu çalıştır
				 $stmt->execute();

				 // okunan kayıt bilgilerini bir değişkene kaydet
				 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

				 // formu dolduracak değişken bilgileri   
			 	 $kullanici_id = $kayit['kullanici_id'];
			 	 $urun_id = $kayit['urun_id'];
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
			 $sorgu = ("UPDATE permission SET
			kullanici_id=:kullanici_id,
			urun_id=:urun_id
			WHERE 
			id=:id");

			 // sorguyu hazırla
			 $stmt = $con->prepare($sorgu);

			 // gelen bilgileri değişkenlere kaydet
			 $kullanici_id=htmlspecialchars(strip_tags($_POST['kullanici_id']));
			 $urun_id=htmlspecialchars(strip_tags($_POST['urun_id']));



			 // parametreleri bağla
			 $stmt->bindParam(':kullanici_id', $kullanici_id);
			 $stmt->bindParam(':urun_id', $urun_id);
			 $stmt->bindParam(':id', $id);



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
	 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
			 <table class='table table-hover table-responsive table-bordered'>
				
				 <tr>
					 <td>Kullanıcı Adı</td>
					 <td>
						 
						 <?php
						 	// kayıt listeleme sorgusu
						 	$sorgu='SELECT id, kadi, adsoyad FROM kullanicilar';
						 		$stmt = $con->prepare($sorgu); // sorguyu hazırla
						 	$stmt->execute(); // sorguyu çalıştır
						 	$veri = $stmt->fetchAll(PDO::FETCH_ASSOC); ; // tablo verilerini oku
						 ?>
						 
						 <select name='kullanici_id' class='form-control'>
						 <?php foreach ($veri as $kayit) { ?>
						 <option value="<?php echo $kayit["id"] ?>"
								 
						 <?php if($kayit["id"]==$kullanici_id) echo " selected" ?>>
						 (<?php echo $kayit["kadi"] ?>)
						 (<?php echo $kayit["adsoyad"] ?>)
						 </option>
						 <?php } ?>
						 </select>
					 </td>
				</tr>
				
				 
				 
				 <tr>
					 <td>Ürün Modeli</td>
					 <td>
						 <?php
						 // kayıt listeleme sorgusu
						 $sorgu='SELECT id, marka, model FROM urunler';
						 	$stmt = $con->prepare($sorgu); // sorguyu hazırla
						 $stmt->execute(); // sorguyu çalıştır
						 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); ; // tablo verilerini oku
						 ?>
						 <select name='urun_id' class='form-control'>
						 <?php foreach ($veri as $kayit) { ?>
						 <option value="<?php echo $kayit["id"] ?>"
						 	<?php if($kayit["id"]==$urun_id) echo " selected" ?>>
							 (<?php echo $kayit['id'] ?>) 
							 (<?php echo $kayit['marka'] ?>) 
							 (<?php echo $kayit['model'] ?>)
						 </option>
						 <?php } ?>
					 </select>
					 </td>
				</tr>
				 
				



				 <tr>
					 <td></td>
					 <td>
					 <input type='submit' value='Düzenle' class='btn btn-primary' />
					 <a href='yetkiler.php' class='btn btn-danger'>Tüm Yetkiler Listesi</a>
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