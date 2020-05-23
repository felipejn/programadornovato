<?php  

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;

// Post Page
$app->get("/posts/:desurl", function($desurl) {
	
	$page = new Page();

	$page->setTpl("post", [
		'post'=>Post::getByUrl($desurl)
	]);

});

// Site
$app->get("/", function() {

	$post = new Post();

	$page = (int)($_GET['page'] ?? 1);

	$pagination = $post->getPostPages($page);

	$pages = [];

	for ($i = 1; $i <= $pagination['pages']; $i++) { 
		array_push($pages, [
			'link'=>"/?page=".$i,
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