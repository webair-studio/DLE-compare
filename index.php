<?php
/*
=====================================================
 DataLife Engine - by SoftNews Media Group
-----------------------------------------------------
 http://dle-news.ru/
-----------------------------------------------------
 Copyright (c) 2004,2015 SoftNews Media Group
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: index.php
-----------------------------------------------------
 Назначение: Главная страница
=====================================================
*/
if(stristr($_SERVER['HTTP_REFERER'], "yabs.yandex.ru")) {

	session_start();
	$_SESSION['direct_flag'] = "true";
}
if(stristr($_SERVER["REQUEST_URI"], "?")) {
	$uri = $_SERVER["REQUEST_URI"];
	$uri_parse = explode("?", $uri);
	if(strlen($uri_parse[1]) > 0) {
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".$uri_parse[0]); 
	}
}
echo "<!--".print_r($_SESSION,true)."-->";
//echo '<script>console.log(812)</script>';
@ob_start ();
@ob_implicit_flush ( 0 );

if( !defined( 'E_DEPRECATED' ) ) {

	@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

} else {

	@error_reporting ( E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );

}

@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'upload_max_filesize', '10M' );

define ( 'DATALIFEENGINE', true );
define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );

require_once ROOT_DIR . '/engine/init.php';

?>