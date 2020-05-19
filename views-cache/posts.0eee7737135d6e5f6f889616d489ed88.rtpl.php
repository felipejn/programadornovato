<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Content -->
<div class="container" style="min-height: 500px;">
	<nav aria-label="breadcrumb">
  		<ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Posts</li>
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

	<table class="table table-striped table-bordered table-responsive{sm}">
	<thead>
		<tr>
		<th scope="col">Id</th>
		<th scope="col">User</th>
		<th scope="col">Tittle</th>
		<th scope="col">Date</th>
		<th scope="col">Published</th>
		<th style="min-width: 220px;"scope="col">Options</th>
		</tr>
	</thead>
	<tbody>
	<?php $counter1=-1;  if( isset($posts) && ( is_array($posts) || $posts instanceof Traversable ) && sizeof($posts) ) foreach( $posts as $key1 => $value1 ){ $counter1++; ?>

	<tr>
		<th scope="row"><?php echo htmlspecialchars( $value1["idpost"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
		<td><?php echo htmlspecialchars( $value1["desname"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><?php echo htmlspecialchars( $value1["destittle"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><?php echo htmlspecialchars( $value1["dtregister"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><?php if( $value1["despub"] == false ){ ?> No <?php }else{ ?> Yes <?php } ?></td>
		<td><div class="btn-group-sm" role="group" aria-label="Button group with nested dropdown">
		  <a class="btn btn-primary" href="/admin/posts/<?php echo htmlspecialchars( $value1["idpost"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/changestatus" role="button"><?php if( $value1["despub"] == false ){ ?> Publish <?php }else{ ?> Unpublish <?php } ?></a>
		  <a class="btn btn-secondary" href="/admin/posts/<?php echo htmlspecialchars( $value1["idpost"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/update" role="button">Edit</a>
		  <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="/admin/posts/<?php echo htmlspecialchars( $value1["idpost"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" role="button">Delete</a>
		</td>
	</tr>
	<?php } ?>

	<!-- Loop end -->
	</tbody>
	</table>
</div>
<!-- Content end -->

