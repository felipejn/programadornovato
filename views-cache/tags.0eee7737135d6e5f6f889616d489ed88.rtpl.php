<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Content -->
<div class="container" style="min-height: 500px;">
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Tags</li>
	</ol>
</nav>
	<!-- Success Message -->
	<?php if( $success != '' ){ ?>

	<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		  </button>
		  <center><?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></center>
	</div>
	<?php } ?>

	<table class="table table-striped table-bordered">
	<thead>
		<tr>
		<th scope="col">Id</th>
		<th scope="col">Tag Name</th>
		<th style="max-width: 250px; min-width: 100px;" scope="col">Options</th>
		</tr>
	</thead>
	<tbody>
	<?php $counter1=-1;  if( isset($tags) && ( is_array($tags) || $tags instanceof Traversable ) && sizeof($tags) ) foreach( $tags as $key1 => $value1 ){ $counter1++; ?>

	<tr>
		<th scope="row"><?php echo htmlspecialchars( $value1["idtag"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
		<td><?php echo htmlspecialchars( $value1["destag"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><div class="btn-group-sm" role="group" aria-label="Button group with nested dropdown">
		  <a class="btn btn-secondary" href="/admin/tags/<?php echo htmlspecialchars( $value1["idtag"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/rename" role="button">Rename</a>
		  <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')"href="/admin/tags/<?php echo htmlspecialchars( $value1["idtag"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" role="button">Delete</a>
		</td>
	</tr>
	<?php } ?>

	<!-- Loop end -->
	</tbody>
	</table>
</div>
<!-- Content end -->

