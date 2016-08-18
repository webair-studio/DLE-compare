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
 Файл: main.php
-----------------------------------------------------
 Назначение: Общее формирование страницы сайта
=====================================================
*/
if(!defined('DATALIFEENGINE'))
{
  die("Hacking attempt!");
}

if (clean_url ( $_SERVER['HTTP_HOST'] ) != clean_url ( $config['http_home_url'] )) {

	$replace_url = array ();
	$replace_url[0] = clean_url ( $config['http_home_url'] );
	$replace_url[1] = clean_url ( $_SERVER['HTTP_HOST'] );

} else
	$replace_url = false;

$tpl->load_template ( 'main.tpl' );

$tpl->set ( '{calendar}', $tpl->result['calendar'] );
$tpl->set ( '{archives}', $tpl->result['archive'] );
$tpl->set ( '{tags}', $tpl->result['tags_cloud'] );
$tpl->set ( '{vote}', $tpl->result['vote'] );
$tpl->set ( '{topnews}', $tpl->result['topnews'] );
$tpl->set ( '{login}', $tpl->result['login_panel'] );
$tpl->set ( '{speedbar}', $tpl->result['speedbar'] );

if ( $dle_module == "showfull" ) {

	$tpl->set( '[related-news]', "" );
	$tpl->set( '[/related-news]', "" );
	$tpl->set( '{related-news}', $related_buffer );

} else {

	$tpl->set( '{related-news}', "" );
	$tpl->set_block( "'\\[related-news\\](.*?)\\[/related-news\\]'si", "" );

}

if ($config['allow_skin_change']) $tpl->set ( '{changeskin}', ChangeSkin ( ROOT_DIR . '/templates', $config['skin'] ) );

if (count ( $banners ) and $config['allow_banner']) {

	foreach ( $banners as $name => $value ) {
		$tpl->copy_template = str_replace ( "{banner_" . $name . "}", $value, $tpl->copy_template );
		if ( $value ) {
			$tpl->copy_template = str_replace ( "[banner_" . $name . "]", "", $tpl->copy_template );
			$tpl->copy_template = str_replace ( "[/banner_" . $name . "]", "", $tpl->copy_template );
		}
	}

}

$tpl->set_block ( "'{banner_(.*?)}'si", "" );
$tpl->set_block ( "'\\[banner_(.*?)\\](.*?)\\[/banner_(.*?)\\]'si", "" );

if (count ( $informers ) and $config['rss_informer']) {
	foreach ( $informers as $name => $value ) {
		$tpl->copy_template = str_replace ( "{inform_" . $name . "}", $value, $tpl->copy_template );
	}
}

if ($allow_active_news AND $news_found AND $config['allow_change_sort'] AND $do != "userinfo") {

	$tpl->set ( '[sort]', "" );
	$tpl->set ( '{sort}', news_sort ( $do ) );
	$tpl->set ( '[/sort]', "" );

} else {

	$tpl->set_block ( "'\\[sort\\](.*?)\\[/sort\\]'si", "" );

}

if (stripos ( $tpl->copy_template, "[category=" ) !== false) {
	$tpl->copy_template = preg_replace_callback ( "#\\[(category)=(.+?)\\](.*?)\\[/category\\]#is", "check_category", $tpl->copy_template );
}

if (stripos ( $tpl->copy_template, "[not-category=" ) !== false) {
	$tpl->copy_template = preg_replace_callback ( "#\\[(not-category)=(.+?)\\](.*?)\\[/not-category\\]#is", "check_category", $tpl->copy_template );
}


if (stripos ( $tpl->copy_template, "[static=" ) !== false) {
	$tpl->copy_template = preg_replace_callback ( "#\\[(static)=(.+?)\\](.*?)\\[/static\\]#is", "check_static", $tpl->copy_template );
}

if (stripos ( $tpl->copy_template, "[not-static=" ) !== false) {
	$tpl->copy_template = preg_replace_callback ( "#\\[(not-static)=(.+?)\\](.*?)\\[/not-static\\]#is", "check_static", $tpl->copy_template );
}

