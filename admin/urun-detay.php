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
 		<h1>Ürün Detay</h1>
 	</div>
	
	<?php
	$id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');	
	$_SESSION['urunid'] = $id;
	// veritabanı bağlantı dosyasını çağır
	include "../pdoconfig.php";
	
	try {
		// seçme sorgusunu hazırla
		$sorgu = "SELECT urunler.id, personel.personeladi  FROM urunler LEFT JOIN personel ON
            urunler.personel_id = personel.id WHERE urunler.id = ? LIMIT 0,1";
		$stmt = $con->prepare( $sorgu );

		// Id parametresini bağla
		$stmt->bindParam(1, $id);

		// sorguyu çalıştır
		$stmt->execute();

		// gelen kaydı bir değişkende sakla
		$kayit = $stmt->fetch(PDO::FETCH_ASSOC);

		// tabloya yazılacak bilgileri değişkenlere doldur
		
		
		$personeladi = $kayit['personeladi'];


		}

		// hatayı göster
	catch(PDOException $exception){
		die('HATA: ' . $exception->getMessage());
		}

?>
<table class='table table-hover table-responsive table-bordered'>

	   <tr>
			<td class='bg-success'>Yetkili Personel</td>
			<td class='bg-success'><?php echo htmlspecialchars($personeladi, ENT_QUOTES); ?></td>
	   </tr>

	   


</table>
</div> 

<div class="container">
	<?php
	$id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');	
	$_SESSION['urunid'] = $id;
	// veritabanı bağlantı dosyasını çağır
	include "../pdoconfig.php";
	
	try {
		// seçme sorgusunu hazırla
		$sorgu = "SELECT urunler.id, durum.adi FROM urunler LEFT JOIN durum ON
            urunler.durum_id = durum.id WHERE urunler.id = ? LIMIT 0,1";
		$stmt = $con->prepare( $sorgu );

		// Id parametresini bağla
		$stmt->bindParam(1, $id);

		// sorguyu çalıştır
		$stmt->execute();

		// gelen kaydı bir değişkende sakla
		$kayit = $stmt->fetch(PDO::FETCH_ASSOC);

		// tabloya yazılacak bilgileri değişkenlere doldur
		
		
		$adi = $kayit['adi'];


		}

		// hatayı göster
	catch(PDOException $exception){
		die('HATA: ' . $exception->getMessage());
		}

?>
<table class='table table-hover table-responsive table-bordered'>

	   <tr>
			<td class='bg-warning'>Cihaz Durum</td>
			<td class='bg-warning'><?php echo htmlspecialchars($adi, ENT_QUOTES); ?></td>
	   </tr>

</table>
</div>      
<div class="container">

<?php
	
	
	$id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');	
	$_SESSION['urunid'] = $id;
	// veritabanı bağlantı dosyasını çağır
 	include "../pdoconfig.php";
	
	try {
		 // seçme sorgusunu hazırla
		 $sorgu = "SELECT urunler.id, urunler.marka, urunler.model, urunler.seri, urunler.demirbas, urunler.firma, urunler.calisma, urunler.resim, kategoriler.kategoriadi   FROM urunler LEFT JOIN kategoriler ON
urunler.kategori_id = kategoriler.id WHERE urunler.id = ? LIMIT 0,1";
		 $stmt = $con->prepare( $sorgu );

		 // Id parametresini bağla
		 $stmt->bindParam(1, $id);

		 // sorguyu çalıştır
		 $stmt->execute();

		 // gelen kaydı bir değişkende sakla
		 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

		 // tabloya yazılacak bilgileri değişkenlere doldur
		 $marka = $kayit['marka'];
		 $model = $kayit['model'];
		 $seri = $kayit['seri'];
		 $demirbas = $kayit['demirbas'];
		 $firma = $kayit['firma'];
		 $calisma = $kayit['calisma'];
		 $resim = htmlspecialchars($kayit['resim'], ENT_QUOTES);
		 $kategoriadi = $kayit['kategoriadi'];


		 }

		 // hatayı göster
	 catch(PDOException $exception){
		 die('HATA: ' . $exception->getMessage());
		 }

 ?>
	
	<table class='table table-hover table-responsive table-bordered'>
		
		 <tr>
			<td>Cihaz Marka</td>
			<td><?php echo htmlspecialchars($marka, ENT_QUOTES); ?></td>
		 </tr>

		 <tr>
			<td>Cihaz Model</td>
			<td><?php echo htmlspecialchars($model, ENT_QUOTES); ?></td>
		 </tr>
		
		<tr>
			 <td>Kategori</td>
			 <td><?php echo htmlspecialchars($kategoriadi, ENT_QUOTES); ?></td>
		</tr>

		 <tr>
			<td>Cihaz Seri No</td>
			<td><?php echo htmlspecialchars($seri, ENT_QUOTES); ?></td>
		 </tr>
		
		 <tr>
			<td>Cihaz Demirbaş No</td>
			<td><?php echo htmlspecialchars($demirbas, ENT_QUOTES); ?></td>
		 </tr>
		
		 <tr>
			<td>Cihaz Firma/İsim</td>
			<td><?php echo htmlspecialchars($firma, ENT_QUOTES); ?></td>
		 </tr>
		
		 <tr>
			<td>Çalışma Yeri</td>
			<td><?php echo htmlspecialchars($calisma, ENT_QUOTES); ?></td>
		 </tr>
			
		<tr>
			 <td>Cihaz Fotoğrafı</td>
			 <td><?php echo $resim ? "<img src='../img/cihazfoto/{$resim}'
			style='width:300px;' />" : "Ürün görseli yok."; ?></td>
		 </tr>

		 <tr>
			<td></td>
				 <td>
					<a href='tum-urunler.php' class='btn btn-danger'>Tüm Ürünler</a>
					<a href='adminpanel.php' class='btn btn-warning'>Ana Sayfa</a>
					<?php 
					echo "<a href='urun-servis.php?id={$id}' class='btn btn-success'>Servis Geçmişi</a>";?>

				 </td>
		 </tr>
 </table>

</div>

<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>