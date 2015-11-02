<?php
importClass('model/dbconnection');
importClass('model/productmanager');

$db = new Dbconnection();
$modelProductManager = new ProductManager($db);
$variationList = $modelProductManager->getVariationList();
echo json_encode( array(
		"result" => true,
		"variation_list" => $variationList
		));

?>