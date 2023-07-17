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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="../public/sytle.css" rel="stylesheet">
    <link href="../public/bootstrapssss/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    
  <!-- Default panel contents -->
  <div class="navbar navbar-dark bg-dark"><a class="navbar-brand" href="musteripanel.php">
    <img src="../img/inncrealogo.png" width="100" height="35" class="d-inline-block align-top" alt=""></a>
	</div>
<br>	
	
  <div class="panel-body">
	  
          <div class="container">


                  
                    <div class="col-sm-6 col-md-12">
                      <div class="thumbnail">
                        <img src="../public/img/sevkiyat_icon.jpg"  style="height: 300px;" alt="...">
                        <div class="caption">
                        
                          <center><a href="tum-urunler.php" class="btn btn-primary" role="button">Ürünümü Gör</a> </center>
                        </div>
                      </div>
                    </div>
                  

          </div>
	  
	  <br>
	  
        
        <div class="container">
      
              <center>
                  <a href="../logout.php" class="btn btn-danger"  role="button">Çıkış Yap</a>
              </center>

        </div>
		   
	  	

  </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>



<br>
<br>
<br>
<br>
<br>
<br>
	<div class="row">

		
		
		
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
	

	</div>

	
<?php
	
}else{
		header("Location: index.php");
		exit();
}

?>