<?php  

use \Pronov\Page;
use \Pronov\PageAdmin;
use \Pronov\Model\User;
use \Pronov\Model\Post;
use \Pronov\Model\Tag;

// Site
$app->get("/", function() {

	$page = new Page();

	$page->setTpl("index");

});

?>