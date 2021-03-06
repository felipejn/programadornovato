<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Main Container -->
<div class="container" style="min-height: 500px;">
	<div class="row">
		<!-- Content -->
		<div class="col-sm-8">
			
			<!-- Success Message -->
			<?php if( $success != '' ){ ?>

			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<center><?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></center>
			</div>
			<?php } ?>

			<!-- Error message -->
			<?php if( $error != '' ){ ?>

			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
						aria-hidden="true">&times;</span>
				</button>
				<center><?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></center>
			</div>
			<?php } ?>

			<!-- Post Loop -->
			<?php $counter1=-1;  if( isset($posts) && ( is_array($posts) || $posts instanceof Traversable ) && sizeof($posts) ) foreach( $posts as $key1 => $value1 ){ $counter1++; ?><?php if( $value1["despub"] == true ){ ?>

			<div class="row" style="box-shadow: 5px 5px 5px gray;">
				<div class="col-sm-12">
					<!-- Title -->
					<h1 style="font-family: 'Bree Serif', serif; font-size: 30px; padding-bottom: 2rem;"><a style="color: black;" href="/posts/<?php echo htmlspecialchars( $value1["desurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["destittle"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></h1>
					<p style="font-family: 'Bree Serif', serif;"><?php echo formatDate($value1["dtregister"]); ?><?php $counter2=-1; $newvar2=getSelectedTags($value1["idpost"]); if( isset($newvar2) && ( is_array($newvar2) || $newvar2 instanceof Traversable ) && sizeof($newvar2) ) foreach( $newvar2 as $key2 => $value2 ){ $counter2++; ?><a href="/tags/<?php echo htmlspecialchars( $value2["destag"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"> • #<?php echo htmlspecialchars( $value2["destag"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </a><?php } ?></p>
					<hr>
					<!-- Content Text -->
					<?php if( checkPostImage($value1["idpost"]) === true ){ ?>

					<div class="col-sm-12 center-block">	
						<img class="img-responsive" height="auto" src="<?php echo getPostImage($value1["idpost"]); ?>">
					</div>
					<?php } ?>

					<div class="col-sm-12" style="padding-top: 2rem; padding-bottom: 2rem;">
						
						<div style="font-family: 'Roboto Slab', serif; font-size: 18px; text-align: justify;"><?php echo $value1["destext"]; ?></div>
						<?php if( isset($value1["deslink"]) && $value1["deslink"] != '' ){ ?><a href="<?php echo $value1["deslink"]; ?>" style="font-family: 'Roboto Slab', serif; font-size: 18px;">Leia mais...</a><?php } ?>

						
					</div>
					<hr>
				</div>
			</div>
			<div class="row" style="padding-top: 2rem;"></div>
			<?php } ?><?php } ?>

			<!-- Post Loop End -->
			
			<!-- Pagination -->
			<nav aria-label="Page navigation" class="text-center">
					<ul class="pagination">
						<?php $counter1=-1;  if( isset($pages) && ( is_array($pages) || $pages instanceof Traversable ) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>

						<li><a href="<?php echo htmlspecialchars( $value1["link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["page"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
						<?php } ?>

					</ul>
			</nav>
			<!-- Pagination End -->
		</div>
		<!-- Content End -->
