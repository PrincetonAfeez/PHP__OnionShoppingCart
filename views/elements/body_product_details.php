<?php
importClass('model/product');
?>
<?php 
$category = new Category($db);
$model['page'] = new Page();
$requestInstant = $model['page']->getInstance();
$rootCategoryList = $category->getRootCategoryList();
$categoryList = $category->getCategoryList($requestInstant);

/* Create product instant */
$product = new Product($db);
$product->setInstance('slug', $requestInstant);
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
		<div id="product-details" class="product-details">
			<div class="header row">
				<div class="page-header col-xs-12">
					<h1><small><?php echo $product->getName(); ?></small></h1>
				</div>
			</div>
			<div class="overview row">
				<div class="feature-image col-xs-12 col-md-5">
					<img src="<?php
					$featureImage = $product->getFeatureImage();
					$resizedImage = preg_replace('/.(jpeg|jpg|gif|png)$/i', '-500x500.$1', $featureImage);
					if (file_exists($_SERVER['DOCUMENT_ROOT'].$resizedImage)) {
						echo $resizedImage;
					} else {
						echo $featureImage;
					}
					?>" <?php 
					$lowSrcImage = preg_replace('/.(jpeg|jpg|gif|png)$/i', '-150x150.$1', $featureImage);
					if (file_exists($_SERVER['DOCUMENT_ROOT'].$lowSrcImage)) {
						echo 'lowsrc="'.$lowSrcImage.'"';
					}
					?> />
				</div>
				<div class="specification col-xs-12 col-md-7 well">
					<form method="post" action="<?php echo document_root(); ?>/add_to_cart">
						<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> 限量版</div>
						<div class="rating row">
							<span class="label col-xs-1">評分:</span>
							<span class="value col-xs-11">
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star-empty"></span>
								<span class="glyphicon glyphicon-star-empty"></span>
							</span>
						</div>
						<div class="price row">
							<span class="label col-xs-1">售價:</span>
							<span class="value col-xs-11"><span class="glyphicon glyphicon-usd"></span><?php echo $product->getPrice(); ?></span>
						</div>
						<div class="cart-control option row">
							<div class="label col-xs-1">選項:</div>
							<div class="value col-xs-11">
								<div class="choice-label">容量：</div>
								<div class="choice">
									<button class="button control-btn checked">50ml</button>
									<button class="button control-btn">75ml</button>
									<button class="button control-btn">90ml</button>
								</div>
							</div>
						</div>
						<div class="sku row">
							<span class="label col-xs-12">每一購買單位為: <?= $product->getUnit(); ?></span>
						</div>
						<div class="cart-control quantity row">
							<span class="label col-xs-1 col-sm-1">數量:</span>
							<span class="value col-xs-11 col-sm-5">
								<button class="glyphicon glyphicon-minus-sign control-btn"></button>
								<span><input type="text" name="qty" size="3" value="1" /></span>
								<button class="glyphicon glyphicon-plus-sign control-btn"></button>
							</span>
							<span class="action-button col-xs-12 col-sm-6">
								<button type="button" class="btn btn-default add-to-cart-btn">
									<span class="glyphicon glyphicon-plus"></span> 加進購物車</button>
							</span>
						</div>
					</form>
				</div>
			</div>
			<div id="information-tabs" class="information row">
				<ul class="nav nav-tabs">
				  <li role="presentation" class="active"><a href="#information-tabs" for="description">產品描述</a></li>
				  <li role="presentation"><a href="#information-tabs" for="information">其他資料</a></li>
				</ul>
				<ul class="tab-content">
					<li id="description" class="active"><?php echo html_entity_decode($product->getDescription()); ?></li>
					<li id="information">
						<table>
							<tr>
								<td>品牌/製造商</td><td>：</td><td><?php echo $product->getBrandName(); ?></td>
							</tr>
						</table>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
		