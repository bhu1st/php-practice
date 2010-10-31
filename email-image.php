<?php 
//display your email address as image
//use as <img src="image.php" /> in HTML 

header("Content-type: image/png");   

$data = $_GET['show'];
	if ($data == "sms"){
		$string = "9779803239542@sms.ncell.com.np";  
	}else if ($data == "msg"){
		$string = "send me sms from email at ";  
	}else {
		$string = "sapkotabhupal@gmail.com";  
	}
 
$font  = 4;  
$width  = imagefontwidth($font) * strlen($string);  
$height = imagefontheight($font);  
  
$image = imagecreatetruecolor ($width,$height);  
$bg = imagecolorallocate ($image,25,78,132); 
$fg = imagecolorallocate ($image,0,0,0);  
imagefill($image,0,0,$bg);    
imagestring ($image,$font,0,0,$string,$fg);    
imagepng ($image);  
imagedestroy($image);  
?>  