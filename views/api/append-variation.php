<?php
importClass('model/dbconnection');
importClass('model/category');
importClass('model/productmanager');
$db = new Dbconnection();
$model['category'] = new Category($db);
$model['productManager'] = new ProductManager($db);

$model['productManager']->setInstance('product_id', $_POST['product_id']);

/* Append the variation table */
$nextRef = $model['productManager']->getVariationRefMax() + 1;
$variation_groupname = $_POST["variation_group"];
$variation_options = split(",", $_POST['variation_options']);

$queryResult = TRUE;
try{
	foreach($variation_options as $optionElement) {
		$sql = "INSERT INTO variation (`variation_ref`, `name`, `option`) ";
		$sql .= "VALUES (".$nextRef.", '";
		$sql .= mysql_escape_string(htmlspecialchars(htmlentities(trim($_POST['variation_group']))))."', '";
		$sql .= mysql_escape_string(htmlspecialchars(htmlentities(trim($optionElement))))."')";
		$queryResult = $queryResult && $db->insert($sql);
	}
	$result = array(
					"result"=>$queryResult
				);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}

?>