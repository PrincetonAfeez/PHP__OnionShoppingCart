<?php
/* import required classes */
importClass('model/productmanager');
importClass('model/brand');
importClass('model/vendor');
importClass('model/vendormanager');
importClass('model/category');
importClass('model/brandmanager');
?>
<?php 
/* Create instant */
$model['productManager'] = new ProductManager($db);
$model['productManager']->setInstance('product_id', $_POST['product_id']);

$model['brandManager'] = new BrandManager($db);
$model['category'] = new Category($db);
$model['vendorManager'] = new VendorManager($db);
?>
<h1>You are now editing: #<?= $model['productManager']->getProductId(); ?></h1>
<form class="edit-form" method="post" action="<?= htmlentities($_SERVER['REQUEST_URI'])?>">
	<input type="hidden" name="product_id" value="<?= $model['productManager']->getProductId(); ?>" />
	<div id="basic-product-information" class="well">
		<div class="well-heading">Basic Product Information</div>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon3">Status:</span>
			<input type="checkbox" id="product-status" name="status" value="ON" data-toggle="toggle"<?php 
			if ($model['productManager']->getStatus()=='ON'){
				echo ' checked';
			}
			?>>
		</div>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon3">Name:</span>
			<input type="text" name="product_id" class="form-control"
				value="<?= $model['productManager']->getName(); ?>">
		</div>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon3">Slug:</span>
			<input type="text" name="slug" class="form-control"
				value="<?= $model['productManager']->getSlug(); ?>">
			<br />
			<span class="product-uri"></span>
		</div>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon3">Description:</span>
			<textarea id="tinymce-textarea" name="description" class="form-control"><?= html_entity_decode($model['productManager']->getDescription()); ?></textarea>
		</div>
		<div class="input-group col-xs-2">
			<span class="input-group-addon" id="basic-addon3">Unit:</span>
			<input type="text" name="unit" class="form-control"
				value="<?= $model['productManager']->getUnit(); ?>">
		</div>
		<div class="input-group col-xs-2">
			<span class="input-group-addon" id="basic-addon3">Weight:</span>
			<input type="text" name="weight" class="form-control"
				value="<?= $model['productManager']->getWeight(); ?>">
			<span class="input-group-addon" id="basic-addon3">Kg</span>
		</div>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon3">Brand:</span>
			<select name="brand_id" class="form-control">
				<option value="">Please Select...</option>
				<?php 
				$model['brandManager']->sortBrandList('name');
				$firstChar = '';
				foreach ($model['brandManager']->getBrandListId() as $brandId){
					$thisBrand = new Brand($db);
					$thisBrand->setInstance('brand_id',$brandId);
					$thisFirstChar = substr($thisBrand->getName(),0,1);
					$newOptGroup = false;
					if ($thisFirstChar!=$firstChar){
						if ($firstChar != ''){
							echo '</optgroup>';
						}
						$firstChar = $thisFirstChar;
						echo '<optgroup label="'.$firstChar.'">';
					}
					echo '<option value="'.$brandId.'"';
					if ($brandId == $model['productManager']->getBrandId()){
						echo ' selected';
					}
					echo '>'.$thisBrand->getName().'</option>';
				}
				echo '</optgroup>
					<optgroup label="Can\'t find in the list?">
						<option value="">Add new brand...</option>
					</optgroup>';
				?>
			</select>
			<input type="text" name="newBrandName" class="form-control" placeholder="Enter the brand name here if it does not exist on the list.">
		</div>
		<div class="input-group submit col-xs-12">
			<input type="submit" name="submit" value="Save" />
		</div>
	</div>
	
	<div id="category-list" class="well">
		<div class="well-heading">Category</div>
		<div class="form-group">
			<label for="sel1">Select the specific category:</label>
			<p><select name="cat_id" class="form-control">
				<option value="">** NOT SPECIFIED **</option>
				<?php
				function loadSubCat($model, $slug, $recursiveIndex = 1){
					foreach ($model['category']->getCategoryList($slug) as $subCat) {
						echo '<option value="'.$subCat['cat_id'].'"';
						if ($subCat['cat_id'] == $model['productManager']->getCategory()) {
							echo ' selected';
						}
						echo '>'.str_repeat("-- ", $recursiveIndex).$subCat['name'].'</option>';
						loadSubCat($model,$subCat['slug'], $recursiveIndex+1);
					}
				}
				
				foreach ($model['category']->getRootCategoryList() as $rootCat) {
					echo '<option value="'.$rootCat['cat_id'].'"';
					if ($rootCat['cat_id'] == $model['productManager']->getCategory()) {
						echo ' selected';
					}
					echo '>'.$rootCat['name'].'</option>';	
					loadSubCat($model,$rootCat['slug']);
				}
				?>
				</select>
				</p>
		</div>
		<div><button type="button" id="open-add-category" class="btn btn-default">Create sub-category for the this category</button></div>
		<div class="add-category-form input-group col-xs-6">
			<span class="input-group-addon" id="basic-addon3">New sbu-category name:</span>
			<input type="text" name="subcat_name" class="form-control">
		</div>
		<div class="add-category-form input-group col-xs-6">
			<span class="input-group-addon" id="basic-addon3">Slug:</span>
			<input type="text" name="subcat_slug" class="form-control">
		</div>
		<div class="add-category-form input-group col-xs-6">
		<button id="add-category-action-btn" class="btn btn-default" type="button">Add category</button>
		</div>
	</div>

	<div id="variation-list" class="well">
		<div class="well-heading">Variation
			<button type="button" id="add-variation" class="btn btn-default">Create variation</button></div>
		<div class="add-new-variation-input input-group no-gutter">
			<div class="col-xs-3">
				<span class="input-group-addon" id="basic-addon3">Name:</span>
				<input type="text" name="newVariation" value="" class="form-control" />
			</div>
			<div class="col-xs-9">
				<span class="input-group-addon" id="basic-addon3">Options:</span>
				<input type="text" name="newVariationOptions" value="" class="form-control" />
			</div>
		</div>
	</div>
		
	<div id="selling-price-list" class="well">
		<div class="well-heading">Selling price list
			<button type="button" id="add-supplier" class="btn btn-default">Create new supplier</button></div>
		<table class="table table-bordered table-striped">
			<tbody>
			</tbody>
		</table>
		<div class="add-sellingprice-panel">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Choose vendor:</span>
				<select name="newprice_vendor" class="form-control">
				<?php
				foreach ($model['vendorManager']->getVendorList() as $row) {
					echo '<option value="'.$row['vendor_id'].'">'.$row['name'].'</option>';
				}
				?>
				</select>
			</div>
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Cost:</span>
				<span class="input-group-addon">
                  <input type="radio" name="currency" value="AUD" checked />AUD
                  <input type="radio" name="currency" value="HKD" />HKD
                </span>
				<input type="text" name="cost" class="form-control" />
			</div>
			<div class="input-group col-xs-2">
				<input type="submit" name="btn-add-sellingprice" class="form-control btn btn-default" value="Add new supplier" />
			</div>
		</div>
	</div>
	
	<?php require './views/elements/components/gallery_attachment_thumbnails.php'; ?>
	
</form>

<?php require './views/elements/components/modal_ajax_result_window.php'; ?>
<?php require './views/elements/components/modal_price_list_editor.php'; ?>