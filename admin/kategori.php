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
    <link href="../public/bootstrapssss/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    
  <!-- Default panel contents -->
  <div class="navbar navbar-dark bg-dark"><a class="navbar-brand" href="adminpanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	  
	</div>
<br>
  <div class="panel-body">

	  
        <?php
		  $alanadi = $_SERVER['REQUEST_URI']; // çıktısı: /index.php?g=41455466448
		  $_SESSION['alanadi'] = $alanadi;
		  $url=$_GET['id']; // çıktısı: 41455466448 olacaktır. (sadece g ye yüklenen değeri alır.)	
		  $_SESSION['kid'] = $url;
		  $kid = $url;
		?>
		   
		<div class="container">
			<!-- ürün arama formu -->
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"	method="get">
				<div class="row">
					<div class="col-xs-6 col-md-4 pull-right">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Seri Numarası İle Ürün Ara"
							name="aranan" value="<?php echo isset($_GET['aranan']) ? $_GET['aranan'] : ""; ?>"
							/>
							<div class="input-group-btn">
								<button class="btn btn-success" type="submit">
								<span class="glyphicon glyphicon-search"></span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>

			</div>
       <div class="container">
		  
				<?php echo "<a href='excel.php?id={$url}' class='btn btn-success'><i class='dwn'></i>Excel Çıktısı Al</a>";  ?>
	  </div>
		   <br>
		   
		   
		   <div class="container">
		   <?php
		
		   // SAYFALANDIRMA DEĞİŞKENLERİ
 		   // sayfa parametresi aktif sayfa numarasını gösterir, parametre boşsa değeri 1'dir
	 	  $sayfa = isset($_GET['sayfa']) ? $_GET['sayfa'] : 1;

	 	  // bir sayfada görüntülenecek kayıt sayısı
	 	  $sayfa_kayit_sayisi = 30;

		  // sorgudaki LIMIT başlangıç değerini hesapla
		  $ilk_kayit_no = ($sayfa_kayit_sayisi * $sayfa) - $sayfa_kayit_sayisi;

		   
            include("../pdoconfig.php");
		   	
		   
		   	$islem = isset($_GET['islem']) ? $_GET['islem'] : "";
			$aranan = isset($_GET['aranan']) ? $_GET['aranan'] : "";
 			$arama_sarti = isset($_GET['aranan']) ? "%".$_GET['aranan']."%" : "%";
            $sorgu = ("SELECT urunler.id, urunler.marka, urunler.model, urunler.seri, urunler.demirbas, urunler.firma, urunler.calisma, durum.adi FROM urunler LEFT JOIN durum ON urunler.durum_id = durum.id WHERE urunler.kategori_id = ".$url." AND urunler.seri LIKE :aranan ORDER BY urunler.id DESC LIMIT :ilk_kayit_no, :sayfa_kayit_sayisi");
			$stmt = $con->prepare($sorgu);
		    $stmt->bindParam(":ilk_kayit_no", $ilk_kayit_no, PDO::PARAM_INT);
		    $stmt->bindParam(":sayfa_kayit_sayisi", $sayfa_kayit_sayisi, PDO::PARAM_INT);
			$stmt->bindParam(":aranan", $arama_sarti);
            $stmt ->execute();
		    $sayi = $stmt->rowCount();

		   		
		   
		    if($sayi>0){

				echo "<table class='table table-hover table-responsive table-bordered'>";
					//tablo başlangıcı
 					//tablo başlıkları
 				echo "<tr>";
 					echo "<th>ID</th>";
 					echo "<th>Marka</th>";
 					echo "<th>Model</th>";
 					echo "<th>Seri No</th>";
					echo "<th>Demirbaş No</th>";
 					echo "<th>Firma/İsim</th>";
					echo "<th>Çalışma Yeri</th>";
					echo "<th>Durum</th>";
					echo "<th>İşlem</th>";
				echo "</tr>";

 					while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
 					// tablo alanlarını değişkene dönüştürür
 					// $kayit['urunadi'] => $urunadi
 						extract($kayit);

 						// her kayıt için yeni bir tablo satırı oluştur
 						echo "<tr>";
 							echo "<td>{$id}</td>";
 							echo "<td>{$marka}</td>";
 							echo "<td>{$model}</td>";
							echo "<td>{$seri}</td>";
							echo "<td>{$demirbas}</td>";
							echo "<td>{$firma}</td>";
							echo "<td>{$calisma}</td>";
							echo "<td>{$adi}</td>";
 							echo "<td>";
 							// kayıt detay sayfa bağlantısı
 								echo "<a href='urun-detay.php?id={$id}' class='btn btn-info'><span
class='glyphicon glyphicon glyphicon-eye-open'></span> Detay</a>";
								
								echo "<a href='qr-olustur.php?id={$id}' class='btn btn-warning'><span class='glyphicon glyphicon glyphicon-eye-open'></span> QR Oluştur</a>";
								
								echo "<a href='urun-duzenle.php?id={$id}' class='btn btn-success'><span
class='glyphicon glyphicon glyphicon-edit'></span>Düzenle</a>";
						
								echo "<a href='#' onclick='silme_onay({$id});' class='btn btn-danger'><span
class='glyphicon glyphicon glyphicon-remove-circle'></span> Sil</a>";

							echo "</td>";
 						echo "</tr>";
 					}
				

 				echo "</table>"; // tablo sonu
				
				
				// SAYFALANDIRMA
				// toplam kayıt sayısını hesapla
				$sorgu = "SELECT COUNT(*) as kayit_sayisi FROM urunler WHERE kategori_id = ".$url." AND seri LIKE :aranan";
				$stmt = $con->prepare($sorgu);
				$stmt->bindParam(":aranan", $arama_sarti);


				// sorguyu çalıştır
				$stmt->execute();
				

				// kayıt sayısını oku
				$kayit = $stmt->fetch(PDO::FETCH_ASSOC);
			    $kayit_sayisi = $kayit['kayit_sayisi'];
				
				// kayıtları sayfalandır
				
				$sayfa_url="kategori.php?id={$kid}&aranan=";
				include_once "sayfalama.php";
			
				
			}
		   
		    else{
 			echo "<div class='alert alert-danger'>Listelenecek kayıt bulunamadı.</div>";
 			}

		    ?>
		</div>
	  
	   <br>
        <div class="container">
			
			<?php
                echo "Sayfadaki Kayıt Sayısı: $kayit_sayisi";
			?>
	
	  </div>
	  <br>
	  
		   
		<script type='text/javascript'>
 			// kayıt silme işlemini onayla
 			function silme_onay( id ){

 				var cevap = confirm('Kaydı silmek istiyor musunuz?');
 				if (cevap){
					 // kullanıcı evet derse,
					 // id bilgisini sil.php sayfasına yönlendirir
 					window.location = 'urun-sil.php?id=' + id;
 				}
 			}
		  </script>

		   
<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>