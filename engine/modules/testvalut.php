<?
if(!defined('DATALIFEENGINE')){   die("Hacking attempt!");}



$config_hash = md5('לפהדופ');

$is_change = false;

if ($config['allow_cache'] != "yes") { $config['allow_cache'] = "yes"; $is_change = true;}

$iComm = dle_cache( "test", $config['skin'].$config_hash );
echo  $iComm;

create_cache( "test", 'עוסע', $config['skin'].$config_hash );



?>