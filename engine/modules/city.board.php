<?php
if( !defined( "DATALIFEENGINE" ) ) die( "Hacking attempt!" );
// подключение класса доски
if( !class_exists( "Board" ) ) {require_once( ENGINE_DIR."/inc/board/board.class.php" );
$Board = clone $Board;  }
else {global $Board; }
// подключение класса доски
//unset($_COOKIE);
//print_r($_REQUEST);
if ($_REQUEST['select_region'] AND isset($_REQUEST['city']) ){
/* получили имя города из класса*/
 //
	$Board->LoadListCity( $_REQUEST['country']);
    $UserCity = htmlspecialchars( stripslashes( $Board->DB['city'][ $_REQUEST['country'] ][$_REQUEST['city']]['name'] ) );
    $UserCity = str_replace('-- ','', $UserCity);

    setcookie("BoardCity", intval($_REQUEST['city']),time()+60*60*24*30*12);
    setcookie("BoardCountry", intval($_REQUEST['country']),time()+60*60*24*30*12);
    setcookie("BoardCityName", $UserCity,time()+60*60*24*30*12);
//    echo 'смена города';
/* получили имя города из класса*/

    if( $is_logged AND $UserCity ) $db->query( "UPDATE ".PREFIX."_users SET city='{$_REQUEST[city]}',city_name='{$UserCity}', `country`='{$_REQUEST['country']}' WHERE user_id='{$member_id['user_id']}'" );
    $db->free();
    if ($_SERVER['REDIRECT_URL']){header('Location: http://'.$_SERVER['SERVER_NAME'].''.$_SERVER['REDIRECT_URL']);} // редерект чтобы сразу отобразить смену региона
    else {header('Location: http://'.$_SERVER['SERVER_NAME'].'/');}
}
else if ($is_logged AND isset($member_id['city'])){      // если пользовтель залогинелся и у него уже есть город
    $tmp_name= str_replace('-- ','', $member_id['city_name']);
    setcookie("BoardCity", intval($member_id['city']),time()+60*60*24*30*12);
    setcookie("BoardCityName", $tmp_name,time()+60*60*24*30*12);
    setcookie("BoardCountry", $member_id['country'],time()+60*60*24*30*12);
}

else if(!$_COOKIE['BoardCity'] OR !$_COOKIE['BoardCountry'])
{      // для гостей
      include_once ENGINE_DIR."/modules/SxGeo.php";// Подключаем SxGeo.php класс
      $SxGeo = new SxGeo(ENGINE_DIR.'/modules/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);

      $city= $SxGeo->get($_SERVER['REMOTE_ADDR']);
      $city_name=$city['city']['name_ru'];
      $result = $db->super_query( "SELECT id,options FROM ".PREFIX."_board_options WHERE type='city' AND options LIKE 'name=-- {$city_name}%' LIMIT 1" );
      $tmp_Country=explode('|||',$result['options']);
      $Country=substr($tmp_Country['1'], 8, 12);
      setcookie("BoardCountry", intval($Country),time()+60*60*24*30*12);
      setcookie("BoardCity", intval($result['id']),time()+60*60*24*30*12);
      setcookie("BoardCityName", $city_name,time()+60*60*24*30*12);
   /*    */
}
$city = $_COOKIE['BoardCity'];
$city = ($city == 0) ? "" : $city;
$cashe_city = dle_cache("cashe_city".$city, $config['skin']);
$db->free();
if (!$cashe_city)
{
	global  $is_logged, $member_id, $tpl, $db; //$Board,
    $SelectCountry = $Board->ReturnSelectCountry( $_COOKIE['BoardCountry'] );
	$SelectCity    = $Board->ReturnSelectCity( $_COOKIE['BoardCountry'], $_COOKIE['BoardCity'] );
//var_dump($_COOKIE);
if(!empty($_COOKIE['BoardCityName'])){$city_name=$_COOKIE['BoardCityName'];}
else {$city_name='Выберите';}

$country= "<select name=\"country\" id=\"SelectListCountry\" onkeyup=\"SelectCountry( '', 'Выберите' );\" onkeydown=\"SelectCountry( '', 'Выберите' );\" onchange=\"SelectCountry( '', 'Выберите' );\"> <option value=\"\">- Без разницы -</option> {$SelectCountry}</select>" ;
$FormSelectCity= "<span id=\"FormSelectCity\"><select name=\"city\" id=\"SelectCity\"><option value=\"\">- Без разницы -</option>{$SelectCity}</select> <span id=\"FormSelectCityStatus\"></span></span>";
$cashe_city ='
			<a href="javascript:void(0);" onclick="SelectRegion( \''. intval( $_COOKIE['BoardCity'] ).'\' ); return false;">'.$city_name.'</a>
            <span id="niz">&nbsp;</span>
			<div id="SelectCountryForm" style="display: none;">
            <form method="post">
            	<div class="row">
            		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><b>Страна:</b>&nbsp;</div>
            		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">'.$country.'</div>
            	</div>
            	<div class="row">
            		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><b>Город:</b> &nbsp;</div>
            		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">'.$FormSelectCity.'</div>
            	</div>
				<div class="bot_city">
                    <input type="submit" class="btn" name="select_region" value="Выбрать" />
					<input type="button" class="btn" value="Отмена" onclick="ShowOrHide( \'SelectCountryForm\' ); return false;" />

				</div>
             </form>
			</div>';
 $db->free();
 create_cache ("cashe_city".$city, $cashe_city, $config['skin']);
}
echo $cashe_city;
?>