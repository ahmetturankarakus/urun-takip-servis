<?php
session_start();
ob_start();

 if ($_SESSION["loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: ../login.php");
 }
?>


<?php
// veritabanı ayar dosyasını dahil et
include '../pdoconfig.php';
try {
 // kaydın id bilgisini al
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');
 // silme sorgusu
 $sorgu = "DELETE FROM kategoriler WHERE id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $id);

 // sorguyu çalıştır
 if($stmt->execute()){
 // kayıt listeleme sayfasına yönlendir
 // ve kullanıcıya kaydın silindiğini
 header('Location: kategori-liste.php?islem=silindi');
 } // veya silinemediğini bildir
 else{
 header('Location: kategori-liste.php?islem=silinemedi');
 }
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>