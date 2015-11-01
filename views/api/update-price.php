<?php
importClass('model/dbconnection');
$db = new Dbconnection();
$sqlReturn = true;
$sql['supply'] = "
	UPDATE supply SET
	product_id=".htmlspecialchars(htmlentities($_POST['product_id'])).",
	vendor_id=".htmlspecialchars(htmlentities($_POST['vendor_id'])).",
	currency='".htmlspecialchars(htmlentities($_POST['currency']))."',
	cost=".htmlspecialchars(htmlentities($_POST['cost'])).",
	date='".htmlspecialchars(htmlentities($_POST['quotation_date']))."'
	WHERE supply_id=".htmlspecialchars(htmlentities($_POST['supply_id']));

if (strlen($_POST['price_id']) > 0) {
	$sql['price'] = "
		UPDATE price SET
		supply_id=".htmlspecialchars(htmlentities($_POST['supply_id'])).",
		markup=";
	$sql['price'] .= (strlen($_POST['markup']) > 0)?htmlspecialchars(htmlentities($_POST['markup'])):"''";
	$sql['price'] .= ",markup_type='".htmlspecialchars(htmlentities($_POST['markup_type']))."',date='";
	$sql['price'] .= (strlen($_POST['effective_date']) > 0 )?htmlspecialchars(htmlentities($_POST['effective_date'])):date_format(date_create(), 'Y-m-d H:i:s');
	$sql['price'] .= "',end_date=";
	$sql['price'] .= (strlen($_POST['end_date']) > 0 )?"'".htmlspecialchars(htmlentities($_POST['end_date']))."'":'NULL';
	$sql['price'] .= " WHERE price_id=".htmlspecialchars(htmlentities($_POST['price_id']));
} elseif ((strlen($_POST['markup']) > 0) and (strlen($_POST['markup_type']) > 0)) {
	$sql['price'] = "
		INSERT INTO price (supply_id, markup, markup_type, date, end_date) VALUES (
		".htmlspecialchars(htmlentities($_POST['supply_id'])).",";
	$sql['price'] .= (strlen($_POST['markup']) > 0)?htmlspecialchars(htmlentities($_POST['markup'])):"''";
	$sql['price'] .= ", '".htmlspecialchars(htmlentities($_POST['markup_type']))."','";
	$sql['price'] .= (strlen($_POST['effective_date']) > 0 )?htmlspecialchars(htmlentities($_POST['effective_date'])):date_format(date_create(), 'Y-m-d H:i:s');
	$sql['price'] .= "',";
	$sql['price'] .= (strlen($_POST['end_date']) > 0 )?"'".htmlspecialchars(htmlentities($_POST['end_date']))."'":'NULL';
	$sql['price'] .= ")";
}
try{
	$sqlReturn = $db->update($sql['supply']);
	if (strlen($_POST['price_id']) > 0) {
		$sqlReturn = $sqlReturn and $db->update($sql['price']);
	} elseif ((strlen($_POST['markup']) > 0) and (strlen($_POST['markup_type']) > 0)){
		$sqlReturn = $sqlReturn and $db->insert($sql['price']);
	}
	$result = array(
					"result"=>$sqlReturn,
					"sql"=>$sql['price']
				);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
?>