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
    
  <!-- Default panel conents -->
  <div class="navbar navbar-dark bg-dark"><a class="navbar-brand" href="adminpanel.php">
    <img src="../img/inncrealogo.png" width="200" height="70" class="d-inline-block align-top" alt=""></a>
	</div>
<br>	
	
  <div class="panel-body">
    

       <div class="row">


           <div class="col-sm-6 col-md-4" >
            <div class="thumbnail">
              <img src="../public/img/siparis-icon.png" style="height: 170px;" alt="...">
              <div class="caption">
              
                <center><a href="urun-ekle.php" class="btn btn-primary"  role="button">Yeni Ürün Ekle</a> </center>
              </div>
            </div>
          </div>
  
          <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
              <img src="../public/img/sevkiyat_icon.jpg"  style="height: 170px;" alt="...">
              <div class="caption">
              
                <center><a href="tum-urunler.php" class="btn btn-primary" role="button">Tüm Ürünler</a> </center>
              </div>
            </div>
          </div>
		   
		   
		   <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
              <img src="../public/img/product.png" style="height: 170px;" alt="...">
              <div class="caption">
              
                <center><a href="kategori-liste.php" class="btn btn-primary"  role="button">Kategori Listesi</a> </center>
              </div>
            </div>
          </div> 
			   


        </div>
		   
		<div class="row">
					  
			  <div class="col-sm-16 col-md-6">
            <div class="thumbnail">
              <img src="../public/img/teknik-destek.png" style="height: 170px;" alt="...">
              <div class="caption">
              
                <center><a href="personel-ekle.php" class="btn btn-primary"  role="button">Yeni Personel Ekle</a> </center>
              </div>
            </div>
          </div>		  

           <div class="col-sm-16 col-md-6">
            <div class="thumbnail">
              <img src="../public/img/user-add.png" style="height: 170px;" alt="...">
              <div class="caption">
              
                <center><a href="kullanici-ekle.php" class="btn btn-primary"  role="button">Yeni Kullanıcı Ekle</a> </center>
              </div>
            </div>
          </div>
  
        </div>
		   
		   <div class="row">
		   
			   <div class="col-sm-16 col-md-12">
            <div class="thumbnail">
              <img src="../public/img/permission.png" style="height: 170px;" alt="...">
              <div class="caption">
              
                <center><a href="yetkiler.php" class="btn btn-primary"  role="button">Müşteri Yetki Düzenle</a> </center>
              </div>
            </div>
          </div>	
		   
			<center>
			   <a href="../logout.php" class="btn btn-danger"  role="button">Çıkış Yap</a>
		   </center>

		   </div>
		   


  </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
	
	


<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted">


  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2022 Copyright:
    <a class="text-reset fw-bold" href="http://inncrea.com.tr/">Inncrea Yazılım Bilişim Ltd. Şti. </a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->
	
<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>