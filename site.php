<?php  

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;

// Site
$app->get("/", function() {

	$post = new Post();

	$page = (int)($_GET['page'] ?? 1);
	$search = $_GET['search'] ?? "";
	
	if ($search != "")
	{
		$pagination = $post->getSearchPosts($search, $page);
		
	} else {
		$pagination = $post->getPosts($page);
	}	

	$pages = [];

	for ($i = 1; $i <= $pagination['pages']; $i++) { 
		array_push($pages, [
			'link'=>"?".http_build_query([
				'page'=>$i,
				'search'=>$search
			]),
			'page'=>$i
		]);
	}

	$page = new Page();

	$page->setTpl("index", [
		'posts'=>$pagination['posts'],
		'pages'=>$pages,
		'search'=>$search,
		'success'=>Post::getSuccess(),
		'error'=>Post::getError()
	]);

});

// Post Page
$app->get("/posts/:desurl", function($desurl) {
	
	$post = new Post();

	$post->getByUrl($desurl);
	
	$page = new Page();

	$page->setTpl("post", [
		'post'=>$post->getValues()
	]);

});

// Tag Page
$app->get("/tags/:destag", function($destag) {

	$post = new Post();

	$page = (int)($_GET['page'] ?? 1);

	$pagination = $post->getByTag($destag, $page);

	$pages = [];

	for ($i = 1; $i <= $pagination['pages']; $i++) { 
		array_push($pages, [
			'link'=>"/tags/$destag?page=".$i,
			'page'=>$i
		]);
	}

	$page = new Page();

	$page->setTpl("index", [
		'posts'=>$pagination['posts'],
		'pages'=>$pages
	]);

});

// Subscribe
$app->post("/subscribe", function() {

	if (isset($_POST['dessubscriber']) && $_POST['dessubscriber'] != "")
	{
		
		$subscriber = new User();

		// var_dump($_POST);
		// exit;

		$subscriber->setData($_POST);

		$subscriber->saveSubscriber();

		Post::setSuccess("Inscrição realizada com sucesso!");
		header("Location: /");
		exit;

	} else {

		Post::setError("Insira um email válido!");
		header("Location: /");
		exit;

	}

});

?>