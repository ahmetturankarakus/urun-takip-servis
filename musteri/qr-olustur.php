<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<br>
<br>
<br>
<br>
<br>	

<div class = "container" style="border:3px dashed #f00; width: 250px;">
	<?php
		include "../pdoconfig.php";
		$id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');

		$sorgu = "SELECT*FROM urunler WHERE id = ?";
		$stmt = $con->prepare( $sorgu );

		// Id parametresini bağla
		$stmt->bindParam(1, $id);

		// sorguyu çalıştır
		$stmt->execute();

		function qrCode($s, $w = 250, $h = 250){
			$u = 'https://chart.googleapis.com/chart?chs=%dx%d&cht=qr&chl=%s';
			$url = sprintf($u, $w, $h, $s);
			return $url;
		}

		$qr = qrCode("https://www.inncrea.com.tr/inncreauruntakip/urun-detay.php?id={$id}", 200, 200); // 200x200




	?>
	<img src="<?=$qr?>">
	
	<div class="container" style="border:3px dashed #f00;">
	
	<?php 

	$sorgu1 = ("SELECT id, seri FROM urunler WHERE id= ".$id."");
				$stmt1 = $con->prepare($sorgu1);
				$stmt1 ->execute();
				$sayi1 = $stmt1->rowCount();



				if($sayi1>0){

						while ($kayit = $stmt1->fetch(PDO::FETCH_ASSOC)){
						// tablo alanlarını değişkene dönüştürür
						// $kayit['urunadi'] => $urunadi
							extract($kayit);
							echo "<table class='table table-hover table-responsive'>";
							// her kayıt için yeni bir tablo satırı oluştur
							
							echo "<tr>";
								echo "<td><b>SERİ NO: {$seri}</td>\n";
							echo "</tr>";
							echo "</table>"; // tablo sonu
						}

				}

				else{
				echo "<div class='alert alert-danger'>Listelenecek kayıt bulunamadı.</div>";
				}


	?>
</div>
<br>
</div>

		<?php

		?>




<!-- <a class="btn btn-info" href="#" download role="button">QR İNDİR (çalışmıyor)</a> -->
