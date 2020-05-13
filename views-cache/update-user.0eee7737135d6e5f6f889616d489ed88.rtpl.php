<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Content -->
<div class="container" style="min-height: 500px;">
	<nav aria-label="breadcrumb">
  		<ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
		    <li class="breadcrumb-item active"><a href="/admin/users">Users</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Update User</li>
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

	<!-- Success Message -->
	<?php if( $success != '' ){ ?>

	<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		  </button>
		  <center><?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></center>
	</div>
	<?php } ?>

	<form action="/admin/users/<?php echo htmlspecialchars( $user["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/update" method="POST">
		<div class="form-row py-2">
			<div class="col">
				<label for="desname">Name</label>
				<input type="text" value="<?php echo htmlspecialchars( $user["desname"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="form-control" id="desname" name="desname">
			</div>
			<div class="col">
				<label for="desemail">Login</label>
				<input type="email" value="<?php echo htmlspecialchars( $user["desemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="form-control" id="desemail" name="desemail">
			</div>	
		</div>
		<div class="form-row py-2">
			<div class="col-sm-6">
				<label for="despassword">New Password</label>
				<input type="password" class="form-control" id="despassword" name="despassword">
			</div>
			<div class="col-sm-6">
				<label for="despassword">Confirm Password</label>
				<input type="password" class="form-control" id="verifypassword" name="verifypassword">
			</div>
		</div>
		<div class="form-group">
	    	<input class="btn btn-primary" type="submit" value="Submit">
	    	<a class="btn btn-danger" href="/admin/users" onclick="return confirm('Are you sure you want to cancel?')" role="button">Cancel</a>
	    </div>
	</form>
</div>
<!-- Content end -->
