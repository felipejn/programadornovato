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
	
	<form action="/admin/posts/create" method="POST">
		<div class="form-group">
			<label for="destittle">Tittle</label>
			<input type="text" class="form-control" id="destittle" name="destittle">
		</div>
		
		<div class="form-row py-2">
			<div class="col">
				<label for="desurl">Url</label>
				<input type="text" class="form-control" id="desurl" name="desurl">
			</div>
			<div class="col">
				<label for="deslink">Link</label>
				<input type="text" class="form-control" id="deslink" name="deslink">
			</div>	
		</div>
		<div class="form-group py-2">
			<label for="tags">Tags</label>
			<div class="form-check" id="tags">
				<input class="form-check-input" type="checkbox" name="idtag1" id="idtag1">
				<label class="form-check-label pr-5" for="idtag1">Tag 1</label>
				<input class="form-check-input" type="checkbox" name="idtag2" id="idtag2">
				<label class="form-check-label pr-5" for="idtag2">Tag 2</label>
				<input class="form-check-input" type="checkbox" name="idtag3" id="idtag3">
				<label class="form-check-label pr-5" for="idtag3">Tag 3</label>
			</div>
		</div>
		<div class="form-group py-2">
			<div class="form-group">
				<label for="desimage">Upload a image</label>
				<input type="file" class="form-control-file" id="desimage" name="desimage">
			</div>
		</div>
		<div class="form-group">
		    <label for="destext">Text</label>
		    <textarea class="form-control" id="destext" name="destext" rows="10"></textarea>
		</div>
		<div class="form-group form-check">
		    <input type="checkbox" class="form-check-input" id="despublish" name="despublish">
		    <label class="form-check-label" for="despub">Publish?</label>
	    </div>
	    <div class="form-group">
	    	<input class="btn btn-primary" type="submit" value="Submit">
	    	<a class="btn btn-danger" href="/admin/posts" onclick="return confirm('Are you sure you want to cancel?')" role="button">Cancel</a>
	    </div>			
	</form>
</div>
<!-- Content end -->
