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

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get("/admin/login", function() {

	$page = new PageAdmin([
		'header'=>'false',
		'footer'=>'false'
	]);

	$page->setTpl("login", [
		'error'=>User::getError()
	]);

});

$app->post("/admin/login", function() {

	$user = new User();

	User::login($_POST['desemail'], $_POST['despassword']);

	header("Location: /admin");

	exit;

});

$app->get("/admin/users/:iduser/delete", function($iduser) {

	User::checkUser();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");

	exit;

});

$app->get("/admin/users", function() {
	
	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("users", [
		'users'=>User::listAll()
	]);

});

$app->get("/admin/users/new", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("new-user");

});

$app->post("/admin/users/new", function() {

	User::checkUser();

	$user = new User();

	$user->setData($_POST);

	$user->createUser();

	header("Location: /admin/users");

	exit;

});

$app->get("/admin/posts/new", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("new-post");

});

$app->post("/admin/posts/new", function() {

	User::checkUser();

});

$app->get("/admin/posts", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("posts", [
		'posts'=>Post::listAll()
	]);

});

$app->get('/admin/logout', function() {

	User::logout();

	session_regenerate_id();

	header("Location: /admin/login");

	exit;

});

$app->run();

?>