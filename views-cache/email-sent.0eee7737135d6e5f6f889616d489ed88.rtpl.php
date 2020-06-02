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
	<link rel="stylesheet" type="text/css" href="/css/styles.css">
<style>
	body {
		background-color: lightgray;
	}
	.logtittle {
		font-family: 'Bree Serif', serif;
		text-align: center;
		color: white;
	}
	.loginbox {
		box-shadow: 5px 5px 5px 1px gray;
	}
</style>

</head>
<body>

<div class="container" style="margin-top: 10rem;">
	<div class="row">
		<div class="col-sm-3"></div>
		<!-- Login box -->
		<div class="col-sm-6 loginbox" style="background-color: #8f9779;">
			<!-- <div class="col-sm-12 text-center" style="font-family: 'Bree Serif', serif;">
                <h2><span style="font-size: 31px; color: white; padding: 2px;">{programador}</span><b> NOVATO</b></h1>
            </div> -->
            <div class="col-sm-12"><br></div>		
			<div class="col-sm-12 text-center">
                <h3 class="logtittle">Password reset email sent</h3>
                <p><strong>An email has been sent to your email address <?php echo htmlspecialchars( $email, ENT_COMPAT, 'UTF-8', FALSE ); ?>. Please check your inbox.</strong></p>
            </div>
            <div class="col-sm-12"><br></div>
		</div>
		<!-- Login box end -->
		<div class="col-sm-3"></div>
	</div>
</div>
<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
