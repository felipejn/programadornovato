<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Sidebar -->
		<div class="col-sm-4" style="text-align: center; font-size: 20px;">
			<h2 style="font-family: 'Bree Serif', serif; font-size: 25px;">Últimas publicações</h2>
			<!-- Loop -->
			<?php $counter1=-1; $newvar1=getNPosts(5); if( isset($newvar1) && ( is_array($newvar1) || $newvar1 instanceof Traversable ) && sizeof($newvar1) ) foreach( $newvar1 as $key1 => $value1 ){ $counter1++; ?><?php if( $value1["despub"] == true ){ ?>

			<div class="row" style="padding-top: 1rem;">
				<div class="col-sm-12">
					<a href="/posts/<?php echo htmlspecialchars( $value1["desurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><code><?php echo htmlspecialchars( $value1["destittle"], ENT_COMPAT, 'UTF-8', FALSE ); ?></code></a>
					<hr>
				</div>
			</div>
			<!-- Fim do Loop -->
			<?php } ?><?php } ?>

			<a href="#" style="font-family: Bree Serif, serif;">Ver todas</a>
		</div>
		<!-- Sidebar End -->

	</div>
</div>
<!-- Main Container End -->

<!-- Footer -->
<div class="container-fluid text-center">
	<div class="row" style="background-color: #505050; color: gray;">
		<div class="col-sm-12" style="padding: 2rem;  font-family: 'Arial', serif; font-size: 15px;">
			<p>| Felipe Nascimento  | <i class="fas fa-envelope"></i> <a style="color: gray;" href="mailto:felipejn@gmail.com">felipejn@gmail.com</a> | 
				<i class="fab fa-github"></i><a style="color: gray;" href="https://github.com/felipejn"> Github</a> | 
				<form action="#" method="POST"><input type="submit" name="subscribeButton" value="Subscrever">
				<input type="email" name="subscribe" placeholder="email..."></form></p> 
		</div>
	</div>
</div>
<!-- Footer End -->

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
