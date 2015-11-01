
<div id="image-list" class="well">
	<div class="row">
		<div class="col-xs-12 col-sm-2">
			<img id="img-preview" class="col-xs-12" src="<?= $model['productManager']->getFeatureImage(); ?>" />
		</div>
		<div class="col-xs-12 col-sm-10">
			<div class="well-heading">Feature Image</div>
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Image URL:</span>
				<input type="text" name="feature_image_url" class="form-control" value="<?= $model['productManager']->getFeatureImage(); ?>">
				<span id="btn_change_feature_image" class="input-group-addon">Change</span>
			</div>
		</div>	
	</div>
</div>
	
<?php require "./views/elements/components/model_image_selector.php" ?>
