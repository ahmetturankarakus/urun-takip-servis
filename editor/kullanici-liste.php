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
  <div class="navbar navbar-light bg-light"><a class="navbar-brand" href="editorpanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	</div>
<br>
		
	<div class="container">
		 <div class="page-header">
		 	<h1>Kullanıcı Listesi</h1>
		 </div>
		
		
		 <?php
		 // veritabanı bağlantı dosyasını çağır
		 include '../pdoconfig.php';

		  $islem = isset($_GET['islem']) ? $_GET['islem'] : "";
		 // eğer silme (sil.php) sayfasından yönlendirme yapıldıysa
		 if($islem=='silindi'){
		 echo "<div class='alert alert-success'>Kayıt silindi.</div>";
		 }
		 else if($islem=='silinemedi'){
		 echo "<div class='alert alert-danger'>Kayıt silinemedi.</div>";
		 }

		 // bütün kayıtları seç
		 $sorgu = "SELECT id, adsoyad, kadi, yetki FROM kullanicilar ORDER BY id ASC";
		 $stmt = $con->prepare($sorgu);
		 $stmt->execute();

		 // geriye dönen kayıt sayısı
		 $sayi = $stmt->rowCount();

		
		 //kayıt varsa listele
		 if($sayi>0){

		 echo "<table class='table table-hover table-responsive table-bordered'>";
		//tablo başlangıcı
			 
		 //tablo başlıkları
		 echo "<tr>";
			 echo "<th>ID</th>";
			 echo "<th>Ad ve Soyad</th>";
			 echo "<th>Kullanıcı adı</th>";
			 echo "<th>Yetki Kodu</th>";
			 echo "<th>İşlem</th>";
		 echo "</tr>";

				 // tablo verilerinin okunması
		 while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
			 // tablo alanlarını değişkene dönüştürür
			 // $kayit['adsoyad'] => $adsoyad
			 extract($kayit);

			 // her kayıt için yeni bir tablo satırı oluştur
			 echo "<tr>";
				 echo "<td>{$id}</td>";
				 echo "<td>{$adsoyad}</td>";
				 echo "<td>{$kadi}</td>";
				 echo "<td>{$yetki}</td>";
				 echo "<td>";
					 // kayıt güncelleme sayfa bağlantısı
					 echo "<a href='kullanici-duzenle.php?id={$id}' class='btn btn-primary m-r1em'><span
class='glyphicon glyphicon glyphicon-edit'></span> Düzelt</a>";
					 // kayıt silme butonu
					 echo "<a href='#' onclick='silme_onay({$id});' class='btn btn-danger'><span
class='glyphicon glyphicon glyphicon-remove-circle'></span> Sil</a>";
			 echo "</td>";
		 echo "</tr>";
		 }

		 echo "</table>"; // tablo sonu
			 
			  // kayıt ekleme sayfasının linki
		 echo "<a href='kullanici-ekle.php' class='btn btn-primary m-b-1em'>Yeni Kullanıcı Ekle</a>";
		 
		 echo "<a href='adminpanel.php' class='btn btn-warning'>Ana Sayfa</a>";

			 
		 }
		 // kayıt yoksa mesajla bildir
		 else{
		 	echo "<div class='alert alert-danger'>Listelenecek kayıt bulunamadı.</div>";
		 }
		?>


	</div> <!-- /container -->
	<div class="container">
	<h3><font color="#ff0000"> Not:</font> <font color="#ff0000"> Supervisor Yetki Kodu : 1</font> <br>
	<font color="#ff0000"> Editör Yetki Kodu : 2</font><br>
	<font color="#ff0000"> Müşteri Yetki Kodu : 3</font><br></h3>

</div>
		
	<script type='text/javascript'>
	 // kayıt silme işlemini onayla
	 function silme_onay( id ){

		 var cevap = confirm('Kaydı silmek istiyor musunuz?');
		 if (cevap){
		 // kullanıcı evet derse,
		 // id bilgisini sil.php sayfasına yönlendirir
		 	window.location = 'kullanici-sil.php?id=' + id;
		 }
	 }
	</script>

<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>