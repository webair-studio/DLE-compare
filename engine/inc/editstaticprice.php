<?php
/*
=====================================================
DataLife Engine - by SoftNews Media Group 
-----------------------------------------------------
Copyright (c) 2004,2015
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: newsletter.php
-----------------------------------------------------
 Назначение: Отправка массовых сообщений
=====================================================
*/

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
  die("Hacking attempt!");
}

if($_POST['type'] == "many") {
    foreach($_POST as $key=>$param) {
        if(stristr($key, "price")) {
            $id = explode("_", $key);
            $row = $db->query("UPDATE " . USERPREFIX . "_static_condition SET `condition_under_preim_price` = '".$param."' WHERE id=".$id[1]);
        }
    }
}

if($_POST['type'] == "one") {
    $row = $db->query("UPDATE " . USERPREFIX . "_static_condition SET `condition_under_preim_price` = '".$_POST['common_price']."'");
}


	echoheader( "<i class=\"icon-envelope\"></i>"."Массовое редактирование цен", "Для статических страниц типа condition" );
	$group_list = get_groups ();
    $form = '';
    $row = $db->query("SELECT `id`, `condition_name_preim`, `condition_under_preim_price` FROM " . USERPREFIX . "_static_condition");
    while ( $row = $db->get_array() ) {
        $form .= "<div class=\"form-group\">
		  <label class=\"control-label col-lg-2\">".$row['condition_name_preim']."</label>
		  <div class=\"col-lg-10\">
			<input type=\"text\" name=\"price_".$row['id']."\" value=\"".$row['condition_under_preim_price']."\">
		  </div>
		 </div>";
    }
   

echo <<<HTML
<form method="POST" action="" class="form-horizontal">
<div class="box">
  <div class="box-header">
    <div class="title">Установка общей цены</div>
  </div>
  <input type="hidden" name="type" value="one">
  <div class="box-content">

	<div class="row box-section">
	
		<div class="form-group">
		  <label class="control-label col-lg-2">Общая цена</label>
		  <div class="col-lg-10">
			<input type="text" name="common_price" value="">
		  </div>
		 </div>	
		<div class="form-group">
		  <label class="control-label col-lg-2"></label>
		  <div class="col-lg-10">
			<input type="submit" class="btn btn-blue" value="Сохранить">
		  </div>
		 </div>	
	 </div>
	
   </div>
</div>
</form>

<form method="POST" action="" class="form-horizontal">
<div class="box">
  <div class="box-header">
    <div class="title">Редактирование индивидуальных цен</div>
  </div>
  <input type="hidden" name="type" value="many">
  <div class="box-content">

	<div class="row box-section">
	
    {$form}
		<div class="form-group">
		  <label class="control-label col-lg-2"></label>
		  <div class="col-lg-10">
			<input type="submit" class="btn btn-blue" value="Сохранить">
		  </div>
		 </div>	
	 </div>
	
   </div>
</div>
</form>
HTML;

  echofooter();
?>