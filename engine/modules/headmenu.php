<?php

$cat = '';

if (!empty($_REQUEST['category'])) $cat = $_REQUEST['category'];
if (!empty($_REQUEST['seocat'])) $cat = $_REQUEST['seocat'];

$cat = str_replace(array('\\', '/'), '', $cat);

?>
<ul class="main_nav" data="<?php echo $cat ?>">
	<li><a href="http://rcmm.ru/video/" ><img src="/templates/NapolitanoBlue_rcmm/images/video2.png" alt="Архив видео" /></a></li>
	<li><a title="Власть саморегулирование" <?php echo $cat!='vlast-i-samoregulirovanie'? 'href="/vlast-i-samoregulirovanie/"' : 'class="activemenu"'?>>Власть</a></li>
	<li><a title="Экономика бизнес" <?php echo $cat!='ekonomika-i-biznes'? 'href="/ekonomika-i-biznes/"' : 'class="activemenu"'?>>Бизнес</a></li>
	<li><a title="Строительные материалы" <?php echo $cat!='stroitelnye-materialy'? 'href="/stroitelnye-materialy/"' : 'class="activemenu"'?> >Материалы</a></li>
	<li><a title="Технологии строительства" <?php echo $cat!='tehnika-i-tehnologii'? 'href="/tehnika-i-tehnologii/"' : 'class="activemenu"'?>>Технологии</a></li>
	<li><a title="Дорожное строительство" <?php echo $cat!='dorozhnoe-stroitelstvo'? 'href="/dorozhnoe-stroitelstvo/"' : 'class="activemenu"'?> >Дороги</a></li>
	<li><a title="Жилищно-коммунальное хозяйство" <?php echo $cat!='zhkh'? 'href="/zhkh/"' : 'class="activemenu"'?> >ЖКХ</a></li>
	<li><a title="Архитектура проектирование" <?php echo $cat!='arhitektura-i-proektirovanie'? 'href="/arhitektura-i-proektirovanie/"' : 'class="activemenu"'?> >АРХ&ПРОЕКТ</a></li>
	<li><a title="Свой дом недвижимость" <?php echo $cat!='svoy-dom-nedvizhimost'? 'href="/svoy-dom-nedvizhimost/"' : 'class="activemenu"'?> >Недвижимость</a></li>
	<li><a title="Кто есть WHO" <?php echo $cat!='kto-est-who'? 'href="/kto-est-who/"' : 'class="activemenu"'?> >Кто есть WHO</a></li>
	<!--<li><a title="Доска объявлений"href="/board/">Доска<br/>объявлений</a></li> -->
	<li><a title="Экспертное мнение" <?php echo $cat!='ekspertnoe-mnenie'? 'href="/ekspertnoe-mnenie/"' : 'class="activemenu"'?> >Эксперты</a></li> 
	<!-- <li><a title="игры" href="/games.html">Свой дом <br/>недвижимость</a></li> -->

	<li data-menu="toggle">
		<a style="color: #06BFFF">События</a>
		<ul style="display: run-in;">
			<li><a title="Мероприятия" <?php echo $cat!='chto-gde-kogda'? 'href="/chto-gde-kogda/"' : 'class="activemenu"'?> >Мероприятия</a></li>
			<li><a title="Пресс-релизы" <?php echo $cat!='press-relizy'? 'href="/press-relizy/"' : 'class="activemenu"'?> >Пресс-релизы</a></li>
			<li><a title="Проекты" <?php echo $cat!='games.html"'? 'href="/games.html""' : 'class="activemenu"'?> >Проекты</a></li>
		</ul>
	</li> 
	

	<li><a style="color: #E8BB06" title="Battle" <?php echo $cat!='battle'? 'href="/games.html"' : 'class="activemenu"'?> >Battle</a></li> 
	<!-- <li><a title="Фототека" <?php echo $cat!='fototeka'? 'href="/fototeka"' : 'class="activemenu"'?> >Фототека</a></li> -->
</ul>
<?php /* СТАРОЕ МЕНЮ
<ul class="main_nav">
	<li><a title="Власть саморегулирование" <?php echo $cat!='vlast-i-samoregulirovanie'? 'href="/vlast-i-samoregulirovanie/"' : 'class="activemenu"'?>>Власть <br/>саморегулирование</a></li>
	<li><a title="Экономика бизнес" <?php echo $cat!='ekonomika-i-biznes'? 'href="/ekonomika-i-biznes/"' : 'class="activemenu"'?>>Экономика <br/>бизнес</a></li>
	<li><a title="Строительные материалы" <?php echo $cat!='stroitelnye-materialy'? 'href="/stroitelnye-materialy/"' : 'class="activemenu"'?> >Строительные <br/>материалы</a></li>
	<li><a title="Технологии строительства" <?php echo $cat!='tehnika-i-tehnologii'? 'href="/tehnika-i-tehnologii/"' : 'class="activemenu"'?>>Техника и <br/>технологии</a></li>
	<li><a title="Дорожное строительство" <?php echo $cat!='dorozhnoe-stroitelstvo'? 'href="/dorozhnoe-stroitelstvo/"' : 'class="activemenu"'?> >Дорожное <br/>строительство</a></li>
	<li class="zhkh"><a title="Жилищно-коммунальное хозяйство" <?php echo $cat!='zhkh'? 'href="/zhkh/"' : 'class="activemenu"'?> >ЖКХ</a></li>
	<li><a title="Архитектура проектирование" <?php echo $cat!='arhitektura-i-proektirovanie'? 'href="/arhitektura-i-proektirovanie/"' : 'class="activemenu"'?> >АРХ&nbsp;/&nbsp;ПРОЕКТ<br/>ЭКО&nbsp;/&nbsp;ИННОВАЦИИ</a></li>
	<li><a title="Свой дом недвижимость" <?php echo $cat!='svoy-dom-nedvizhimost'? 'href="/svoy-dom-nedvizhimost/"' : 'class="activemenu"'?> >Свой дом <br/>недвижимость</a></li>
	<li><a title="Кто есть WHO" <?php echo $cat!='kto-est-who'? 'href="/kto-est-who/"' : 'class="activemenu"'?> >Кто есть<br/>WHO</a></li>
	<!--<li><a title="Доска объявлений"href="/board/">Доска<br/>объявлений</a></li> -->
	<li><a title="Экспертное мнение" <?php echo $cat!='ekspertnoe-mnenie'? 'href="/ekspertnoe-mnenie/"' : 'class="activemenu"'?> >Экспертное<br/>мнение</a></li> 
	<!-- <li><a title="игры" href="/games.html">Свой дом <br/>недвижимость</a></li> -->
</ul>
*/ ?>