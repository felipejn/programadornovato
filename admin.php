<?php  

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;
use \Pronov\Message;

// Admin Area
$app->get("/admin", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("index");

});

// User Login
$app->get("/admin/login", function() {

	$page = new PageAdmin([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("login", [
		'success'=>Message::getSuccess(),
		'error'=>Message::getError()
	]);

});

// User Login
$app->post("/admin/login", function() {

	$user = new User();

	User::login($_POST['desemail'], $_POST['despassword']);

	header("Location: /admin");

	exit;

});

// Forgot password
$app->get("/admin/login/forgot", function() {

	$page = new PageAdmin([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("forgot", [
		'error'=>Message::getError()
	]);

});

// Forgot Password
$app->post("/admin/login/forgot", function() {

	User::getForgot($_POST['desemail']);
	
	header("Location: /admin/login/email-sent");
	
	exit;

});

// Email Sent
$app->get("/admin/login/email-sent", function() {

	$page = new PageAdmin([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("email-sent", [
		'email'=>$_SESSION[User::REC_EMAIL]
	]);

});

// Reset Password
$app->get("/admin/login/reset", function() {
	
	User::getIdRecoveryByCode($_GET['code']);
	
	$page = new PageAdmin([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("reset-password", [
		'code'=>$_GET['code'],
		'error'=>Message::getError()
	]);

});

// Reset Password
$app->post("/admin/login/reset", function() {

	$recovery = User::getIdRecoveryByCode($_POST['code']);

	$user = new User();

	$user->get((int)$recovery['iduser']);

	if ($_POST['despassword'] != $_POST['verifypassword'])
	{
		
		Message::setError("Password and confirm password does not match.");
		header("Location: /admin/login/reset?code=".$_POST['code']);
		exit;

	}

	if ($_POST['despassword'] !== "")
	{
		
		$user->setdespassword(User::getPasswordHash($_POST['despassword']));

		$user->update();

		User::setRecoveryTime($recovery['idrecovery']);

		Message::setSuccess("Your password has been successfully reset.");
		
		header("Location: /admin/login");

		exit;		

	} else {

		Message::setError("Fill in new password field.");
		header("Location: /admin/login/reset?code=".$_POST['code']);
		exit;

	}

});

?>