<?php
importClass('model/product');
?>
<?php 
$category = new Category($db);
$model['page'] = new Page();
$requestInstant = $model['page']->getInstance();
$rootCategoryList = $category->getRootCategoryList();
$categoryList = $category->getCategoryList($requestInstant);
$itemCounter = 0;
?>
<div id="sub-category-list" class="row">
	<div class="content-left-panel col-xs-12 col-sm-2">
		<div class="category-widget">
			<ul class="widget-menu">
<?php
/* This block loop all the root categories to the category widget */
foreach ($rootCategoryList as $row){
	$category->setCategoryRecord($row);
	echo '
				<li><a href="'.document_root().'/category/'.$category->getCategorySlug().'"';
	if (($requestInstant == $category->getCategorySlug()) or in_array($category->getCategorySlug(), $model['page']->getSubType())){
		echo ' class="active"';
	}
	echo '>'.$row["name"].'</a>';
	if (in_array($category->getCategorySlug(), $model['page']->getSubType())){
		$subtypelist = $model['page']->getSubType();
		$path = document_root().'/category/'.array_shift($subtypelist);
		foreach ($subtypelist as $subtype){
			$path = implode('/', [$path,$subtype]);
			echo '<a href="'.$path.'" class="active">'.
				'<span class="glyphicon glyphicon-menu-right"></span> '.
				$subtype.
				'</a>';
		}
		$path = implode('/', [$path,$requestInstant]);
		echo '<a href="'.$path.'" class="active">'.
			'<span class="glyphicon glyphicon-menu-right"></span> '.
			$category->getCategoryNameBySlug($requestInstant).
			'</a>';
	}
	echo '
				</li>
		';
}
?>
			</ul>
		</div>
	</div>
	<div class="content-right-panel col-xs-12 col-sm-10">
<?php
/* This block loop all the sub-categories as gallery */
foreach ($categoryList as $row){
	$category->setCategoryRecord($row);
	echo ' 
			<div class="display-box col-xs-6 col-sm-6 col-md-4">
				<a href="'.document_root().'/category/'.
				implode('/', $model['page']->getSubType()).
				$model['page']->getInstance().
				'/'.
				$category->getCategorySlug().
				'">
					<div class="content">
    	';
	
	$catIcon = $category->getCategoryIcon();
	if ($catIcon != NULL){
		echo '<img src="'.document_root().$catIcon.'" /><br />';
		
	} else {
		echo '<img src="'.document_root().'/asset/images/dummy_1200x444.jpg" /><br />';
	}
	echo '				'.$category->getCategoryName().'
    				</div>
    			</a>
			</div>
		';
	$itemCounter++;
}
?>
		<!-- Product List -->
<?php
$product_list = $category->getProductList($category->getCategoryIdBySlug($requestInstant),'DESC');
foreach ($product_list as $item_id){
	$item = new Product($db);
	$item->setInstance('product_id',$item_id);
	$itemDetails = $item->getProductDetails();
	echo '
			<div class="product-box display-box col-xs-6 col-sm-6 col-md-4">
				<a href="'.document_root().'/product/'.
					$item->getBrandSlug().'/'.
					$itemDetails['slug'].
					'">
					<div class="content">
    	';
	
	$featureImage = $item->getFeatureImage();
	if ($featureImage != NULL){
		echo '<img src="';
			$resizedImage = preg_replace('/.(jpeg|jpg|gif|png)$/i', '-150x150.$1', $featureImage);
		if (file_exists($_SERVER['DOCUMENT_ROOT'].$resizedImage)) {
			echo $resizedImage;
		} else {
			echo $featureImage;
		}
		echo '"';
		
		echo ' /><br />';
	
	} else {
		echo '<img src="'.document_root().'/asset/images/dummy_1200x444.jpg" /><br />';
	}
	echo '				'.$itemDetails['name'].'<br>
						$'.$item->getPrice().'
    				</div>
					<div class="form-control btn btn-default"><span class="glyphicon glyphicon-search"></span> 查詢產品</div>
    			</a>
			</div>
		';
	$itemCounter++;
}
if ($itemCounter == 0){
	echo '
			<div class="col-xs-12">
				<div class="content alert alert-warning"">Sorry, there is no product to show in this category.</div>
			</div>
';
}
?>
		<!-- Product List End -->
	<script src="/asset/scripts/product-box-equal-height.js"></script>
	</div>
</div>
		