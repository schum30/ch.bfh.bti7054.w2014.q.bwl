<?php 
	$DEFAULT_LANG="de";
	if (isset($_GET["lang"]) && file_exists("lang/" . "$_GET[lang]" . ".ini")){//Die Sprache ist festgelegt und verfügbar
		$filename = "lang/" . "$_GET[lang]" . ".ini";
	}
	else {
		$filename = "lang/" . "$DEFAULT_LANG" . ".ini";//Die Sprache ist entweder nicht festgelegt oder nicht verfügbar
	}
	$expr = parse_ini_file($filename);
?>
