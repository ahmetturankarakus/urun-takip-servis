<?php

include "../pdoconfig.php";
try {
 // kaydın id bilgisini al
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: ID bilgisi bulunamadı.');
 $sonid= $id;
	
 $sorgu = "DELETE FROM urunler WHERE id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $id);

 $sorgu1 = "DROP TABLE servis_".$sonid."";
 $stmt1 = $con->prepare($sorgu1);
 $stmt1->bindParam(1, $sonid);
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

try {
 // kaydın id bilgisini al
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: ID bilgisi bulunamadı.');
 $sonid= $id;

 $sorgu1 = "DROP TABLE servis_".$sonid."";
 $stmt1 = $con->prepare($sorgu1);
 $stmt1->bindParam(1, $sonid);
 // sorguyu çalıştır
 if($stmt1->execute()){
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
