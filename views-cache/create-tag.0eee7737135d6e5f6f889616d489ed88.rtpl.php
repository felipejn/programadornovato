<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Content -->
<div class="container" style="min-height: 500px;">
	<nav aria-label="breadcrumb">
  		<ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
		    <li class="breadcrumb-item active"><a href="/admin/tags">Tags</a></li>
		    <li class="breadcrumb-item active" aria-current="page">New Tag</li>
		</ol>
	</nav>
	<!-- Error Message -->
	<?php if( $error != '' ){ ?>

	<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		  </button>
		  <center><?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></center>
	</div>
	<?php } ?>

	<form action="/admin/tags/create" method="POST">
		<div class="form-row py-2">
			<div class="col">
				<label for="destag"> Tag Name</label>
				<input type="text" class="form-control" id="destag" name="destag">
			</div>
		</div>
		<div class="form-row py-2">
			<div class="form-group">
		    	<input class="btn btn-primary" type="submit" value="Submit">
		    	<a class="btn btn-danger" href="/admin/users" onclick="return confirm('Are you sure you want to cancel?')" role="button">Cancel</a>
		    </div>
		</div>
	</form>
</div>
<!-- Content end -->
