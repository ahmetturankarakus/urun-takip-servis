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
 		<h1>Ürün Düzenle</h1>
 	</div>
	
	
	
	<?php
		 // gelen parametre değerini oku, bizim örneğimizde bu Id bilgisidir
		 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');

		 // veritabanı bağlantı dosyasını dahil et
		 include "../pdoconfig.php";

		 // aktif kayıt bilgilerini oku
		 try {
				 // seçme sorgusunu hazırla
				 $sorgu = "SELECT id, marka, model, seri, demirbas, firma, calisma, kategori_id, personel_id, durum_id FROM urunler WHERE id = ? LIMIT 0,1";
				 
			 	 $stmt = $con->prepare( $sorgu );

				 // id parametresini bağla (? işaretini id değeri ile değiştir)
				 $stmt->bindParam(1, $id);

				 // sorguyu çalıştır
				 $stmt->execute();

				 // okunan kayıt bilgilerini bir değişkene kaydet
				 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

				 // formu dolduracak değişken bilgileri
			 				   
				 $marka= $kayit["marka"];
				 $model= $kayit["model"];
				 $seri= $kayit["seri"];
				 $demirbas= $kayit["demirbas"];
				 $firma= $kayit["firma"];
			     $calisma= $kayit["calisma"];
			 	 $kategori_id = $kayit['kategori_id'];
			 	 $personel_id = $kayit['personel_id'];
				 $durum_id= $kayit["durum_id"];
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
			 $sorgu = "UPDATE urunler SET
			marka=:marka,
			model=:model,
			seri=:seri,
			demirbas=:demirbas,
			firma=:firma,
			calisma=:calisma,
			resim=:resim,
			kategori_id=:kategori_id,
			personel_id=:personel_id,
			durum_id=:durum_id
			WHERE 
			id=:id";

			 // sorguyu hazırla
			 $stmt = $con->prepare($sorgu);

			 // gelen bilgileri değişkenlere kaydet
			 $marka=htmlspecialchars(strip_tags($_POST['marka']));
			 $model=htmlspecialchars(strip_tags($_POST['model']));
			 $seri=htmlspecialchars(strip_tags($_POST['seri']));
			 $demirbas=htmlspecialchars(strip_tags($_POST['demirbas']));
			 $firma=htmlspecialchars(strip_tags($_POST['firma']));
			 $calisma=htmlspecialchars(strip_tags($_POST['calisma']));
			 $kategori_id=htmlspecialchars(strip_tags($_POST['kategori_id']));
			 $personel_id=htmlspecialchars(strip_tags($_POST['personel_id']));
			 $durum_id=htmlspecialchars(strip_tags($_POST['durum_id']));

			 // yeni 'resim' alanı
			 $resim=!empty($_FILES["resim"]["name"]) ? uniqid() . "-" .
			 basename($_FILES["resim"]["name"]) : "";
			 $resim=htmlspecialchars(strip_tags($resim));

			 // parametreleri bağla
			 $stmt->bindParam(':id', $id);
			 $stmt->bindParam(':marka', $marka);
			 $stmt->bindParam(':model', $model);
			 $stmt->bindParam(':seri', $seri);
			 $stmt->bindParam(':demirbas', $demirbas);
			 $stmt->bindParam(':firma', $firma);
			 $stmt->bindParam(':calisma', $calisma);
			 $stmt->bindParam(':kategori_id', $kategori_id);
			 $stmt->bindParam(':personel_id', $personel_id);
			 $stmt->bindParam(':durum_id', $durum_id);
			 $stmt->bindParam(':resim', $resim); 



			 // sorguyu çalıştır
			 if($stmt->execute()){
			 	echo "<div class='alert alert-success'>Kayıt güncellendi.</div>";
			  	
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
	"?id={$id}");?>" method="post" enctype="multipart/form-data">
			 <table class='table table-hover table-responsive table-bordered'>
				 <tr>
					 <td>Marka</td>
					 <td><input type='text' name='marka' value="<?php echo
					htmlspecialchars($marka, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr>
				  <tr>
					 <td>Model</td>
					 <td><input type='text' name='model' value="<?php echo
					htmlspecialchars($model, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr>
				 <tr>
					 <td>Seri No</td>
					 <td><input type='text' name='seri' value="<?php echo
					htmlspecialchars($seri, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr>
				 <tr>
					 <td>Demirbaş No</td>
					 <td><input type='text' name='demirbas' value="<?php echo
					htmlspecialchars($demirbas, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr>
				 <tr>
					 <td>Firma/İsim</td>
					 <td><input type='text' name='firma' value="<?php echo
					htmlspecialchars($firma, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr>
				 
				  <tr>
					 <td>Cihaz Çalışma Yeri</td>
					 <td><input type='text' name='calisma' value="<?php echo
					htmlspecialchars($calisma, ENT_QUOTES); ?>" class='form-control' /></td>
				 </tr> 
				
				 
				 
				 <tr>
					 <td>Kategori</td>
					 <td>
						 <?php
						 	// kayıt listeleme sorgusu
						 	$sorgu='SELECT id, kategoriadi FROM kategoriler';
						 		$stmt = $con->prepare($sorgu); // sorguyu hazırla
						 	$stmt->execute(); // sorguyu çalıştır
						 	$veri = $stmt->fetchAll(PDO::FETCH_ASSOC); ; // tablo verilerini oku
						 ?>
						 
						 <select name='kategori_id' class='form-control'>
						 <?php foreach ($veri as $kayit) { ?>
						 <option value="<?php echo $kayit["id"] ?>"
								 
						 <?php if($kayit["id"]==$kategori_id) echo " selected" ?>>
						 <?php echo $kayit["kategoriadi"] ?>
						 </option>
						 <?php } ?>
						 </select>
					 </td>
				</tr>
				 
				 
				 <tr>
					 <td>Personel Adı</td>
					 <td>
						 <?php
						 // kayıt listeleme sorgusu
						 $sorgu='SELECT id, personeladi FROM personel';
						 	$stmt = $con->prepare($sorgu); // sorguyu hazırla
						 $stmt->execute(); // sorguyu çalıştır
						 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); ; // tablo verilerini oku
						 ?>
						 <select name='personel_id' class='form-control'>
						 <?php foreach ($veri as $kayit) { ?>
						 <option value="<?php echo $kayit["id"] ?>"
						 	<?php if($kayit["id"]==$personel_id) echo " selected" ?>>
							 <?php echo $kayit["personeladi"] ?>
						 </option>
						 <?php } ?>
					 </select>
					 </td>
				</tr>
				<tr>
					 <td>Durum</td>
					 <td>
						 <?php
						 // kayıt listeleme sorgusu
						 $sorgu='SELECT id, adi FROM durum';
						 	$stmt = $con->prepare($sorgu); // sorguyu hazırla
						 $stmt->execute(); // sorguyu çalıştır
						 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); ; // tablo verilerini oku
						 ?>
						 <select name='durum_id' class='form-control'>
						 <?php foreach ($veri as $kayit) { ?>
						 <option value="<?php echo $kayit["id"] ?>"
						 	<?php if($kayit["id"]==$durum_id) echo " selected" ?>>
							 <?php echo $kayit["adi"] ?>
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
					 <input type='submit' value='Düzenle' class='btn btn-primary' />
					 <a href='tum-urunler.php' class='btn btn-danger'>Cihaz Listesi</a>
					 <a href='editorpanel.php' class='btn btn-warning'>Ana Sayfa</a>
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