<?
if(!defined('DATALIFEENGINE')){   die("Hacking attempt!");}
include (ENGINE_DIR . '/api/api.class.php');
$date=date("d");

$timeout = 3;

if ($config['allow_cache'] != "yes") { $config['allow_cache'] = "yes"; $is_change = true;}

$cache_filename = null;//ENGINE_DIR."/cache/valuta/valuta_".date("d_m_Y").".tmp";

if(!file_exists($cache_filename))
{      
  // Получаем текущие курсы валют в rss-формате с сайта www.cbr.ru

	  $ch = curl_init();  
	  curl_setopt($ch, CURLOPT_URL,"http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));
	  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER [ "HTTP_USER_AGENT" ]);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	  $xml = simplexml_load_string(curl_exec($ch)); 
	  curl_close($ch);
	   foreach ($xml->Valute as $valute) {
		if($valute->CharCode == "USD")
			$usd1 = str_replace(',', '.', $valute->Value);
		else if($valute->CharCode == "EUR")
			$eur1 = str_replace(',', '.', $valute->Value);
	  }
	  $ch = curl_init();  
	  curl_setopt($ch, CURLOPT_URL,"http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y", strtotime('-1 day', time())));
	  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER [ "HTTP_USER_AGENT" ]);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	  $xml_old = simplexml_load_string(curl_exec($ch)); 
	  curl_close($ch);
	  foreach ($xml_old->Valute as $valute) {
		if($valute->CharCode == "USD")
			$usd_old = str_replace(',', '.', $valute->Value);
		else if($valute->CharCode == "EUR")
			$eur_old = str_replace(',', '.', $valute->Value);
	  }
	  $usd_class  = ($usd1 >= $usd_old) ? "color:forestgreen" : "color:red";
	  $usd_cursor = ($usd1 >= $usd_old) ? "+" : "-";

	  $usd2 = $usd1 - $usd_old;
	  $usd2 = substr($usd2,0,5) ;

	  $eur_class  = ($eur1 >= $eur_old) ? "color:forestgreen" : "color:red";
	  $eur_cursor = ($eur1 >= $eur_old) ? "+" : "-";

	  $eur2 = $eur1 - $eur_old;
	  $eur2 = substr($eur2,0,5) ;
	   /*  */
	  /*$ch = curl_init(); 
	  curl_setopt($ch, CURLOPT_URL,"https://news.yandex.ru/quotes/1006.html");
	  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER [ "HTTP_USER_AGENT" ]);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	  $brent = curl_exec($ch); 
	  curl_close($ch);
	  $start = strpos($brent, "quote_current_yes");
	  $start = strpos($brent, ">", $start) + 1;
	  $end = strpos($brent, "</tr>", $start);
	  $result = substr($brent, $start, $end - $start);
	  $start = strpos($result, "quote__value");
	  $start = strpos($result, ">", $start) + 1;
	  $end = strpos($result, "</td>", $start);
	  $kurs = str_replace(",", ".", strip_tags(substr($result, $start, $end - $start)));
	  $pos_sing = strpos($result, "-");
	  $start = strpos($result, "quote__change");
	  $start = strpos($result, ">", $start) + 1;
	  $end = strpos($result, "</td>", $start);
	  $kor = str_replace(",", ".", strip_tags(substr($result, $start, $end - $start)));
	  $kor= substr($kor,0,5) ;

	  $kurs_class = (floatval(str_replace(",", ".", substr($kor, 0, -1))) < 0) ? "down" : "up";
	  $kurs_cursor = (floatval(str_replace(",", ".", substr($kor, 0, -1))) > 0) ? "<span class=\"cur_up\">▲</span>" : "<span class=\"cur_down\">▼</span>";*/
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, "http://www.quote-spy.com/");
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	  $brent = iconv('cp1251', 'utf-8', curl_exec($ch));
	  curl_close($ch);
	  $start = strpos($brent, "ЭнергоресурсыBrentPrice");
	  $start = strpos($brent, ">", $start) + 1;
	  $end = strpos($brent, "</", $start);
	  $kurs = strip_tags(substr($brent, $start, $end - $start));
	  $start = strpos($brent, ">", $end) + 2;
	  $start = strpos($brent, ">", $start) + 1;
	  $end = strpos($brent, "</", $start);
	  $change = substr($brent, $start, $end - $start);
	  $kor = doubleval(strip_tags(str_replace(",", ".", $change)));

	  $kurs_class = ($kor < 0) ? "down" : "up";
	  $kurs_cursor = ($kor > 0) ? "<span class=\"cur_up\">▲</span>" : "<span class=\"cur_down\">▼</span>";

	  //$valuta = ' Курс ЦБ на '.date('d.m');
	  $valuta = '<div class="head_valute">';
	  $valuta.= '	<div><strong>USD</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="count_val">'.$usd1.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="'.$usd_class.'">'.$usd_cursor.''.$usd2.'</span></div>';
	  $valuta.= '	<div><strong>EUR</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="count_val">'.$eur1.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="'.$eur_class.'">'.$eur_cursor.''.$eur2.'</span></div>';
	  //$valuta.= 'USD:&nbsp;&nbsp;'.$usd_cursor.'<span class="count_val">'.$usd1.'</span><span class="'.$usd_class.'">'.$usd2.'</span>';
	  //$valuta.= ' EUR:&nbsp;&nbsp;'.$eur_cursor.'<span class="count_val">'.$eur1.'</span><span class="'.$eur_class.'">'.$eur2.'</span>';
	  $valuta.= '</div>';
	  //$valuta.= ' Курс нефти Brent:&nbsp;'.$kurs_cursor.'<span class="count_val">'. $kurs.'</span><span class="'.$kurs_class.'">'.$kor.'</span>';
	  // Разбираем содержимое, при помощи регулярных выражений

	$fp = fopen($cache_filename, "wr");
	fwrite($fp, $valuta);
	fclose($fp);

} else
	$valuta = file_get_contents($cache_filename);
echo $valuta;
?>