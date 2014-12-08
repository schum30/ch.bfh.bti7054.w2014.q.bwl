<?php 
	$DEFAULT_LANG="de";
	if (isset($_COOKIE["lang"]) && file_exists("lang/" . "$_COOKIE[lang]" . ".ini")){//Die Sprache ist festgelegt und verfügbar
		$filename = "lang/" . "$_COOKIE[lang]" . ".ini";
	}
	else {
		setcookie("lang",$DEFAULT_LANG);
		$filename = "lang/" . "$DEFAULT_LANG" . ".ini";//Die Sprache ist entweder nicht festgelegt oder nicht verfügbar
	}
	$expr = parse_ini_file($filename);
?>
