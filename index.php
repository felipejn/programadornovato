<?php  

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;

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

// Login
$app->get("/admin/login", function() {

	$page = new PageAdmin([
		'header'=>'false',
		'footer'=>'false'
	]);

	$page->setTpl("login", [
		'error'=>User::getError()
	]);

});

// Login
$app->post("/admin/login", function() {

	$user = new User();

	User::login($_POST['desemail'], $_POST['despassword']);

	header("Location: /admin");

	exit;

});

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
		'success'=>User::getSuccess()
	]);

});

// Create User
$app->get("/admin/users/create", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("create-user", [
		'error'=>User::getError()
	]);

});

// Create User
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

// Create Post
$app->get("/admin/posts/create", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("create-post", [
		'tags'=>Tag::listAll(),
		'error'=>Post::getError()
	]);

});

// Create Post
$app->post("/admin/posts/create", function() {

	User::checkUser();

	if (!isset($_POST['destittle']) || !$_POST['destittle'])
	{
		Post::setError("Fill in the tittle field.");
		header("Location: /admin/posts/create");
		exit;
	}

	if (!isset($_POST['desurl']) || !$_POST['desurl'])
	{
		Post::setError("Fill in the url field.");
		header("Location: /admin/posts/create");
		exit;
	}

	if (!isset($_POST['destext']) || !$_POST['destext'])
	{
		Post::setError("Fill in the text field.");
		header("Location: /admin/posts/create");
		exit;
	}

	$_POST['despub'] = (isset($_POST['despub']) && $_POST['despub'] == "on") ? 1 : 0;

	$post = new Post();

	$post->setData($_POST);

	$post->createPost();

	$post->setNewTags($_POST);

	header("Location: /admin/posts");

	exit;	

});

// List Posts
$app->get("/admin/posts", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("posts", [
		'posts'=>Post::listAll(),
		'success'=>Post::getSuccess()
	]);

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
		'error'=>User::getError(),
	]);

});

// User Update
$app->post("/admin/users/:iduser/update", function($iduser) {

	User::checkUser();

	$user = new User();

	$user->get((int)$iduser);

	if (!isset($_POST['desname']) || $_POST['desname'] == "")
	{
		User::setError("Fill in the name field.");
		header("Location: /admin/users/".$iduser."/update");
		exit;	
	}

	if (!isset($_POST['desemail']) || $_POST['desemail'] == "")
	{
		User::setError("Fill in the login field.");
		header("Location: /admin/users/".$iduser."/update");
		exit;	
	}

	if ($_POST['despassword'] != $_POST['verifypassword'])
	{
		User::setError("Password and confirm password does not match.");
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

	User::setSuccess("Data updated successfully!");

	header("Location: /admin/users");

	exit;

});

// Tags List
$app->get("/admin/tags", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("tags", [
		'tags'=>Tag::listAll(),
		'success'=>Tag::getSuccess()
	]);

});

// Tag Create
$app->get("/admin/tags/create", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("create-tag", [
		'error'=>Tag::getError()
	]);

});

// Tag Create
$app->post("/admin/tags/create", function() {

	User::checkUser();

	if (!isset($_POST['destag']) || !$_POST['destag'])
	{
		Tag::setError("Fill in the name field");
		header("Location: /admin/tags/create");
		exit;
	}

	$tag = new Tag();

	$tag->setData($_POST);

	$tag->createTag();

	header("Location: /admin/tags");

	exit;

});

// Tag Delete
$app->get("/admin/tags/:idtag/delete", function($idtag) {

	User::checkUser();

	$tag = new Tag();

	$tag->get((int)$idtag);

	$tag->delete();

	header("Location: /admin/tags");

	exit;

});

// Tag Rename
$app->get("/admin/tags/:idtag/rename", function($idtag) {

	User::checkUser();

	$tag = new Tag();

	$tag->get((int)$idtag);

	$page = new PageAdmin();

	$page->setTpl("rename-tag", [
		'tag'=>$tag->getValues(),
		'error'=>Tag::getError()
	]);

});

// Tag Rename
$app->post("/admin/tags/:idtag/rename", function($idtag) {

	User::checkUser();

	$tag = new Tag();

	$tag->get((int)$idtag);

	if (!isset($_POST['destag']) || !$_POST['destag'])
	{
		Tag::setErro("Fill in the tag name field.");
		header("Location: /admin/tags/".$idtag."/rename");
		exit;
	}

	$tag->setData($_POST);

	$tag->update();

	Tag::setSuccess("Tag renamed successfully.");
	
	header("Location: /admin/tags");

	exit;

});

$app->run();

?>