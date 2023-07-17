<?php

$kid = $_SESSION['kid'];
 echo "<ul class='pagination pull-left margin-zero mt0'>";

 // önceki sayfa butonu
 if($sayfa>1){

	 $onceki_sayfa = $sayfa - 1;
	 echo "<li>";
		echo "<a href='{$sayfa_url}?id={$kid}&sayfa={$onceki_sayfa}&aranan={$aranan}'>";
			echo "<span style='margin:0 .5em;'>&laquo;</span>";
	 	echo "</a>";
	 echo "</li>";
 }


 // sayfa sayısını hesapla
 $sayfa_sayisi = ceil($kayit_sayisi / $sayfa_kayit_sayisi);

 // aktif sayfanın öncesinde ve sonrasında gösterilecek sayfa numarası aralığı
 $aralik = 2;

 // aktif sayfanın önce ve sonrasındaki sayfa numaralarını görüntüle
 $baslangic_no = $sayfa - $aralik;
 $bitis_no = ($sayfa + $aralik) + 1;

 for ($x=$baslangic_no; $x<$bitis_no; $x++) {
	 
	 // $x değerinin 0'dan büyük VE $sayfa_sayisi'na eşit veya küçük olduğundan
	 if (($x > 0) && ($x <= $sayfa_sayisi)) {

		 // aktif sayfa
		 if ($x == $sayfa) {
			 echo "<li class='active'>";
			 	echo "<a href='javascript::void();'>{$x}</a>";
			 echo "</li>";
		 }
		 // aktif olmayan sayfa
		 else {
			 echo "<li>";
			 	echo " <a href='{$sayfa_url}?id={$kid}&sayfa={$x}&aranan={$aranan}'>{$x}</a> ";
			 echo "</li>";
		 }
	 }
 }

 // sonraki sayfa butonu
 if($sayfa<$sayfa_sayisi){
	 $sonraki_sayfa = $sayfa + 1;

	 echo "<li>";
		 echo "<a href='{$sayfa_url}?id={$kid}&sayfa={$sonraki_sayfa}&aranan={$aranan}'>";
			 echo "<span style='margin:0 .5em;'>&raquo;</span>";
		 echo "</a>";
	 echo "</li>";
 }

 echo "</ul>";
?>
