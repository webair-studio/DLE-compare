<?php


if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

$max_comm = ( is_numeric(trim($max_comm)) ) ? $max_comm : 3;
$max_text = ( is_numeric(trim($max_text)) ) ? $max_text : 120;
$max_title = ( is_numeric(trim($max_title)) ) ? $max_title : 30;
$groups_color = ( $groups_color ) ? $groups_color : 'group_1:FF0000,group_2:CC33CC,group_3:009900,group_4:3333FF,group_5:666666';
if( $stop_category ) $stop_category = "AND p.category NOT IN ( {$stop_category} )";

$config_hash = md5($max_comm.$max_text.$max_title.$groups_color.$stop_category);

$is_change = false;

if ($config['allow_cache'] != "yes") { $config['allow_cache'] = "yes"; $is_change = true;}

$iComm = dle_cache( "last_comment", $config['skin'].$config_hash );

if( $iComm === false ) {

require_once ENGINE_DIR . '/classes/templates.class.php';

$tpl = new dle_template ( );
$tpl->dir = TEMPLATE_DIR;//ENGINE_DIR . '/modules/iComm/';
define ( 'TEMPLATE_DIR', $tpl->dir );

$db->query( "SELECT c.post_id, c.date, c.user_id, c.is_register, c.text, c.autor, c.email, c.approve,
             p.id, p.date as newsdate, p.title, p.category, p.comm_num, p.alt_name

             FROM " . PREFIX . "_comments as c, " . PREFIX . "_post as p
             WHERE p.id=c.post_id  AND c.approve = 1 {$stop_category}
             ORDER BY c.date DESC LIMIT 0, " . $max_comm ); //AND c.user_id = u.user_id

$tpl->load_template ( 'lastcomment.tpl' );

function iCommDate($format, $time_add) {
global $langdate, $config;
$today = strtotime(date("Y-m-d.", time()+ ($config['date_adjust']*60)));
if ($time_add > $today) return "Сегодня в " . date ("H:i:s", $time_add);
elseif ($time_add > ($today - 86400)) return "Вчера в ". date ("H:i:s", $time_add);
else return @strtr(@date($format, $time_add), $langdate);
}

      while ( $row = $db->get_row() ) {
       //     print_r($row);
//======================================================================

$on_page = FALSE;
if($row['comm_num'] > $config['comm_nummers']) $on_page = 'page,1,'.ceil($row['comm_num'] / $config['comm_nummers']).',';

if( $config['allow_alt_url'] == "yes" ) {

			if( $row['flag'] and $config['seo_type'] ) {

				if( $row['category'] and $config['seo_type'] == 2 ) {

					$full_link = $config['http_home_url'] . get_url( intval( $row['category'] ) ) . "/" .$on_page. $row['id'] . "-" . $row['alt_name'] . ".html";

				} else {

					$full_link = $config['http_home_url'] .$on_page. $row['id'] . "-" . $row['alt_name'] . ".html";

				}

			} else {

				$full_link = $config['http_home_url'] . date( 'Y/m/d/', $row['date'] ) .$on_page. $row['alt_name'] . ".html";
			}

		} else {

			$full_link = $config['http_home_url'] . "index.php?newsid=" . $row['id'];

		}

$full_link = $full_link.'#comment';

//======================================================================

if( dle_strlen( $row['text'], $config['charset'] ) > $max_text ) $text = dle_substr( $row['text'], 0, $max_text, $config['charset'] ) . " ...";
		else $text = $row['text'];

//======================================================================

if( dle_strlen( $row['title'], $config['charset'] ) > $max_title ) $title = dle_substr( $row['title'], 0, $max_title, $config['charset'] ) . " ...";
		else $title = $row['title'];

$title = stripslashes($title);
$text = strip_tags($text);

//======================================================================

$color = stristr($groups_color, 'group_'.$row['user_group'].':' );
$color = reset(explode(',',$color));
$color = trim(str_replace('group_'.$row['user_group'].':','',$color));

if($row['is_register'] == 1){

if( $config['allow_alt_url'] == "yes" ) $go_page = $config['http_home_url'] . "user/" . urlencode( $row['autor'] ) . "/";
  else $go_page = "$PHP_SELF?subaction=userinfo&amp;user=" . urlencode( $row['autor'] );

$author = "<a onclick=\"ShowProfile('" . urlencode( $row['autor'] ) . "', '" . $go_page . "'); return false;\" href=\"" . $go_page . "\"><span style=\"color:#".$color."\">" . $row['autor'] . "</span> </a>";

}else{

$author = "<a href=\"mailto:".$row['email']."\">".$row['autor']."</a>";

}

//======================================================================

$row['foto']  = ($row['foto'] == '') ? 'templates/' . $config['skin'] . '/images/noavatar.png' : 'uploads/fotos/'.$row['foto'];

if( $config['allow_alt_url'] == "yes" ) $user_url = $config['http_home_url'] . "user/" . urlencode( $row['autor'] ) . "/";
	 else $user_url = "$PHP_SELF?subaction=userinfo&amp;user=" . urlencode( $row['autor'] );

if($row['is_register'] != 1) $user_url = 'mailto:'.$row['email'];

$tpl->set ( '{hash}', md5($text.$author.$title) );
$tpl->set ( '{text}', $text );
$tpl->set ( '{date}', iCommDate("j F Y",strtotime($row['date'])) );
$tpl->set ( '{foto}', $config['http_home_url'] . $row['foto'] );
$tpl->set ( '{user_url}', $user_url );
$tpl->set ( '{user_name}', $row['autor'] );
$tpl->set ( '{title}', $title );
$tpl->set ( '{author}', $author );
$tpl->set ( '{full_link}', $full_link );
$tpl->set ( '{THEME}', $config['http_home_url']."engine/modules/iComm" );

$tpl->compile ( 'skin' );

//======================================================================

        }

	$db->free();
     $tpl->clear();

$iComm = $tpl->result['skin'];

if(!$iComm) $iComm = '<center><b>Нет комментариев</b></center>';

	create_cache( "last_comment", $iComm, $config['skin'].$config_hash );

}

//======================================================================

if( $user_group[$member_id['user_group']]['allow_hide'] ) $iComm = preg_replace( "'\[hide\](.*?)\[/hide\]'si", "\\1", $iComm );
		else $iComm = preg_replace ( "'\[hide\](.*?)\[/hide\]'si", "<div class=\"quote\">" . $lang['news_regus'] . "</div>", $iComm );



echo  $iComm;

if ($is_change) $config['allow_cache'] = false;

?>