if (stripos ( $tpl->copy_template, "{custom" ) !== false) {
	$tpl->copy_template = preg_replace_callback ( "#\\{custom(.+?)\\}#i", "custom_print", $tpl->copy_template );
}

if( $vk_url ) {
	$tpl->set( '[vk]', "" );
	$tpl->set( '[/vk]', "" );
	$tpl->set( '{vk_url}', $vk_url );	
} else {
	$tpl->set_block( "'\\[vk\\](.*?)\\[/vk\\]'si", "" );
	$tpl->set( '{vk_url}', '' );	
}
if( $odnoklassniki_url ) {
	$tpl->set( '[odnoklassniki]', "" );
	$tpl->set( '[/odnoklassniki]', "" );
	$tpl->set( '{odnoklassniki_url}', $odnoklassniki_url );
} else {
	$tpl->set_block( "'\\[odnoklassniki\\](.*?)\\[/odnoklassniki\\]'si", "" );
	$tpl->set( '{odnoklassniki_url}', '' );	
}
if( $facebook_url ) {
	$tpl->set( '[facebook]', "" );
	$tpl->set( '[/facebook]', "" );
	$tpl->set( '{facebook_url}', $facebook_url );	
} else {
	$tpl->set_block( "'\\[facebook\\](.*?)\\[/facebook\\]'si", "" );
	$tpl->set( '{facebook_url}', '' );	
}
if( $google_url ) {
	$tpl->set( '[google]', "" );
	$tpl->set( '[/google]', "" );
	$tpl->set( '{google_url}', $google_url );
} else {
	$tpl->set_block( "'\\[google\\](.*?)\\[/google\\]'si", "" );
	$tpl->set( '{google_url}', '' );	
}
if( $mailru_url ) {
	$tpl->set( '[mailru]', "" );
	$tpl->set( '[/mailru]', "" );
	$tpl->set( '{mailru_url}', $mailru_url );	
} else {
	$tpl->set_block( "'\\[mailru\\](.*?)\\[/mailru\\]'si", "" );
	$tpl->set( '{mailru_url}', '' );	
}
if( $yandex_url ) {
	$tpl->set( '[yandex]', "" );
	$tpl->set( '[/yandex]', "" );
	$tpl->set( '{yandex_url}', $yandex_url );
} else {
	$tpl->set_block( "'\\[yandex\\](.*?)\\[/yandex\\]'si", "" );
	$tpl->set( '{yandex_url}', '' );
}

$config['http_home_url'] = explode ( "index.php", strtolower ( $_SERVER['PHP_SELF'] ) );
$config['http_home_url'] = reset ( $config['http_home_url'] );

if ( !$user_group[$member_id['user_group']]['allow_admin'] ) $config['admin_path'] = "";

$ajax .= <<<HTML
{$pm_alert}<script type="text/javascript">
<!--
var dle_root       = '{$config['http_home_url']}';
var dle_admin      = '{$config['admin_path']}';
var dle_login_hash = '{$dle_login_hash}';
var dle_group      = {$member_id['user_group']};
var dle_skin       = '{$config['skin']}';
var dle_wysiwyg    = '{$config['allow_comments_wysiwyg']}';
var quick_wysiwyg  = '{$config['allow_quick_wysiwyg']}';
var dle_act_lang   = ["{$lang['p_yes']}", "{$lang['p_no']}", "{$lang['p_enter']}", "{$lang['p_cancel']}", "{$lang['p_save']}", "{$lang['p_del']}", "{$lang['ajax_info']}"];
var menu_short     = '{$lang['menu_short']}';
var menu_full      = '{$lang['menu_full']}';
var menu_profile   = '{$lang['menu_profile']}';
var menu_send      = '{$lang['menu_send']}';
var menu_uedit     = '{$lang['menu_uedit']}';
var dle_info       = '{$lang['p_info']}';
var dle_confirm    = '{$lang['p_confirm']}';
var dle_prompt     = '{$lang['p_prompt']}';
var dle_req_field  = '{$lang['comm_req_f']}';
var dle_del_agree  = '{$lang['news_delcom']}';
var dle_spam_agree = '{$lang['mark_spam']}';
var dle_complaint  = '{$lang['add_to_complaint']}';
var dle_big_text   = '{$lang['big_text']}';
var dle_orfo_title = '{$lang['orfo_title']}';
var dle_p_send     = '{$lang['p_send']}';
var dle_p_send_ok  = '{$lang['p_send_ok']}';
var dle_save_ok    = '{$lang['n_save_ok']}';
var dle_del_news   = '{$lang['news_delnews']}';\n
HTML;

