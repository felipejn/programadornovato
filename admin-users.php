<?php  

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;
use \Pronov\Message;

// Delete User
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
		'users'=>User::listAll(),
		'success'=>Message::getSuccess()
	]);

});

// Create User
$app->get("/admin/users/create", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("create-user", [
		'error'=>Message::getError()
	]);

});

// Create User
$app->post("/admin/users/create", function() {

	User::checkUser();

	if (!isset($_POST['desname']) || !$_POST['desname'])
	{
		Message::setError("Fill in the name field.");
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['desemail']) || !$_POST['desemail'])
	{
		Message::setError("Fill in the login field.");
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['despassword']) || !$_POST['despassword'])
	{
		Message::setError("Fill in the password field.");
		header("Location: /admin/users/create");
		exit;
	}

	if ($_POST['despassword'] != $_POST['confirmpassword'])
	{
		Message::setError("Password and confirm password does not match.");
		header("Location: /admin/users/create");
		exit;
	}

	$user = new User();

	$user->setData($_POST);

	$user->createUser();

	header("Location: /admin/users");

	exit;

});

// User Logout
$app->get("/admin/logout", function() {

	User::logout();

	session_regenerate_id();

	header("Location: /admin/login");

	exit;

});

// User Update
$app->get("/admin/users/:iduser/update", function($iduser) {

	User::checkUser();

	$user = new User();

	$user->get((int)$iduser);
	
	$page = new PageAdmin();

	$page->setTpl("update-user", [
		'user'=>$user->getValues(),
		'error'=>Message::getError(),
	]);

});

// User Update
$app->post("/admin/users/:iduser/update", function($iduser) {

	User::checkUser();

	$user = new User();

	$user->get((int)$iduser);

	if (!isset($_POST['desname']) || $_POST['desname'] == "")
	{
		Message::setError("Fill in the name field.");
		header("Location: /admin/users/".$iduser."/update");
		exit;	
	}

	if (!isset($_POST['desemail']) || $_POST['desemail'] == "")
	{
		Message::setError("Fill in the login field.");
		header("Location: /admin/users/".$iduser."/update");
		exit;	
	}

	if ($_POST['despassword'] != $_POST['verifypassword'])
	{
		Message::setError("Password and confirm password does not match.");
		header("Location: /admin/users/".$iduser."/update");
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

	Message::setSuccess("Data updated successfully!");

	header("Location: /admin/users");

	exit;

});

?>