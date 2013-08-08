
	<div class="clear"></div>

</div> <!-- /container -->

<!-- LOCATION -->
<div id="location" class="info">
	<div class="title float-right"><i class="icon-map-marker"></i></div>
	<p class="muted float-right">
		<span id="my_location">...</span>
	 <i class="icon-signal"></i> <span id="my_accuracy">...</span>
	</p>
</div>

<!-- DEBUG -->
<?php  if ($_GET["debug"] == "") { ?>
<div id="debug" class="info">
	<div class="title float-right"><i class="icon-bug"></i></div>
	<div class="muted float-right">
		<form class="form-inline ">
			<input id="longitude" type="text" value="" class="input-medium" placeholder="longitude">
			<input id="latitude" type="text" value="" class="input-medium" placeholder="latitude">
		</form>
	</div>
</div>
<?php } ?>


<!-- COPYRIGHT -->
<div id="copyright" class="info">
	<div class="title float-right"><i class="icon-info-sign"></i></div>
	<p class="text-right float-right">Luka Puharic 2013</p>
</div>

<!-- MODAL -->
<div  id="modal" class="modal hide fade" data-keyboard="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Modal header</h3>
	</div>
	<div class="modal-body">
		<?php include("modal.php") ?>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary">Edit</a>
		<a href="#" class="btn btn-danger">Delete</a>
	</div>
</div>

<?php show_legend(); ?>