if ($user_group[$member_id['user_group']]['allow_all_edit']) {

	$ajax .= <<<HTML
var dle_notice     = '{$lang['btn_notice']}';
var dle_p_text     = '{$lang['p_text']}';
var dle_del_msg    = '{$lang['p_message']}';
var allow_dle_delete_news   = true;\n
HTML;

} else {

	$ajax .= <<<HTML
var allow_dle_delete_news   = false;\n
HTML;

}

if ($config['fast_search'] AND $user_group[$member_id['user_group']]['allow_search']) {

	$ajax .= <<<HTML
var dle_search_delay   = false;
var dle_search_value   = '';
$(function(){
	FastSearch();
});

HTML;

}

if (strpos ( $tpl->result['content'], "<pre><code>" ) !== false) {

	$js_array[] = "engine/classes/highlight/highlight.code.js";

	$ajax .= <<<HTML

$(function(){
	$('pre code').each(function(i, e) {hljs.highlightBlock(e, null)});
});
HTML;

}

$ajax .= <<<HTML
//-->
</script>
HTML;

if (strpos ( $tpl->result['content'], "hs.expand" ) !== false OR strpos ( $tpl->copy_template, "hs.expand" ) !== false OR strpos ( $tpl->result['content'], "highslide" ) !== false OR strpos ( $tpl->copy_template, "highslide" ) !== false) {

	if ($config['thumb_dimming']) $dimming = "hs.dimmingOpacity = 0.60;"; else $dimming = "";

	if ($config['thumb_gallery'] AND ($dle_module == "showfull" OR $dle_module == "static") ) {

	$gallery = "
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.addSlideshow({
		interval: 4000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});";

	} else {

		$gallery = "";

	}

	$js_array[] = "engine/classes/highslide/highslide.js";

	switch ( $config['outlinetype'] ) {

		case 1 :
			$type = "hs.wrapperClassName = 'wide-border';";
			break;

		case 2 :
			$type = "hs.wrapperClassName = 'borderless';";
			break;

		case 3 :
			$type = "hs.wrapperClassName = 'less';\nhs.outlineType = null;";
			break;

		default :
			$type = "hs.outlineType = 'rounded-white';";
			break;


	}

	$ajax .= <<<HTML
<script type="text/javascript">
<!--
	hs.graphicsDir = '{$config['http_home_url']}engine/classes/highslide/graphics/';
	{$type}
	hs.numberOfImagesToPreload = 0;
	hs.showCredits = false;
	{$dimming}
	hs.lang = {
		loadingText :     '{$lang['loading']}',
		playTitle :       '{$lang['thumb_playtitle']}',
		pauseTitle:       '{$lang['thumb_pausetitle']}',
		previousTitle :   '{$lang['thumb_previoustitle']}',
		nextTitle :       '{$lang['thumb_nexttitle']}',
		moveTitle :       '{$lang['thumb_movetitle']}',
		closeTitle :      '{$lang['thumb_closetitle']}',
		fullExpandTitle : '{$lang['thumb_expandtitle']}',
		restoreTitle :    '{$lang['thumb_restore']}',
		focusTitle :      '{$lang['thumb_focustitle']}',
		loadingTitle :    '{$lang['thumb_cancel']}'
	};
	{$gallery}
//-->
</script>
HTML;

}

if ( $config['allow_share'] AND ($dle_module == "showfull" OR $dle_module == "static") ) {

	if ( preg_match("/(msie)/i", $_SERVER['HTTP_USER_AGENT']) ) {

		$js_array[] = "engine/classes/masha/ierange.js";
		$js_array[] = "engine/classes/masha/masha.js";

	} else $js_array[] = "engine/classes/masha/masha.js";
}

$js_array = build_js($js_array, $config);

