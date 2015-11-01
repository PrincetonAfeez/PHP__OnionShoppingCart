<?php

class Vendor {
	
	protected $db;
	protected $instance;

	function __construct($dbconnection){
		$this->db = $dbconnection;
	}
	
	public function getVendorId(){
		return $this->instance['vendor_id'];
	}
	
	public function getName(){
		return $this->instance['name'];
	}
	
	public function getCountryCode(){
		return $this->instance['country_code'];
	}

	public function getAddress(){
		return $this->instance['address'];
	}

	public function getTel(){
		return $this->instance['tel'];
	}

	public function getFax(){
		return $this->instance['fax'];
	}
	
	public function setInstance($key, $value){
		$sql = "SELECT *
				FROM vendor
				WHERE ".$key."='".$value."'";
		$result = $this->db->fetchone($sql);

		/* This matching should be the same as the database table structure */
		$this->instance['vendor_id'] = $result['vendor_id'];
		$this->instance['name'] = $result['name'];
		$this->instance['country_code'] = $result['country_code'];
		$this->instance['address'] = $result['address'];
		$this->instance['tel'] = $result['tel'];
		$this->instance['fax'] = $result['fax'];
	}
		
}

?>