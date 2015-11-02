<?php
importClass('model/dbconnection');
importClass('model/category');
importClass('model/productmanager');
$db = new Dbconnection();
$model['category'] = new Category($db);
$model['productManager'] = new ProductManager($db);

$model['productManager']->setInstance('product_id', $_POST['product_id']);

/* Append the category table */
$sql = "INSERT INTO supply (product_id, vendor_id, cost, currency, date) ";
$sql .= "VALUES (".
		htmlentities($_POST['product_id']).", ".
		htmlentities($_POST['vendor_id']).", ".
		htmlentities($_POST['cost']).", '".
		htmlentities($_POST['currency'])."', '".
		date_format(date_create(), 'Y-m-d H:i:s')."') ";

try{
	//throw new Exception($sql);
	$result = array(
					"result"=>$db->insert($sql)
				);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
?>