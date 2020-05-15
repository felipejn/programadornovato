<?php  

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;

// Admin Area
$app->get("/admin", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("index");

});

// User Login
$app->get("/admin/login", function() {

	$page = new PageAdmin([
		'header'=>'false',
		'footer'=>'false'
	]);

	$page->setTpl("login", [
		'error'=>User::getError()
	]);

});

// User Login
$app->post("/admin/login", function() {

	$user = new User();

	User::login($_POST['desemail'], $_POST['despassword']);

	header("Location: /admin");

	exit;

});

?>