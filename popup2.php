<?php
if($_POST["secret"] == md5(date("Y-m-d"))) {
session_start();
if($_POST['kapcha'] != $_SESSION['rand_code'])  {
header('Location: /error-captcha.html', true, 301);
}
else {
header('Location: /successfull.html', true, 301);
$referer = $_SERVER['HTTP_REFERER'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];
$br = "\n";
$text = " Ссылка: $referer $br Имя: $name $br Телефон: $phone $br E-mail: $email $br Сообщение: $message";
$kuda = "9781188@mail.ru";
$send = mail("$kuda","Напишите нам","$text");
}
}
?>