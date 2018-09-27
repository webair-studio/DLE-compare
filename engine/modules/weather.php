<?php
/*
=====================================================
 DataLife Engine
-----------------------------------------------------
 http://sanderart.com/
-----------------------------------------------------
 Copyright (c) 2015 
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: weather.php
-----------------------------------------------------
 Назначение: Вывод погоды на сайте
=====================================================
*/

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}
	$city_id=27612; // id города
$file = file_get_contents("http://informer.gismeteo.ru/slice2/xml/".$city_id.".xml");
preg_match_all("#<title.*?>(.*?)</title>#is", $file, $items);
$temp= str_replace('Москва', '',$items[1][1]);


/*
 	$city_id=213; // id города
    $data_file="http://export.yandex.ru/weather-ng/forecasts/$city_id.xml"; // адрес xml файла 

              $xml = simplexml_load_file($data_file); // раскладываем xml на массив

 
    // выбираем требуемые параметры (город, температура, пиктограмма и тип погоды текстом (облачно, ясно)

    $temp=$xml->fact->temperature;

    // Если значение температуры положительно, для наглядности добавляем "+"
    if ($temp>0) {$temp='+'.$temp;}
  */
?>
<div class="weather">Москва <span class="temperature">
<?php echo $temp?>
</span>
</div>