if ($allow_comments_ajax AND ($config['allow_comments_wysiwyg'] OR $config['allow_quick_wysiwyg'])) {
	$lang['wysiwyg_language'] = totranslit( $lang['wysiwyg_language'], false, false );

	if ( $config['allow_quick_wysiwyg'] == "2" OR $config['allow_comments_wysiwyg'] == "2" ) {

		$js_array .="\n<script type=\"text/javascript\" src=\"{$config['http_home_url']}engine/editor/jscripts/tiny_mce/tinymce.min.js\"></script>";

	}

	if ( $config['allow_quick_wysiwyg'] == "1" OR $config['allow_comments_wysiwyg'] == "1" ) {
		$js_array .="\n<script type=\"text/javascript\" src=\"{$config['http_home_url']}engine/editor/scripts/language/{$lang['wysiwyg_language']}/editor_lang.js\"></script>";
		$js_array .="\n<script type=\"text/javascript\" src=\"{$config['http_home_url']}engine/editor/scripts/innovaeditor.js\"></script>";
	}
}

if ($config['allow_admin_wysiwyg'] == "1" OR $config['allow_site_wysiwyg'] == "1" OR $config['allow_static_wysiwyg'] == "1") {
	$js_array .="\n<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js\"></script>";
	$js_array .="\n<script type=\"text/javascript\" src=\"{$config['http_home_url']}engine/editor/scripts/webfont.js\"></script>";
	$js_array .="\n<link media=\"screen\" href=\"{$config['http_home_url']}engine/editor/css/default.css\" type=\"text/css\" rel=\"stylesheet\" />";
}

if (strpos ( $tpl->result['content'], "<video" ) !== false) {
	$js_array .="\n<script type=\"text/javascript\" src=\"{$config['http_home_url']}engine/editor/scripts/common/mediaelement/mediaelement-and-player.min.js\"></script>";
	$js_array .="\n<link media=\"screen\" href=\"{$config['http_home_url']}engine/editor/scripts/common/mediaelement/mediaelementplayer.min.css\" type=\"text/css\" rel=\"stylesheet\" />";
}

if (stripos ( $tpl->copy_template, "{content}" ) !== false) {
	$custom_news = false;
}

if( $_SERVER['QUERY_STRING'] AND !$tpl->result['content'] AND !$tpl->result['info'] AND !$custom_news) {

	@header( "HTTP/1.0 404 Not Found" );
	msgbox( $lang['all_err_1'], $lang['news_err_27'] );

}

$tpl->set ( '{headers}', $metatags."\n".$js_array );
$tpl->set ( '{AJAX}', $ajax );
$tpl->set ( '{info}',  $tpl->result['info'] );



$larr = array(
"/ventilyaciya.html",
"/proektirovanie-ventilyacii.html",
"/montazh-ventilyacii.html",
"/obsledovanie-ventilyacii.html",
"/diagnostika-ventilyacii.html",
"/remont-ventilyacii.html",
"/chistka-ventilyacii.html",
"/dezinfekciya-ventilyacii.html",
"/obsluzhivanie-ventilyacii.html",
"/servis-ventilyacii.html",
"/vozduhovody.html",
"/proektirovanie-vozduhovodov.html",
"/montazh-vozduhovodov.html",
"/remont-vozduhovodov.html",
"/chistka-vozduhovodov.html",
"/dezinfekciya-vozduhovodov.html",
"/musoroprovody.html",
"/chistka-musoroprovodov.html",
"/dezinfekciya-musoroprovodov.html",
"/mojka-musoroprovodov.html"
);

