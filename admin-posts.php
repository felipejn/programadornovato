<?php

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;
use \Pronov\Message;  

// Create Post
$app->get("/admin/posts/create", function() {

	User::checkUser();

	$page = new PageAdmin();

	$page->setTpl("create-post", [
		'tags'=>Tag::listAll(),
		'error'=>Message::getError()
	]);

});

// Create Post
$app->post("/admin/posts/create", function() {

	User::checkUser();

	if (!isset($_POST['destittle']) || !$_POST['destittle'])
	{
		Message::setError("Fill in the tittle field.");
		header("Location: /admin/posts/create");
		exit;
	}

	if (!isset($_POST['desurl']) || !$_POST['desurl'])
	{
		Message::setError("Fill in the url field.");
		header("Location: /admin/posts/create");
		exit;
	}

	if (!isset($_POST['destext']) || !$_POST['destext'])
	{
		Message::setError("Fill in the text field.");
		header("Location: /admin/posts/create");
		exit;
	}

	$_POST['despub'] = (isset($_POST['despub']) && $_POST['despub'] == "on") ? true : false;

	$post = new Post();

	$post->setData($_POST);

	$post->createPost();

	$post->setTags();

	if (isset($_FILES['desimage']['name']) && $_FILES['desimage']['name'] != "")
	{
		if ($_FILES['desimage']['error'] === 0) 
		{
			$post->setImage($_FILES['desimage']);
		} else {
			Message::setError("File upload error!");
			header("Location: /admin/posts/create");
			exit;
		}
	}
	
	header("Location: /admin/posts");

	exit;	

});

// List Posts
$app->get("/admin/posts", function() {

	User::checkUser();

	$post = new Post();

	$page = (int)($_GET['page'] ?? 1);

	$pagination = $post->getPosts($page, $itemsPerPage = 15);

	$pages = [];

	for ($i = 1; $i <= $pagination['pages']; $i++) { 
		array_push($pages, [
			'link'=>"/admin/posts?page=".$i,
			'page'=>$i
		]);
	}

	$page = new PageAdmin();

	$page->setTpl("posts", [
		'posts'=>$pagination['posts'],
		'pages'=>$pages,
		'success'=>Message::getSuccess()
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

// Update Posts
$app->get("/admin/posts/:idpost/update", function($idpost) {

	User::checkUser();

	$post = new Post();

	$post->get((int)$idpost);

	$page = new PageAdmin();

	$page->setTpl("update-post", [
		'post'=>$post->getValues(),
		'tags'=>$post->getTags(),
		'error'=>Message::getError()
	]);

});

// Update Posts
$app->post("/admin/posts/:idpost/update", function($idpost) {

	User::checkUser();

	if (!isset($_POST['destittle']) || !$_POST['destittle'])
	{
		Message::setError("Fill in the tittle field.");
		header("Location: /admin/posts/create");
		exit;
	}

	if (!isset($_POST['desurl']) || !$_POST['desurl'])
	{
		Message::setError("Fill in the url field.");
		header("Location: /admin/posts/create");
		exit;
	}

	if (!isset($_POST['destext']) || !$_POST['destext'])
	{
		Message::setError("Fill in the text field.");
		header("Location: /admin/posts/create");
		exit;
	}

	$_POST['despub'] = (isset($_POST['despub']) && $_POST['despub'] == "on") ? true : false;

	$post = new Post();

	$post->get((int)$idpost);

	$post->setdata($_POST);

	$post->updatePost();

	$post->updateTags();

	if (isset($_FILES['desimage']['name']) && $_FILES['desimage']['name'] != "")
	{
		if ($_FILES['desimage']['error'] === 0) 
		{
			$post->setImage($_FILES['desimage']);
		} else {
			Message::setError("File upload error!");
			header("Location: /admin/posts/create");
			exit;
		}
	}
	
	Message::setSuccess("Post updated successfully!");
	
	header("Location: /admin/posts");

	exit;

});

?>