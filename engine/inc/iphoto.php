<?php
/*
=====================================================
 Модуль создал: REZER (http://rezer.net)
=====================================================
 Файл: iphoto.php
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Назначение: Ядро модуля
=====================================================
*/

if( !defined( "DATALIFEENGINE" ) ) die( "Hacking attempt!" );
if( $member_id['user_group'] != 1 && $member_db[1] != 1 ) die( "Нет доступа" );

if ( isset( $_REQUEST['action'] ) ) $action = totranslit( $_REQUEST['action'] ); else $action = "";

require_once ( ENGINE_DIR.'/data/iphoto.config.php' );
require_once( ENGINE_DIR.'/inc/iphoto/functions.php' );
require_once( ENGINE_DIR.'/inc/iphoto/iphoto.class.php' );

//----------------------------------------------------
//  Разрешённые файлы
//----------------------------------------------------

$array_action = array(

  "addalbum" 	=> "addalbum.php",
  "editalbum"	=> "editalbum.php",
  "update"		=> "update.php",

);

//----------------------------------------------------
//  Подгружаем файлы
//----------------------------------------------------

if( !empty( $action ) )
	{
		/* Проверка на разрешение отдела админки */
		foreach ( $array_action as $array => $file )
			{
				if( $action == $array )
					{
						$error_f = $file;
					}
			}
		/* Сама подгрузка */
		if( !empty( $error_f ) and file_exists( ENGINE_DIR."/inc/iphoto/".$error_f ) )
			{
				include ENGINE_DIR."/inc/iphoto/".$error_f;
			}
				else
			{
				msg( "info","Ошибка","Данного раздела не существует<br><br><a href=\"".$PHP_SELF."?mod=iphoto\">В главное меню</a>" );
			}		
		/* Главная страница */
	}
		else 
	{
		include ENGINE_DIR.'/inc/iphoto/main.php';
	}
?>