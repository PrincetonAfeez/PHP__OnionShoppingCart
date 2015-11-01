<?php
/* import required classes */
importClass('model/vendormanager');
?>
<?php 
/* Create instant */
$model['vendorManager'] = new VendorManager($db);

$dataColumn = ['vendor_id','name','country_code','address','tel','fax'];
?>
<table id="vendor-list">
	<tr>
		<td colspan="3">
			<form class="searchbar" method="post" action="<?=htmlentities($_SERVER['REQUEST_URI']); ?>">
				<div class="input-group">
			      <input type="text" name="searchkey" class="form-control" value="<?php
			      if (isset($_POST['searchkey'])){
			      	htmlentities($_POST['searchkey']);
			      }
			      ?>" placeholder="Search for...">
			      <span class="input-group-btn">
			        <button type="submit" class="btn btn-default glyphicon glyphicon-search" type="button"></button>
			      </span>
			    </div>
			</form>
		</td>
	</tr>
	<tr>
		<form method="post" action="<?=htmlentities($_SERVER['REQUEST_URI']); ?>">
		<?php
		foreach($dataColumn as $col){
			echo '<td><button type="submit" name="sort" value="'.$col.'" class="btn btn-default action-sortby">'.$col.'</button></td>'."\n";
		}
		?>
		<td>操作</td>
		</form>
	</tr>
	<form method="post" action="<?= document_root() ?>/admin/edit-product">
	<?php
	$rowCounter = 0;
	$searchkey = '';
	$sort = '';
	if (isset($_POST['searchkey'])){
		$searchkey = $_POST['searchkey'];
	}
	if (isset($_POST['sort'])){
		$sort = $_POST['sort'];
	}
	foreach($model['vendorManager']->getVendorList($searchkey, $sort) as $row){
		$model['vendorManager']->setInstance('vendor_id', $row['vendor_id']);
		echo ' <tr';
		if ($rowCounter++ % 2 == 0){
			echo ' class="bulk-control table-row-odd"';
		} else {
			echo ' class="bulk-control table-row-even"';
		}
		echo '>'."\n";
		foreach($dataColumn as $col){
			echo '		<td>'.$row[$col].'</td>'."\n";
		}
		echo '		<td>
			<button type="submit" name="product_id" value="'.$row['vendor_id'].'" class="btn btn-default glyphicon glyphicon-pencil"></button>
		</td>'."\n";
		echo ' </tr>'."\n";
	}
	?>
	</form>
</table>
<p>&nbsp;</p>
<form id="add-vendor-form" method="post" action="<?= document_root() ?>/api/add-vendor" class="well">
		<div class="well-heading">New Vendor</div>
		<div class="input-group col-xs-5">
			<span class="input-group-addon" id="basic-addon3">Name:</span>
			<input type="text" name="name" class="form-control">
		</div>
		<div class="input-group col-xs-5">
			<span class="input-group-addon" id="basic-addon3">Country:</span>
			<select name="country_code" class="form-control">
				<option value="AU" selected>Australia (AU)</option>
				<option value="HK">Hong Kong (HK)</option>
			</select>
		</div>	
		<div class="input-group col-xs-12">
			<span class="input-group-addon" id="basic-addon3">Address:</span>
			<input type="text" name="address" class="form-control">
		</div>	
		<div class="input-group col-xs-5">
			<span class="input-group-addon" id="basic-addon3">Tel:</span>
			<input type="text" name="tel" class="form-control">
		</div>	
		<div class="input-group col-xs-5">
			<span class="input-group-addon" id="basic-addon3">Fax:</span>
			<input type="text" name="fax" class="form-control">
		</div>	
		<div class="input-group col-xs-2  col-xs-offset-10">
			<input type="submit" name="submit" class="form-control btn btn-primary" value="Add new vendor" />
		</div>	
	</form>

<div class="modal fade" id="AjaxResultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="AjaxResultModalLabel"><span class="resultIcon glyphicon"></span> Result</h4>
			</div>
			<div class="modal-body">
				/* Body content to be created by program */
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button id="refresh-btn" type="button" class="btn btn-primary" data-dismiss="modal">Refresh</button>
			</div>
		</div>
	</div>
</div>