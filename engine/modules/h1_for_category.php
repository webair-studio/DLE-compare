<?php
	if (!defined('DATALIFEENGINE')) die("Go fuck yourself!");
	include ('engine/api/api.class.php');
	/*$myConfig  = array(
		'cachePrefix' => !empty($cachePrefix) ? $cachePrefix : 'archives',
		'cacheSuffix' => !empty($cacheSuffix) ? $cacheSuffix : false
	);*/
	//$cacheName = md5(implode('_', $myConfig));
	$myModule  = false;
	//$myModule  = dle_cache($myConfig['cachePrefix'], $cacheName . $config['skin'], $myConfig['cacheSuffix']);
	if (!empty($_GET["category"])) {$row = $db->super_query("SELECT h1 FROM " . PREFIX . "_category WHERE id = ".$category_id);}
	// (!$myModule) {
		if (!empty($row['h1']))
		$myModule = '<h1>'.$row['h1']."</h1>"; // Результат работы модуля.
	//	create_cache($myConfig['cachePrefix'], $myModule, $cacheName . $config['skin'], $myConfig['cacheSuffix']);
	//}
	echo $myModule;



