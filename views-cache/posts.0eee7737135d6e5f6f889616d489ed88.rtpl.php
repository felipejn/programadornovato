<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Content -->
<div class="container">
	<nav aria-label="breadcrumb">
  		<ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Posts</li>
		</ol>
	</nav>
	<table class="table table-striped table-responsive{sm}">
	<thead>
		<tr>
		<th scope="col">Id</th>
		<th scope="col">User</th>
		<th scope="col">Tittle</th>
		<th scope="col">Date</th>
		<th scope="col">Published</th>
		<th style="min-width: 210px;"scope="col">Options</th>
		</tr>
	</thead>
	<tbody>
	<?php $counter1=-1;  if( isset($posts) && ( is_array($posts) || $posts instanceof Traversable ) && sizeof($posts) ) foreach( $posts as $key1 => $value1 ){ $counter1++; ?>

	<tr>
		<th scope="row"><?php echo htmlspecialchars( $value1["idpost"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
		<td><?php echo htmlspecialchars( $value1["desname"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><?php echo htmlspecialchars( $value1["destittle"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><?php echo htmlspecialchars( $value1["dtregister"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
		<td><?php if( $value1["despub"] == 0 ){ ?> No <?php }else{ ?> Yes <?php } ?></td>
		<td><div class="btn-group-sm" role="group" aria-label="Button group with nested dropdown">
		  <a class="btn btn-primary" href="#" role="button"><?php if( $value1["despub"] == 0 ){ ?> Publish <?php }else{ ?> Unpublish <?php } ?></a>
		  <a class="btn btn-secondary" href="#" role="button">Edit</a>
		  <a class="btn btn-danger" href="#" role="button">Delete</a>
		</td>
	</tr>
	<?php } ?>

	<!-- Loop end -->
	</tbody>
	</table>
</div>
<!-- Content end -->

