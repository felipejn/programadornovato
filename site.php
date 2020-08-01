<?php  

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;
use \Pronov\Message;

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
		'success'=>Message::getSuccess(),
		'error'=>Message::getError()
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
		'pages'=>$pages,
		'success'=>Message::getSuccess(),
		'error'=>Message::getError()
	]);

});

// Subscribe
$app->post("/subscribe", function() {

	if (isset($_POST['dessubscriber']) && $_POST['dessubscriber'] != "")
	{
		
		$subscriber = new User();

		$subscriber->setData($_POST);

		$subscriber->saveSubscriber();

		Message::setSuccess("Inscrição realizada com sucesso!");
		header("Location: /");
		exit;

	} else {

		Message::setError("Insira um email válido!");
		header("Location: /");
		exit;

	}

});

?>