<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Main Container -->
<div class="container" style="min-height: 500px;">
	<div class="row">
		<!-- Content -->
		<div class="col-sm-8">
			
			<!-- Post Loop -->
			<div class="row" style="box-shadow: 5px 5px 5px gray;">
				<div class="col-sm-12">
					<!-- Title -->
					<h1 style="font-family: 'Bree Serif', serif; font-size: 30px; padding-bottom: 2rem;"><?php echo htmlspecialchars( $post["destittle"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
					<p style="font-family: 'Bree Serif', serif;"><?php echo formatDate($post["dtregister"]); ?> • <?php $counter1=-1; $newvar1=getSelectedTags($post["idpost"]); if( isset($newvar1) && ( is_array($newvar1) || $newvar1 instanceof Traversable ) && sizeof($newvar1) ) foreach( $newvar1 as $key1 => $value1 ){ $counter1++; ?><a href="#">#<?php echo htmlspecialchars( $value1["destag"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </a><?php } ?></p>
					<hr>
					<!-- Content Text -->
					<?php if( checkPostImage($post["idpost"]) === true ){ ?>

					<div class="col-sm-12 center-block">	
						<img class="img-responsive" height="auto" src="<?php echo getPostImage($post["idpost"]); ?>">
					</div>
					<?php } ?>

					<div class="col-sm-12">
						<p style="font-family: 'Roboto Slab', serif; font-size: 18px; text-align: justify;"><?php echo htmlspecialchars( $post["destext"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
						<?php if( isset($post["deslink"]) && $post["deslink"] != '' ){ ?><a href="<?php echo htmlspecialchars( $post["deslink"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="font-family: 'Roboto Slab', serif; font-size: 18px;">Leia mais...</a><?php } ?>

					</div>
					<hr>
				</div>
			</div>
			<div class="row" style="padding-top: 2rem;"></div>
	
			<!-- Post Loop End -->
			
			<!-- Pagination -->
			<nav aria-label="Page navigation" class="text-center">
					<ul class="pagination">
						<?php $counter1=-1;  if( isset($pages) && ( is_array($pages) || $pages instanceof Traversable ) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>

						<li><a href="<?php echo htmlspecialchars( $post["link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $post["page"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
						<?php } ?>

					</ul>
			</nav>
			<!-- Pagination End -->
		</div>
		<!-- Content End -->
