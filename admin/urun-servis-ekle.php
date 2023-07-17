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
			 		<h1>Servis Kaydı Ekle</h1>
			 </div>
		

			 	<?php
					$_SERVER['REQUEST_URI']; // çıktısı: /index.php?g=41455466448
					$url=$_GET['id']; // çıktısı: 41455466448 olacaktır. (sadece g ye yüklenen değeri alır.)
				?>


			<?php
			if($_POST){
				 // veritabanı yapılandırma dosyasını dahil et
				 include '../pdoconfig.php';
				 try{
				 // kayıt ekleme sorgusu
				 	$sorgu = "INSERT INTO servis_".$url." SET aciklama= :aciklama, fiyat= :fiyat, tarih= :tarih, resim= :resim";
				 // sorguyu hazırla
				 	$stmt = $con->prepare($sorgu);
				 // post edilen değerler
					
		
					$aciklama=htmlspecialchars(strip_tags($_POST['aciklama']));
					$fiyat=htmlspecialchars(strip_tags($_POST['fiyat']));
					 
					  // yeni 'resim' alanı
					$resim=!empty($_FILES["resim"]["name"]) ? uniqid() . "-" .
					basename($_FILES["resim"]["name"]) : "";
					$resim=htmlspecialchars(strip_tags($resim));
					 
				
	
				 // parametreleri bağla
				
				 	$stmt->bindParam(':aciklama', $aciklama);
					$stmt->bindParam(':fiyat', $fiyat);
					$stmt->bindParam(':resim', $resim);

		
					
				 // ürünün veritabanına kaydedildiği tarihi belirt
					 $tarih=date('Y-m-d H:i:s');
					 $stmt->bindParam(':tarih', $tarih);
				
					 if($stmt->execute()){
						
				 		echo "<div class='alert alert-success'>Servis kaydedildi</div>";
						 	 	
						 // resim boş değilse yükle
						if($resim){
							 $hedef_klasor = "../img/servisfoto/";
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
				 		echo "<div class='alert alert-danger'>Servis kaydedilemedi.</div>";
				 	}
				 }
				 // hatayı göster
				 catch(PDOException $exception){
				 	die('ERROR: ' . $exception->getMessage());
				 }
				}
			?>
			
			
			 <!-- Ürün bilgilerini girmek için kullanılacak html formu -->
			<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>"
			method="post" enctype="multipart/form-data">
			 	<table class='table table-hover table-responsive table-bordered'>
				
				
					 <tr>
			 			<td>Açıklama</td>
			 			<td><input name='aciklama' class='form-control'></td>
			 		</tr>

					<tr>
			 			<td>Fiyat</td>
			 			<td><input name='fiyat' class='form-control'></td>
			 		</tr>
					<tr>
						 <td>Fotoğraf</td>
						 <td><input type="file" name="resim" /></td>
					</tr>
				

					<tr>
			 			<td></td>
			 			<td>
							<input type='submit' value='Kaydet' class='btn btn-primary' />
							<?php echo "<a href='urun-servis.php?id={$url}' class='btn btn-warning'>Servis Listeleri</a>"; ?>
							<a href='adminpanel.php' class='btn btn-danger'>Ana Sayfa</a>
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