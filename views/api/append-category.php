<?php
importClass('model/dbconnection');
importClass('model/category');
importClass('model/productmanager');
$db = new Dbconnection();
$model['category'] = new Category($db);
$model['productManager'] = new ProductManager($db);

function loadSubCat($model, $slug, $recursiveIndex=1){
	$newSelectedOptionList = "";
	foreach ($model['category']->getCategoryList($slug) as $subCat) {
		$newSelectedOptionList .= '<option value=\''.$subCat['cat_id'].'\'';
		if ($subCat['cat_id'] == $model['productManager']->getCategory()) {
			$newSelectedOptionList .= ' selected';
		}
		$newSelectedOptionList .= '>'.str_repeat("-- ", $recursiveIndex).$subCat['name'].'</option>';
		$newSelectedOptionList .= loadSubCat($model,$subCat['slug'], $recursiveIndex+1);
	}
	return $newSelectedOptionList;
}

$model['productManager']->setInstance('product_id', $_POST['product_id']);

/* Append the category table */
$sql = "INSERT INTO categories (name, parent_cat, priority, slug) ";
$sql .= "VALUES ('".mysql_escape_string(htmlspecialchars(htmlentities($_POST['name'])))."', ";
if (strlen($_POST['cat_id']) > 0){
	$sql .= htmlentities($_POST['cat_id']).", ";
} else {
	$sql .= "NULL, ";
}
$sql .= "0, ";
if (strlen($_POST['slug']) > 0) {
	$sql .= "'".htmlspecialchars(htmlentities($_POST['slug']))."')";
} else {
	$sql .= "NULL)";
}

try{	
	$newSelectedOptionList = "";
		
	foreach ($model['category']->getRootCategoryList() as $rootCat) {
		$newSelectedOptionList .= '<option value=\''.$rootCat['cat_id'].'\'';
		if ($rootCat['cat_id'] == $model['productManager']->getCategory()) {
			$newSelectedOptionList .= ' selected';
		}
		$newSelectedOptionList .= '>'.$rootCat['name'].'</option>';
		$newSelectedOptionList .= loadSubCat($model,$rootCat['slug']);
	}
	$result = array(
					"result"=>$db->update($sql),
					"newSelectOptionList"=>$newSelectedOptionList
				);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
?>