<?php  

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new \Slim\Slim();

$app->config("debug", true);

require_once("admin-users.php");
require_once("admin-posts.php");
require_once("admin-tags.php");
require_once("site.php");
require_once("admin.php");
require_once("functions.php");

$app->run();

?>