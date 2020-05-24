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
		'search'=>$search
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

?>