if(in_array($_SERVER["REQUEST_URI"], $larr)) {
	$tpl->set ( '{process}', "<!--Process-->
            <div class='process pr'>
                <span class='process-title'>Процесс работы</span>
                <div class='process-wrap'>
                    <!--start-->
                    <div class='process-item six'>
                        
						<div class='cyrcle'>1</div>
                        <span>
                            Звонок/<br>Заявка
                        </span>
                    </div>
                    <!--end-->
                    <!--start-->
                    <div class='process-item six'>
                       
						<div class='cyrcle'>2</div>
                        <span>
                            Выезд<br>инженера
                        </span>
                    </div>
                    <!--end-->
                    <!--start-->
                    <div class='process-item six'>
                       
						<div class='cyrcle'>3</div>
                        <span>
                            Составление<br>сметы
                        </span>
                    </div>
                    <!--end-->
                    <!--start-->
                    <div class='process-item six'>
                       
						<div class='cyrcle'>4</div>
                        <span>
                            Заключение<br>договора
                        </span>
                    </div>
                    <!--end-->
					 <!--start-->
                    <div class='process-item six'>
                       
						<div class='cyrcle'>5</div>
                        <span>
                            Оплата
                        </span>
                    </div>
                    <!--end-->
					<!--start-->
                    <div class='process-item six'>
                       
						<div class='cyrcle'>6</div>
                        <span>
                           Выполнение<br>работы
                        </span>
                    </div>
                    <!--end-->
                    <div class='clearfix'></div>
                </div>
            </div>");
}
else {
$tpl->set ( '{process}', "<!--Process-->
            <div class='process pr'>
                <span class='process-title'>Процесс работы</span>
                <div class='process-wrap'>
                    <!--start-->
                    <div class='process-item'>
                        
						<div class='cyrcle'>1</div>
                        <span>
                            Звонок/<br>Заявка
                        </span>
                    </div>
                    <!--end-->
                    <!--start-->
                    <div class='process-item'>
                       
						<div class='cyrcle'>2</div>
                        <span>
                            Консультация
                        </span>
                    </div>
                    <!--end-->
                    <!--start-->
                    <div class='process-item'>
                       
						<div class='cyrcle'>3</div>
                        <span>
                            Выезд<br>инженера
                        </span>
                    </div>
                    <!--end-->
                    <!--start-->
                    <div class='process-item'>
                       
						<div class='cyrcle'>4</div>
                        <span>
                            Выполнение<br>работы
                        </span>
                    </div>
                    <!--end-->
					 <!--start-->
                    <div class='process-item'>
                       
						<div class='cyrcle'>5</div>
                        <span>
                            Оплата<br>по факту
                        </span>
                    </div>
                    <!--end-->
                    <div class='clearfix'></div>
                </div>
            </div>");
}
$tpl->set ( '{content}', "<div id='dle-content'>" . $tpl->result['content'] . "</div>" );

/* phones */
$phone_1 = preg_replace("#^(.*)\((.*)\)(.*)#", "<span class='code'>$1 ($2)</span>$3", $config['opt_sys_phone_1']);
$phone_tt_1 = preg_replace("#(\d)\:(\d\d)#", "$1<sup>$2</sup>", $config['opt_sys_phone_timetable_1']);
if($config['opt_sys_phone_2']) {
$phone_2 = preg_replace("#^(.*)\((.*)\)(.*)#", "<span class='code'>$1 ($2)</span>$3", $config['opt_sys_phone_2']);
$phone_tt_2 = preg_replace("#(\d)\:(\d\d)#", "$1<sup>$2</sup>", $config['opt_sys_phone_timetable_2']);
}
else {
    $phone_2 = $phone_tt_2 = "";
}
$tpl->set ( '{phone_1}', $phone_1);
$tpl->set ( '{phone_tt_1}', $phone_tt_1);
$tpl->set ( '{phone_2}', $phone_2);
$tpl->set ( '{phone_tt_2}', $phone_tt_2);

$tpl->compile ( 'main' );

if ($config['allow_links']) $tpl->result['main'] = replace_links ( $tpl->result['main'], $replace_links['all'] );

$tpl->result['main'] = str_ireplace( '{THEME}', $config['http_home_url'] . 'templates/' . $config['skin'], $tpl->result['main'] );

if ($replace_url) $tpl->result['main'] = str_replace ( $replace_url[0]."/", $replace_url[1]."/", $tpl->result['main'] );

$tpl->result['main'] = str_replace ( '<img src="http://'.$_SERVER['HTTP_HOST'].'/', '<img src="/', $tpl->result['main'] );

eval (' ?' . '>' . $tpl->result['main'] . '<' . '?php ');

$tpl->global_clear();

$db->close();

echo "\n<!-- DataLife Engine Copyright SoftNews Media Group (http://dle-news.ru) -->\r\n";

GzipOut();

?>