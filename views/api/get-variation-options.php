<?php
importClass('model/dbconnection');
importClass('model/productmanager');

$db = new Dbconnection();
$modelProductManager = new ProductManager($db);
$variationOptions = $modelProductManager->getVariationOptions(mysql_escape_string(htmlspecialchars(htmlentities(trim($_POST['variation_ref'])))));
$optionList = [];
foreach($variationOptions as $optionItem){
	array_push($optionList, $optionItem['option']);
}
echo json_encode( array(
		"result" => true,
		"options" => implode(', ', $optionList)
		));

?>