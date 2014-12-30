<?php

include_once('inc/product.inc.php');
include_once('inc/dbHandler.inc.php');
include_once('inc/site.inc.php');
include "lang.php";

function fill_template(&$template, $tag, $content) {
	$template = str_replace("@$tag@", $content, $template);
}
$template = file_get_contents("template/index.tpl.html");
$site = new Site;

session_start();
$view = isset($_GET["view"]) ? $_GET["view"] : NULL;
$category = isset($_GET["category"]) ? $_GET["category"] : NULL;
$query = isset($_GET["query"]) ? $_GET["query"] : NULL;
$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
$user = isset($_SESSION["user"]) ? $_SESSION["user"] : NULL;
$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : NULL;
$dbHandler = new DBHandler;

fill_template($template, "header", $site->getHeader($user));
fill_template($template, "title", $site->getTitle());
fill_template($template, "content", $site->getContent($view, $category, $query, $id));
fill_template($template, "sidebar", $site->getSidebar());
fill_template($template, "footer", $site->getFooter());

echo $template;

?>
