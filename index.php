<?php  

session_start();

require_once("vendor/autoload.php");

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Slim\Slim;

$app = new \Slim\Slim();

$app->get("/", function() {

	$page = new Page();

	$page->setTpl("index");

});

$app->get("/admin", function() {

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->run();

?>