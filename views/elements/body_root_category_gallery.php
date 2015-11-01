<?php 
if (!isset($content)){
	$category = new Category($db);
	$rootCategoryList = $category->getRootCategoryList($db);
}
?>
		<div id="category-list" class="row">
<?php
/* This block loop all the root categories as gallery */
foreach ($rootCategoryList as $row){
	$category->setCategoryRecord($row);
	echo ' 
			<div class="display-box col-xs-6 col-sm-6 col-md-3">
				<a href="'.document_root().'/category/'.$category->getCategorySlug().'">
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
}
?>
		</div>
		