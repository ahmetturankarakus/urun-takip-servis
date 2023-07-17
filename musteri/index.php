<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300&display=swap" rel="stylesheet">
    <title>Cihaz Takip Sistemi | inncrea.com.tr </title>
</head>
<body>
    <div class="body-container">
    <div class="container" id="container">
        <div>
        
        <div class="form-container sign-in-container">
            <form action="login.php" method="post">
                <h1>Giriş Yap</h1>
				<?php 
				
				if (isset($_GET['error'])) { ?>
					
				<p class="error"> <?php echo $_GET['error'] ?> </p>
				
				<?php
				}
				
				?>
                <input type="text" name="uname" placeholder="Kullanıcı Adı" />
                <input type="password" name="pword" placeholder="Şifre" />
                <button type="submit" name="submit" class="btn-grad">Giriş </button>
            </form>
        </div>
        </div>

        <div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>inncrea.com.tr <br>Cihaz Takip Sistemi</h1>
                </div>
            </div>
        </div>
        </div>
    </div>

    </div>
</body>
</html>