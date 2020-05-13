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

// Admin Area
$app->get("/admin", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("index");

});

// Login GET
$app->get("/admin/login", function() {

	$page = new PageAdmin([
		'header'=>'false',
		'footer'=>'false'
	]);

	$page->setTpl("login", [
		'error'=>User::getError()
	]);

});

// Login POST
$app->post("/admin/login", function() {

	$user = new User();

	User::login($_POST['desemail'], $_POST['despassword']);

	header("Location: /admin");

	exit;

});

// Delete User GET
$app->get("/admin/users/:iduser/delete", function($iduser) {

	User::checkUser();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");

	exit;

});

// User List
$app->get("/admin/users", function() {
	
	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("users", [
		'users'=>User::listAll()
	]);

});

// Create User GET
$app->get("/admin/users/create", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("create-user", [
		'error'=>User::getError()
	]);

});

// Create User POST
$app->post("/admin/users/create", function() {

	User::checkUser();

	if (!isset($_POST['desname']) || !$_POST['desname'])
	{
		User::setError("Fill in the name field.");
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['desemail']) || !$_POST['desemail'])
	{
		User::setError("Fill in the login field.");
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['despassword']) || !$_POST['despassword'])
	{
		User::setError("Fill in the password field.");
		header("Location: /admin/users/create");
		exit;
	}

	if ($_POST['despassword'] != $_POST['confirmpassword'])
	{
		User::setError("Password and confirm password does not match.");
		header("Location: /admin/users/create");
		exit;
	}

	$user = new User();

	$user->setData($_POST);

	$user->createUser();

	header("Location: /admin/users");

	exit;

});

// Create Post GET
$app->get("/admin/posts/create", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("create-post");

});

// Create Post POST
$app->post("/admin/posts/create", function() {

	User::checkUser();

});

// List Posts GET
$app->get("/admin/posts", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("posts", [
		'posts'=>Post::listAll()
	]);

});

// User Logout
$app->get("/admin/logout", function() {

	User::logout();

	session_regenerate_id();

	header("Location: /admin/login");

	exit;

});

// User Update GET
$app->get("/admin/users/:iduser/update", function($iduser) {

	User::checkUser();

	$user = new User();

	$user->get((int)$iduser);
	
	$page = new PageAdmin();

	$page->setTpl("update-user", [
		'user'=>$user->getValues(),
		'error'=>User::getError(),
		'success'=>User::getSuccess()
	]);

});

// User Update POST
$app->post("/admin/users/:iduser/update", function($iduser) {

	User::checkUser();

	$user = new User();

	$user->get((int)$iduser);

	if (!isset($_POST['desname']) || $_POST['desname'] == "")
	{
		User::setError("Fill in the name field.");
		header("Location: /admin/users/".$user->getiduser()."/update");
		exit;	
	}

	if (!isset($_POST['desemail']) || $_POST['desemail'] == "")
	{
		User::setError("Fill in the login field.");
		header("Location: /admin/users/".$user->getiduser()."/update");
		exit;	
	}

	if ($_POST['despassword'] != $_POST['verifypassword'])
	{
		User::setError("Password and confirm password does not match.");
		header("Location: /admin/users/".$user->getiduser()."/update");
		exit;
	}

	if (!$_POST['despassword'] == "")
	{
	
		$user->setdesname($_POST['desname']);
		$user->setdesemail($_POST['desemail']);
		$user->setdespassword(User::getPasswordHash($_POST['despassword']));
	
	} else {

		$user->setdesname($_POST['desname']);
		$user->setdesemail($_POST['desemail']);

	}

	$user->update();

	User::setSuccess("Data updated successfully!");

	header("Location: /admin/users/".$user->getiduser()."/update");

	exit;

});

$app->run();

?>