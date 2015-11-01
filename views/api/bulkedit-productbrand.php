<?php
importClass('model/dbconnection');
$db = new Dbconnection();

$productList = split(',', $_POST['bulk_id']);

try{
	$sqlReturn = true;
	foreach($productList as $product_id) {
		$sql = "UPDATE product SET".
				" brand_id=".htmlentities($_POST['brand_id']).
				" WHERE product_id=".htmlentities($product_id);
		$sqlReturn = $sqlReturn and $db->update($sql);
	}
	$result = array(
					"result"=>$sqlReturn
				);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
?>