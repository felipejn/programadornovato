<?php if(!class_exists('Rain\Tpl')){exit;}?><!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- Styles and Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lora:ital@1&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/res/css/styles.css">
<style>
	.navlink {
		color: #505050;
		font-family: 'roboto slab', serif;
		font-size: 20px;
	}
	.navlink:hover {
		color: #505050;
		text-shadow: 1px 1px #505050;
	}
</style>
<title>Admin - programadorNOVATO</title>
</head>
<body>
<!-- Header -->
<header>
<div class="container-fluid text-center">
	<div class="row">
		<div class="col-sm-12" style="padding-bottom: 10px; background-color: #8f9779; font-family: 'Bree Serif', serif;">
			<h1><span style="font-size: 40px; color: white; padding: 2px;">{programador}</span><b> NOVATO</b></h1>
			<h4 style="font-size: 16px;"><kbd>Admin Area</kbd></h4>
		</div>		
	</div>
</div>
</header>
<!-- Navbar -->
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto bree">
      <li class="nav-item">
        <a class="nav-link px-3 active" href="/admin">HOME</a>
      </li>
      <li class="nav-item px-3 dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          USERS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/admin/users">LIST</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/admin/users/new">NEW USER</a>
        </div>
      </li>
      <li class="nav-item px-3 dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          POSTS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/admin/posts">LIST</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/admin/posts/new">NEW POST</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3" target="_blank" href="/">BLOG</a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3" href="/admin/logout">LOGOUT</a>
      </li>
    </ul>
  </div>
</nav>
</div>
<!-- Navbar end -->


