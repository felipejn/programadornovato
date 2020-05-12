<?php  

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;

$app = new \Slim\Slim();

$app->get("/", function() {

	$page = new Page();

	$page->setTpl("index");

});

$app->get("/admin", function() {

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get("/admin/login", function() {

	$page = new PageAdmin([
		'header'=>'false',
		'footer'=>'false'
	]);

	$page->setTpl("login");

});

$app->get("/admin/users", function() {
	
	$page = new PageAdmin();

	$page->setTpl("users", [
		'users'=>User::listAll()
	]);

});

$app->get("/admin/posts", function() {

	$page = new PageAdmin();

	$page->setTpl("posts", [
		'posts'=>Post::listAll()
	]);

});

$app->run();

?>