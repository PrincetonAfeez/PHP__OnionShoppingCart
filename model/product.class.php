<?php

class Product {
	
	protected $db;
	protected $instance;

	function __construct($dbconnection){
		$this->db = $dbconnection;
	}
	
	
	public function getProductDetails(){
		return $this->instance;
	}
	
	public function getBrandName(){
		if (strlen($this->instance['brand_id']) > 0) {
			$sql = "SELECT name
					FROM brand
					WHERE brand_id=".$this->instance['brand_id'];
			$result = $this->db->fetchone($sql);
			if (sizeof($result) > 0){ 
				return $result['name'];
			}
		}
		return '';
	}
	
	public function getBrandSlug(){
		$sql = "SELECT slug
				FROM brand
				WHERE brand_id=".$this->instance['brand_id'];
		$result = $this->db->fetchone($sql);
		if ((sizeof($result)>0) and ($result['slug'] != NULL)){
			return $result['slug'];
		} else {
			$sql = "SELECT name
				FROM brand
				WHERE brand_id=".$this->instance['brand_id'];
			$result = $this->db->fetchone($sql);
			$result = strtolower($result['name']);
			$result = preg_replace('/( )+/','-',$result);
			$result = preg_replace("/&[#a-zA-Z0-9]*;/",'',$result);
			return $result;
		}
	}
	
	public function getProductId(){
		return $this->instance['product_id'];
	}
	
	public function getName(){
		return $this->instance['name'];
	}
	
	public function getBrandId(){
		return $this->instance['brand_id'];
	}

	public function getDescription(){
		$formattedText = preg_replace("/[\r\n]{1,2}/", "<br />\n", $this->instance['description']);
		return $formattedText;
	}
	
	public function getUnit(){
		return $this->instance['unit'];
	}
	
	public function getWeight(){
		return $this->instance['weight'];
	}
	
	public function getSlug(){
		return $this->instance['slug'];
	}
	
	public function getStatus(){
		return $this->instance['status'];
	}
	
	public function getPrice(){
		$sql = "SELECT s.*, p.notes, p.markup, p.markup_type
				FROM price as p INNER JOIN supply as s
				WHERE p.supply_id in (
				SELECT supply_id
				FROM supply
				WHERE product_id=".$this->instance['product_id'].")
				AND (
				p.end_date is NULL OR
				p.end_date>CURDATE()
				)
				AND p.supply_id=s.supply_id
				ORDER BY p.date";
		$result = $this->db->fetchone($sql);

		return $this->calculatePriceByMarkup($result['cost'],$result['markup'],$result['markup_type']);
	}
	
	public function getFeatureImage(){
		$sql = "SELECT uri
				FROM attachment
				WHERE post_type='product' and post_id='".$this->instance['product_id']."'";
		$result = $this->db->fetchall($sql);
		if (sizeof($result) > 0){
			$result = end($result);
			return $result['uri'];
		}
	}
	
	public function getCategory(){
		$sql = "SELECT relation
				FROM cat_tag_relationship
				WHERE relation_type='category'
				AND product_id=".$this->instance['product_id'];
		$result = $this->db->fetchone($sql);
		return $result['relation'];
	}
	
	public function getVendorList(){
		$searchCondition = " WHERE product_id =".$this->instance['product_id'];
		$sql = "SELECT vendor_id
				FROM supply".
					$searchCondition.
					" ORDER BY vendor_id";
		return $this->db->fetchall($sql);
	}
	
	public function getVendorCost($vendorId){
		$searchCondition = " WHERE product_id=".$this->instance['product_id'].
							" AND vendor_id=".$vendorId;
		$sql = "SELECT cost
				FROM supply".
				$searchCondition.
				" ORDER BY date DESC";
		$result = $this->db->fetchone($sql);
		return $result['cost'];
	}
	
	public function getPriceTableOfInstance(){
		$searchCondition = " WHERE product_id =".$this->instance['product_id'];
		$sql = "SELECT *
				FROM price
				WHERE supply_id in (
					SELECT supply_id
					FROM supply".
					$searchCondition.
				") ORDER BY date DESC";
		return $this->db->fetchall($sql);
	}
	
	public function getSupplyTableOfInstance(){
		return $this->instance['supply'];
	}
	
	public function getPriceDetailList(){
		$searchCondition = " WHERE product_id =".$this->instance['product_id'];
		$sql = "SELECT *
				FROM supply".
				$searchCondition.
				" ORDER BY supply_id";
		return $this->db->fetchall($sql);
	}
	
	public function getPriceDetails($supplyId){
		$searchCondition = " WHERE supply_id=".$supplyId;
		$sql = "SELECT *
				FROM supply".
				$searchCondition.
				" ORDER BY date DESC";
		$result = $this->db->fetchall($sql);
		return $result;
	}
	
	public function getSupplierName($supplyId){
		$searchCondition = " WHERE supply_id=".$supplyId;
		$sql = "SELECT name
				FROM vendor
				WHERE vendor_id in (
					SELECT vendor_id
					FROM supply".
					$searchCondition.
				")";
		$result = $this->db->fetchone($sql);
		return $result['name'];
	}
	
	public function setInstance($key, $value){
		$sql = "SELECT *
				FROM product
				WHERE ".$key."='".$value."'";
		$result = $this->db->fetchone($sql);

		/* This matching should be the same as the database table structure */
		$this->instance['product_id'] = $result['product_id'];
		$this->instance['name'] = $result['name'];
		$this->instance['brand_id'] = $result['brand_id'];
		$this->instance['description'] = $result['description'];
		$this->instance['unit'] = $result['unit'];
		$this->instance['weight'] = $result['weight'];
		$this->instance['slug'] = $result['slug'];
		$this->instance['status'] = $result['status'];
	}
	
	public function setCost($supply_id){
		$sql = "SELECT *
				FROM supply
				WHERE supply_id=".$supply_id;
		$result = $this->db->fetchone($sql);
		$this->instance['supply'] = $result;
	}
	
	public function calculatePriceByMarkup($cost,$markup,$markupType){ 
		/* markup the price by actual amount or by percentage */
		if ($markupType=='P'){
			$sellingPrice = $cost*(100+$markup)/100;
		} else {
			$sellingPrice = $cost+$markup;
		}
		$sellingPrice += $this->calculateLogisticCost();
		
		$exchangeRate = 6.0;
		$sellingPrice *= $exchangeRate;
		return round($sellingPrice,2);
	}
	

	public function calculateLogisticCost(){	
		/* add the weight cost for delivery */
		$costPerDelivery = 15; /* in AUD */
		$weightMarkupPercentage = 30;
		return $this->instance['weight']*(100+$weightMarkupPercentage)/100*$costPerDelivery;
	}
	
	private function validateRecord(){
		if (!isset($this->record)){
			throw new Exception('Empty record in category.');
		}
	}
	
}

?>