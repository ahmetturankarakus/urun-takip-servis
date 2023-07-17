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
  <div class="navbar navbar-dark bg-dark"><a class="navbar-brand" href="editorpanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	</div>
<br>
    	<div class="container">
			 <div class="page-header">
			 		<h1>Ürün Ekle</h1>
			 </div>
			
		
			<?php
			if($_POST){
				 // veritabanı yapılandırma dosyasını dahil et
				 include '../pdoconfig.php';
				 try{
				 // kayıt ekleme sorgusu
				 	$sorgu = "INSERT INTO urunler SET marka= :marka, model= :model, seri= :seri, demirbas= :demirbas, firma= :firma, calisma= :calisma, giris_tarihi= :giris_tarihi, resim=:resim, kategori_id=:kategori_id, personel_id=:personel_id, durum_id= :durum_id";
				 // sorguyu hazırla
				 	$stmt = $con->prepare($sorgu);
				 // post edilen değerler
					
					$marka=htmlspecialchars(strip_tags($_POST['marka']));
				 	$model=htmlspecialchars(strip_tags($_POST['model']));
					$seri=htmlspecialchars(strip_tags($_POST['seri']));
				 	$demirbas=htmlspecialchars(strip_tags($_POST['demirbas']));
					$firma=htmlspecialchars(strip_tags($_POST['firma']));
				 	$calisma=htmlspecialchars(strip_tags($_POST['calisma']));
					$durum_id=htmlspecialchars(strip_tags($_POST['durum_id']));
					$kategori_id=htmlspecialchars(strip_tags($_POST['kategori_id']));
					$personel_id=htmlspecialchars(strip_tags($_POST['personel_id']));

					 
					 // yeni 'resim' alanı
					$resim=!empty($_FILES["resim"]["name"]) ? uniqid() . "-" .
					basename($_FILES["resim"]["name"]) : "";
					$resim=htmlspecialchars(strip_tags($resim));
					 
				 // parametreleri bağla
					$stmt->bindParam(':marka', $marka);
				 	$stmt->bindParam(':model', $model);
					$stmt->bindParam(':seri', $seri);
				 	$stmt->bindParam(':demirbas', $demirbas);
					$stmt->bindParam(':firma', $firma);
				 	$stmt->bindParam(':calisma', $calisma);
				 	$stmt->bindParam(':durum_id', $durum_id);
					$stmt->bindParam(':kategori_id', $kategori_id);
					$stmt->bindParam(':personel_id', $personel_id);
					$stmt->bindParam(':resim', $resim); 
					
				 // ürünün veritabanına kaydedildiği tarihi belirt
					 $giris_tarihi=date('Y-m-d H:i:s');
					 $stmt->bindParam(':giris_tarihi', $giris_tarihi);
				 // sorguyu çalıştır
				 if($stmt->execute()){
					 $last_id = $con->lastInsertId();
					 $sonid= $last_id;

				 	echo "<div class='alert alert-success'>Ürün kaydedildi. ID Numarası :$last_id</div>";
					 	
						 // resim boş değilse yükle
						if($resim){
							 $hedef_klasor = "../img/cihazfoto/";
							 $hedef_dosya = $hedef_klasor . $resim;
							 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
							 // hata mesajı
							 $dosya_yukleme_hata_msj="";

						// sadece belirli dosya türlerine izin ver
						$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");

						if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
						 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar
						yüklenebilir.</div>";

						}

						// aynı isimde başka bir resim var mı?
						if(file_exists($hedef_dosya)){
						$dosya_yukleme_hata_msj.="<div>Aynı isimde başka bir resim dosyası var.</div>";

							}
							// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
							if($_FILES['resim']['size'] > (1024000)){
							 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını aşamaz.</div>";
							}
							// eğer $dosya_yukleme_hata_msj boşsa
							if(empty($dosya_yukleme_hata_msj)){
								 // hata yok, o zaman dosya sunucuya yüklenir
								 if(move_uploaded_file($_FILES["resim"]["tmp_name"], $hedef_dosya)){
								 // dosya başarıyla yüklendi
								 }
								 else{
								 echo "<div class='alert alert-danger'>";
									 echo "<div>Dosya yüklenemedi.</div>";
									 echo "<div>Dosyayı yüklemek için kaydı güncelleyin.</div>";
								 echo "</div>";
								 }
								}
								// eğer $dosya_yukleme_hata_msj boş değilse
								else{
									 // hata var, o halde kullanıcıyı bilgilendir
									 echo "<div class='alert alert-danger'>";
										 echo "<div>{$dosya_yukleme_hata_msj}</div>";
										 echo "<div>Dosyayı yüklemek için kaydı güncelleyin.</div>";
									 echo "</div>";
							}
												}
					 
					 
					$tablo = "CREATE TABLE servis_".$sonid." (
						id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						aciklama VARCHAR(800) NOT NULL,
						fiyat VARCHAR(500),
						tarih TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						resim VARCHAR(200) NOT NULL
						)";
					 $con->exec($tablo);
					
  					 echo "<div class='alert alert-success'>Tablo başarıyla oluşturuldu</div>";

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
			method="post" enctype="multipart/form-data">
			 	<table class='table table-hover table-responsive table-bordered'>
					
					<tr>
			 			<td>Marka</td>
			 			<td><input type='text' name='marka' class='form-control' /></td>
			 		</tr>
					<tr>
			 			<td>Model</td>
			 			<td><input type='text' name='model' class='form-control' /></td>
			 		</tr>
					<tr>
			 			<td>Seri No</td>
			 			<td><input type='text' name='seri' class='form-control' /></td>
			 		</tr>
					<tr>
			 			<td>Demirbaş No</td>
			 			<td><input type='text' name='demirbas' class='form-control' /></td>
			 		</tr>
					<tr>
			 			<td>Firma/İsim</td>
			 			<td><input type='text' name='firma' class='form-control' /></td>
			 		</tr>
					<tr>
			 			<td>Çalışma Yeri</td>
			 			<td><input type='text' name='calisma' class='form-control' /></td>
			 		</tr>
					
				
					 <tr>
					 <td>Durum</td>
					 <td>
						 <?php
						 // veritabanı yapılandırma dosyasını dahil et
						 include '../pdoconfig.php';
						 // kayıt listeleme sorgusu
						 $sorgu='SELECT id, adi FROM durum';
						 $stmt = $con->prepare($sorgu); // sorguyu hazırla
						 $stmt->execute(); // sorguyu çalıştır
						 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
						 ?>
						 <select name='durum_id' class='form-control'>
						 <?php foreach ($veri as $kayit) { ?>
						 <option value="<?php echo $kayit["id"] ?>">
						 <?php echo $kayit["adi"] ?>
						 </option>
						 <?php } ?>
						 </select>
					 </td>
					</tr>
		
					
					<tr>
					 <td>Kategori</td>
					 <td>
						 <?php
						 // veritabanı yapılandırma dosyasını dahil et
						 include '../pdoconfig.php';
						 // kayıt listeleme sorgusu
						 $sorgu='SELECT id, kategoriadi FROM kategoriler';
						 $stmt = $con->prepare($sorgu); // sorguyu hazırla
						 $stmt->execute(); // sorguyu çalıştır
						 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
						 ?>
						 <select name='kategori_id' class='form-control'>
						 <?php foreach ($veri as $kayit) { ?>
						 <option value="<?php echo $kayit["id"] ?>">
						 <?php echo $kayit["kategoriadi"] ?>
						 </option>
						 <?php } ?>
						 </select>
					 </td>
					</tr>
					
					
					<tr>
						 <td>Personel</td>
						 <td>
							 <?php
								 // veritabanı yapılandırma dosyasını dahil et
								 include '../pdoconfig.php';
								 // kayıt listeleme sorgusu
								 $sorgu='SELECT id, personeladi FROM personel';
								 $stmt = $con->prepare($sorgu); // sorguyu hazırla
								 $stmt->execute(); // sorguyu çalıştır
								 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
								 ?>
								 <select name='personel_id' class='form-control'>
								 <?php foreach ($veri as $kayit) { ?>
								 	<option value="<?php echo $kayit["id"] ?>">
										<?php echo $kayit["personeladi"] ?>
								 	</option>
								 <?php } ?>
								 </select>
						 </td>
					</tr>

					<tr>
						 <td>Fotoğraf</td>
						 <td><input type="file" name="resim" /></td>
					</tr>
						
					<tr>
			 			<td></td>
			 			<td>
			 				<input type='submit' value='Kaydet' class='btn btn-primary' />
			 				<a href='tum-urunler.php' class='btn btn-danger'>Ürün Listesi</a>
							<a href='editorpanel.php' class='btn btn-warning'>Ana Sayfa</a>
			 			</td>
					</tr>
			 	</table>
			</form>
			
			
	  	</div> <!-- container -->
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>