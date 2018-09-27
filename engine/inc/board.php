<?php
/*
=====================================================
 Модуль создал: REZER (http://rezer.net)
=====================================================
 Файл: board.php
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Назначение: Ядро модуля
=====================================================
*/

if( !defined( "DATALIFEENGINE" ) ) die( "Hacking attempt!" );
if( $member_id['user_group'] != 1 && $member_db[1] != 1 ) die( "Нет доступа" );

if ( isset( $_REQUEST['action'] ) ) $action = totranslit( $_REQUEST['action'] ); else $action = "";

require_once( ENGINE_DIR."/data/board.config.php" );
require_once( ENGINE_DIR."/inc/board/board.class.php" );
require_once( ENGINE_DIR."/inc/board/functions.php" );

//----------------------------------------------------
//  Разрешённые файлы
//----------------------------------------------------

$array_action = array(
	"field" 		=> "field.php",
	"update"		=> "update.php",
	"post_edit"		=> "post_edit.php",
	"activation"	=> "activation.php",
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
		if( !empty( $error_f ) && file_exists( ENGINE_DIR."/inc/board/".$error_f ) )
			{
				include( ENGINE_DIR."/inc/board/".$error_f );
			}
				else
			{
				msg( "info","Ошибка","Данного раздела не существует<br><br><a href=\"".$PHP_SELF."?mod=board\">В главное меню</a>" );
			}		
		/* Главная страница */
	}
		else 
	{
		include( ENGINE_DIR."/inc/board/main.php" );
	}
?>