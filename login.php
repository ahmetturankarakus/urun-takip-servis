<?php 

session_start();
ob_start();

include "loginconfig.php";


if (isset($_POST['uname']) && isset($_POST['pword'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['pword']);

	if (empty($uname)) {
		header("Location: index.php?error=Kullanıcı adı girmeniz gereklidir.");
	    exit();
	}
	else if(empty($pass)){
        header("Location: index.php?error=Şifre girmeniz gereklidir.");
	    exit();
	}
	else{
		
		$sql = "SELECT * FROM kullanicilar WHERE kadi='$uname' AND sifre='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['kadi'] === $uname && $row['sifre'] === $pass) {
            	$_SESSION['kadi'] = $row['kadi'];
            	$_SESSION['adsoyad'] = $row['adsoyad'];
            	$_SESSION['id'] = $row['id'];
            

				if ($row['yetki']==3) {
            		header("Location: musteri/musteripanel.php");
            		 exit();
            	}else if($row['yetki']==2){
            		header("Location: editor/editorpanel.php");
            		 exit();
            	}else{
					header("Location: admin/adminpanel.php");
 					exit();
            	}


            }else{
				header("Location: index.php?error=Geçersiz kullanıcı adı veya şifre!");
		        exit();
			}
		}else{
			header("Location: index.php?error=Geçersiz kullanıcı adı veya şifre!");
	        exit();
		}
	}
	
}

else{
	header("Location: index.php");
	exit();
}

?>