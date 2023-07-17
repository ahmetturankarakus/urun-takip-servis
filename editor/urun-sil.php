<?php

include "../pdoconfig.php";
try {
 // kaydın id bilgisini al
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: ID bilgisi bulunamadı.');
	
 $sorgu = "DELETE FROM urunler WHERE id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $id);

 // sorguyu çalıştır
 if($stmt->execute()){
 // kayıt listeleme sayfasına yönlendir
 // ve kullanıcıya kaydın silindiğini
 header('Location: tum-urunler.php?islem=silindi');
 } // veya silinemediğini bildir
 else{
 header('Location: tum-urunler.php?islem=silinemedi');
 }
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>
