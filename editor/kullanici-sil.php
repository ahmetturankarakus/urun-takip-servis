<?php
 session_start();
 ob_start();
 
 if ($_SESSION["loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: ../login.php");
 }
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
<?php
// veritabanı ayar dosyasını dahil et
include '../pdoconfig.php';
try {
	 // kaydın id bilgisini al
	 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');
	 // silme sorgusu
	 $sorgu = "DELETE FROM kullanicilar WHERE id = ?";
	 $stmt = $con->prepare($sorgu);
	 $stmt->bindParam(1, $id);

	 // sorguyu çalıştır
	 if($stmt->execute()){
		 // kayıt listeleme sayfasına yönlendir
		 // ve kullanıcıya kaydın silindiğini
		 header('Location: kullanici-liste.php?islem=silindi');
	 } // veya silinemediğini bildir
	 else{
		 header('Location: kullanici-liste.php?islem=silinemedi');
	 }
	}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>
