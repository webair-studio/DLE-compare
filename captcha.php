<?php
	session_start();
	$string = "";
	for ($i = 0; $i < 3; $i++)
		$string .= chr(rand(48, 57));
	
	$_SESSION['rand_code'] = $string;

	$dir = "fonts/";

	$image = imagecreatetruecolor(170, 60);
	$black = imagecolorallocate($image, 0, 0, 0);
	$color = imagecolorallocate($image, 200, 100, 90);
	$white = imagecolorallocate($image, 255, 255, 255);

	imagefilledrectangle($image,0,0,399,99,$white);
	imagettftext ($image, 30, 0, 10, 40, $color, $dir."verdana.ttf", $_SESSION['rand_code']);

	header("Content-type: image/png");
	imagepng($image);
?>