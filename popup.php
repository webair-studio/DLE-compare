<?php
session_start();
if($_POST["secret"] == md5(date("Y-m-d"))) {
if($_POST['kapcha'] != $_SESSION['rand_code'])  {
header('Location: /error-captcha.html', true, 301);
}
else {
if($_POST["type"] == "usual") {
	$subject = "Форма обратного звонка";
} else {
	$subject = "Форма обратного звонка «Перезвоним за 10 минут»";
}



header('Location: /successfull.html', true, 301);
$referer = $_SERVER['HTTP_REFERER'];
$name = htmlspecialchars($_POST['name']);
$phone = htmlspecialchars($_POST['phone']);
$br = "\n";
$text = " Ссылка: $referer $br 
Телефон: $phone $br";
$text .= htmlspecialchars("Виды работ: ".$_POST["ventil"]." ".$_POST["cond"]." ".$_POST["oth"]." ");
$kuda = "9781188@mail.ru";
$send = mail("$kuda",$subject,"$text");
}
} else {
	header('Location: /', true, 301);
}
?>