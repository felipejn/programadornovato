<?php if(!class_exists('Rain\Tpl')){exit;}?>

<!-- Content -->
<div class="container" style="min-height: 500px;">
	<nav aria-label="breadcrumb">
  		<ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
		    <li class="breadcrumb-item active"><a href="/admin/posts">Posts</a></li>
		    <li class="breadcrumb-item active" aria-current="page">New Post</li>
		</ol>
	</nav>
	<?php if( $error != '' ){ ?>

	<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		  </button>
		  <center><?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></center>
	</div>
	<?php } ?>

	<form action="/admin/posts/create" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label for="destittle">Tittle</label>
			<input type="text" class="form-control" id="destittle" name="destittle">
		</div>
		
		<div class="form-row py-2">
			<div class="col">
				<label for="desurl">Post Url</label>
				<input type="text" class="form-control" id="desurl" name="desurl">
			</div>
			<div class="col">
				<label for="deslink">Target Link</label>
				<input type="text" class="form-control" id="deslink" name="deslink">
			</div>	
		</div>
		<div class="form-group py-2">
			<label for="tags">Tags</label>
			<div class="form-check" id="tags">
				<?php $counter1=-1;  if( isset($tags) && ( is_array($tags) || $tags instanceof Traversable ) && sizeof($tags) ) foreach( $tags as $key1 => $value1 ){ $counter1++; ?>

				<input class="form-check-input" type="checkbox" name="idtag<?php echo htmlspecialchars( $value1["idtag"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="<?php echo htmlspecialchars( $value1["destag"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
				<label class="form-check-label pr-5" for="<?php echo htmlspecialchars( $value1["destag"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["destag"], ENT_COMPAT, 'UTF-8', FALSE ); ?></label>
				<?php } ?>

			</div>
		</div>
		<div class="form-row py-2">
			<div class="col-sm-4">
				<img src="/res/img/blank.png" class="img-thumbnail">
			</div>
			<div class="col-sm-8 form-group py-2">
				<div class="form-group">
					<label for="desimage">Upload a image</label>
					<input type="file" class="form-control-file" id="desimage" name="desimage">
				</div>
			</div>
		</div>
		<div class="form-group py-2">
		    <label for="destext">Text</label>
		    <textarea class="form-control" id="destext" name="destext" rows="10"></textarea>
		</div>
		<div class="form-group form-check">
		    <input type="checkbox" class="form-check-input" id="despub" name="despub">
		    <label class="form-check-label" for="despub">Publish?</label>
	    </div>
	    <div class="form-group">
	    	<input class="btn btn-primary" type="submit" value="Submit">
	    	<a class="btn btn-danger" href="/admin/posts" onclick="return confirm('Are you sure you want to cancel?')" role="button">Cancel</a>
	    </div>			
	</form>
</div>
<!-- Content end -->
