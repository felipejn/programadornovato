<?php

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;  

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

// Delete Posts
$app->get("/admin/posts/:idpost/delete", function($idpost) {

	User::checkUser();

	$post = new Post();

	$post->get((int)$idpost);

	$post->delete();

	header("Location: /admin/posts");

	exit;

});

// Change Status Publish / Unpublish
$app->get("/admin/posts/:idpost/changestatus", function($idpost) {

	User::checkUser();

	$post = new Post();

	$post->get((int)$idpost);

	$post->changeStatus();

	header("Location: /admin/posts");

	exit;

});

?>