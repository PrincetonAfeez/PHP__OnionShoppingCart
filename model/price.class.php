<?php

class Price {
	
	protected $db;
	protected $supplier;
	protected $price;

	function __construct($dbconnection){
		$this->db = $dbconnection;
	}

	public function getProductId(){
		return $this->supplier['product_id'];
	}
	
	public function getSupplyId(){
		return $this->supplier['supply_id'];
	}
	
	public function getVendorId(){
		return $this->supplier['vendor_id'];
	}	
	
	public function getPriceId(){
		return $this->price['price_id'];
	}	
	

	public function getCost(){
		return $this->supplier['cost'];
	}

	public function getCurrency(){
		return $this->supplier['currency'];
	}

	public function getQuotationDate(){
		if (strlen($this->supplier['quotation_date']) > 0){
			return date("Y-m-d",strtotime($this->supplier['quotation_date']));
		} else {
			return '';
		}
	}

	public function getMarkup(){
		return $this->price['markup'];
	}

	public function getMarkupType(){
		return $this->price['markup_type'];
	}

	public function getEffecttiveDate(){
		if (strlen($this->price['effective_date']) > 0){
			return date("Y-m-d",strtotime($this->price['effective_date']));
		} else {
			return '';
		}
	}

	public function getEnDate(){
		if (strlen($this->price['end_date']) > 0){
			return date("Y-m-d",strtotime($this->price['end_date']));
		} else {
			return '';
		}
	}

	public function getNotes(){
		return $this->price['notes'];
	}
	
	public function getSupplierByProductId($product_id){
		$sql = "SELECT supply_id
				FROM supply
				WHERE product_id=".$product_id;
		return $this->db->fetchall($sql);
	}
	
	public function getSupplierBySupplyId($supply_id){
		$list = array();
		$sql = "SELECT s.supply_id, s.product_id, s.vendor_id, p.price_id, s.variation_ref
				FROM supply AS s INNER JOIN price AS p
				WHERE s.supply_id=p.supply_id
				AND s.supply_id=".$supply_id."
				UNION		
				SELECT supply_id, product_id, vendor_id, '', variation_ref
				FROM supply
				WHERE supply_id NOT IN (SELECT supply_id FROM price)
				AND supply_id=".$supply_id;
		return $this->db->fetchall($sql);
	}
	
	public function getPricesByProductId($product_id){
		$sql = "SELECT s.supply_id, s.product_id, s.vendor_id, p.price_id, s.variation_ref
				FROM supply AS s INNER JOIN price AS p
				WHERE s.product_id=".$product_id."
				AND s.supply_id=p.supply_id";
		return $this->db->fetchall($sql);
	}
	
	public function setPriceByPriceId($price_id){
		$sql = "SELECT s.supply_id, s.product_id, s.vendor_id, s.cost, s.currency, s.date AS quotation_date, s.variation_ref,
				p.price_id, p.markup, p.markup_type, p.date AS effective_date, p.end_date, p.notes
				FROM supply AS s INNER JOIN price AS p
				WHERE p.price_id=".$price_id."
				AND s.supply_id=p.supply_id";
		$result = $this->db->fetchone($sql);

		/* This matching should be the same as the database table structure */
		$this->supplier['supply_id'] = $result['supply_id'];
		$this->supplier['product_id'] = $result['product_id'];
		$this->supplier['vendor_id'] = $result['vendor_id'];
		$this->supplier['cost'] = $result['cost'];
		$this->supplier['currency'] = $result['currency'];
		$this->supplier['quotation_date'] = $result['quotation_date'];
		$this->supplier['variation_ref'] = $result['variation_ref'];
		$this->price['price_id'] = $result['price_id'];
		$this->price['markup'] = $result['markup'];
		$this->price['markup_type'] = $result['markup_type'];
		$this->price['effective_date'] = $result['effective_date'];
		$this->price['end_date'] = $result['end_date'];
		$this->price['notes'] = $result['notes'];
	}
	
	public function setPriceBySupplyId($supply_id){
		$sql = "SELECT supply_id, product_id, vendor_id, cost, currency, date AS quotation_date, variation_ref
				FROM supply
				WHERE supply_id=".$supply_id;
		$result = $this->db->fetchone($sql);
	
		/* This matching should be the same as the database table structure */
		$this->supplier['supply_id'] = $result['supply_id'];
		$this->supplier['product_id'] = $result['product_id'];
		$this->supplier['vendor_id'] = $result['vendor_id'];
		$this->supplier['cost'] = $result['cost'];
		$this->supplier['currency'] = $result['currency'];
		$this->supplier['quotation_date'] = $result['quotation_date'];
		$this->supplier['variation_ref'] = $result['variation_ref'];
		$this->price['price_id'] = '';
		$this->price['markup'] = '';
		$this->price['markup_type'] = '';
		$this->price['effective_date'] = '';
		$this->price['end_date'] = '';
		$this->price['notes'] = '';
	}
		
}

?>