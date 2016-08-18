<?php
	function SpiderDetect($USER_AGENT)
	{
		$engines = array(
			array("Aport", "Aport robot"),
			array("Google", "Google"),
			array("msnbot", "MSN"),
			array("Rambler", "Rambler"),
			array("Yahoo", "Yahoo"),
			array("AbachoBOT", "AbachoBOT"),
			array("accoona", "Accoona"),
			array("AcoiRobot", "AcoiRobot"),
			array("ASPSeek", "ASPSeek"),
			array("CrocCrawler", "CrocCrawler"),
			array("Dumbot", "Dumbot"),
			array("FAST-WebCrawler", "FAST-WebCrawler"),
			array("GeonaBot", "GeonaBot"),
			array("Gigabot", "Gigabot"),
			array("Lycos", "Lycos spider"),
			array("MSRBOT", "MSRBOT"),
			array("Scooter", "Altavista robot"),
			array("AltaVista", "Altavista robot"),
			array("WebAlta", "WebAlta"),
			array("IDBot", "ID-Search Bot"),
			array("eStyle", "eStyle Bot"),
			array("Mail.Ru", "Mail.Ru Bot"),
			array("Scrubby", "Scrubby robot"),
			array("Yandex", "Yandex"),
			array("YaDirectBot", "Yandex Direct")
		);

		foreach ($engines as $engine)
		{
			if (strstr($USER_AGENT, $engine[0]))
			{
				return($engine[1]);
			}
		}

		return "false";
	}

	$detect = SpiderDetect($_SERVER["HTTP_USER_AGENT"]);

	echo $detect;
?>