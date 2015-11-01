<?php
importClass('model/dbconnection');
importClass('model/vendor');
importClass('model/price');

function validateInput() {
	if ((isset($_POST['product_id'])) and (strlen($_POST['product_id']) > 0)) {
		return true;
	} else {
		return false;
	}
}

if (validateInput()) {
	$db = new Dbconnection();
	$modelVendor = new Vendor($db);
	$modelPrice = new Price($db);
	$supplierlist = $modelPrice->getSupplierByProductId($_POST['product_id']);
	$pricelist = array();
	foreach ($supplierlist as $supplier) {
		$pricelist = array_merge($pricelist, $modelPrice->getSupplierBySupplyId($supplier['supply_id']));
	}
	$table = array();
	foreach ($pricelist as $row){
		$record = array();
		if (strlen($row['price_id']) > 0) {
			$modelPrice->setPriceByPriceId($row['price_id']);
		} else {
			$modelPrice->setPriceBySupplyId($row['supply_id']);
		}
		$modelVendor->setInstance('vendor_id', $row['vendor_id']);
		if ($row['variation_ref']!=NULL){
			$record['Variation'] = array(
							"Size" => "12cm",
							"Color" => "Orange"
						);
		}
		$record["Quotation"] = array(
			"Supply ID" => $modelPrice->getSupplyId(),
			"Vendor ID" => $modelVendor->getVendorId(),
			"Name" => $modelVendor->getName(),
			"Date" => $modelPrice->getQuotationDate(),
			"Currency" => $modelPrice->getCurrency(),
			"Cost" => $modelPrice->getCost()
			);
		$record["Logistics"] = array(
			"Cost" => '15'
			);
		$record["Price Marking"] = array(
			"Price ID" => $modelPrice->getPriceId(),
			"Markup" => ($modelPrice->getMarkupType()=='P'?$modelPrice->getMarkup().'%':'$'.$modelPrice->getMarkup()),
			"Start Date" =>$modelPrice->getEffecttiveDate(),
			"End Date" => $modelPrice->getEnDate()
		);
		array_push($table, $record);
	}
	echo json_encode($table);
} else {
	echo json_encode(array('result'=>false,'message'=>'Validation fails.'));
}
?>