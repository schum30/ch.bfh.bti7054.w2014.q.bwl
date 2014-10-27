<?php 
	$DEFAULT_LANG="de";
	if (isset($_GET["lang"]) && file_exists("lang/" . "$_GET[lang]" . ".ini")){
		$filename = "lang/" . "$_GET[lang]" . ".ini";
	}
	else {
		$filename = "lang/" . "$DEFAULT_LANG" . ".ini";
	}
	$expr = parse_ini_file($filename);
?>
