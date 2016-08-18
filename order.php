<?php
if($_POST["secret"] == md5(date("Y-m-d"))) {
header('Location: /successfull.html', true, 301);
$referer = $_SERVER['HTTP_REFERER'];
$phone = $_POST['phone'];
$text = " Ссылка: $referer Телефон: $phone";
$kuda = "9781188@mail.ru";
if(!empty($phone)) {
$send = mail("$kuda","Заявка на услугу","$text");
} else {
header('Location: /error-captcha.html', true, 301);
}
}
?>