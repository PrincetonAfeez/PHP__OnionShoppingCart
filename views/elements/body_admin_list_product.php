<?php
/* import required classes */
importClass('model/productmanager');
importClass('model/brandmanager');
?>
<?php 
/* Create product manager instant */
$model['productManager'] = new ProductManager($db);
$model['brandManager'] = new BrandManager($db);

$dataColumn = ['product_id','name','brand_id','status'];
?>
<table>
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
		<td>批量撰擇</td>
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
	foreach($model['productManager']->getProductList() as $row){
		$model['productManager']->setInstance('product_id', $row['product_id']);
		echo ' <tr';
		if ($rowCounter++ % 2 == 0){
			echo ' class="bulk-control table-row-odd"';
		} else {
			echo ' class="bulk-control table-row-even"';
		}
		echo '>'."\n";
		echo '<td><input type="checkbox" class="form-control" value="'.$row['product_id'].'" /></td>';
		foreach($dataColumn as $col){
			if ($col == 'brand_id'){
				echo '		<td>'.$model['productManager']->getBrandName().'</td>'."\n";
			} else {
				echo '		<td>'.$row[$col].'</td>'."\n";
			}
		}
		echo '		<td>
			<button type="submit" name="product_id" value="'.$row['product_id'].'" class="btn btn-default glyphicon glyphicon-pencil"></button>
		</td>'."\n";
		echo ' </tr>'."\n";
	}
	?>
	</form>
</table>
<form id="bulkEditForm" method="post" action="<?= document_root() ?>/api/bulkedit-productbrand">
	<div class="well">
		<div class="well-heading">批量更改動作</div>
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
					echo '<option value="'.$brandId.'">'.$thisBrand->getName().'</option>';
				}
				echo '</optgroup>';
				?>
			</select>
			<span id="btn_bulkedit_brand" class="input-group-addon glyphicon glyphicon-floppy-disk"></span>
		</div>
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