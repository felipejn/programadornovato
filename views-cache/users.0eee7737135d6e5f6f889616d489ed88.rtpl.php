<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Content -->
<div class="container" style="min-height: 500px;">
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Users</li>
	</ol>
</nav>

	<table class="table table-striped table-bordered">
	<thead>
		<tr>
		<th scope="col">Id</th>
		<th scope="col">Nome</th>
		<th scope="col">Login</th>
		<th style="min-width: 100px;" scope="col">Options</th>
		</tr>
	</thead>
	<tbody>
	<?php $counter1=-1;  if( isset($users) && ( is_array($users) || $users instanceof Traversable ) && sizeof($users) ) foreach( $users as $key1 => $value1 ){ $counter1++; ?>

	<tr>
		<th scope="row"><?php echo htmlspecialchars( $value1["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
		<td><?php echo htmlspecialchars( $value1["desname"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><?php echo htmlspecialchars( $value1["desemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><div class="btn-group-sm" role="group" aria-label="Button group with nested dropdown">
		  <a class="btn btn-secondary" href="/admin/users/<?php echo htmlspecialchars( $value1["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/update" role="button">Update</a>
		  <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')"href="/admin/users/<?php echo htmlspecialchars( $value1["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" role="button">Delete</a>
		</td>
	</tr>
	<?php } ?>

	<!-- Loop end -->
	</tbody>
	</table>
</div>
<!-- Content end -->

