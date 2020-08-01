<?php  

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;
use \Pronov\Message;

// Tags List
$app->get("/admin/tags", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("tags", [
		'tags'=>Tag::listAll(),
		'success'=>Message::getSuccess()
	]);

});

// Tag Create
$app->get("/admin/tags/create", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("create-tag", [
		'error'=>Message::getError()
	]);

});

// Tag Create
$app->post("/admin/tags/create", function() {

	User::checkUser();

	if (!isset($_POST['destag']) || !$_POST['destag'])
	{
		Message::setError("Fill in the name field");
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
		'error'=>Message::getError()
	]);

});

// Tag Rename
$app->post("/admin/tags/:idtag/rename", function($idtag) {

	User::checkUser();

	$tag = new Tag();

	$tag->get((int)$idtag);

	if (!isset($_POST['destag']) || !$_POST['destag'])
	{
		Message::setError("Fill in the tag name field.");
		header("Location: /admin/tags/".$idtag."/rename");
		exit;
	}

	$tag->setData($_POST);

	$tag->update();

	Message::setSuccess("Tag renamed successfully.");
	
	header("Location: /admin/tags");

	exit;

});

?>