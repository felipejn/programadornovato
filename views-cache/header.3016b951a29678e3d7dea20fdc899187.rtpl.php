<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt">
<head>
  <title>programador NOVATO</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- BootStrap CSS Style -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- CSS Styles and Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lora:ital@1&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>
<body>

<!-- Header -->
<header>
<div class="container-fluid text-center">
	<div class="row">
		<div class="col-sm-12" style="padding-bottom: 10px; background-color: #8f9779; font-family: 'Bree Serif', serif;">
			<h1><span style="font-size: 40px; color: white; padding: 2px;">{programador}</span><b> NOVATO</b></h1>
			<h4 style="font-size: 16px;"><code>/* assuntos para quem está começando */</code></h4>
		</div>		
	</div>
</div>
</header>
<!-- Header End -->

<!-- Nav Bar -->
<div class="container-fluid">
	<div class="row" style="font-size: 15px; font-family: 'Bree Serif', serif;">
		<div class="navbar navbar-default navbar-static-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href=""></a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="#"><i class="fas fa-home"></i> HOME</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">TAGS
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">PHP</a></li>
							<li><a href="#">JavaScript</a></li>
							<li><a href="#">CSS</a></li>
							<li><a href="#">GIT</a></li>
							<li><a href="#">SQL</a></li>
						</ul>
					</li>
					<li><a href="#">SOBRE</a></li>
				</ul>
				<form class="navbar-form navbar-left" action="#" method="GET">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Procurar..." name="search" id="search">
						<button><i class="fas fa-search"></i></button>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
<!-- Nav Bar End -->