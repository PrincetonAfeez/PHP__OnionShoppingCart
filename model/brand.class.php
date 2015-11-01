<?php

class Brand {
	
	protected $db;
	protected $instance;

	function __construct($dbconnection){
		$this->db = $dbconnection;
	}
	
	
	public function getName(){
		return $this->instance['name'];
	}
	
	public function setInstance($key, $value){
		$sql = "SELECT *
				FROM brand
				WHERE ".$key."='".$value."'";
		$result = $this->db->fetchone($sql);

		/* This matching should be the same as the database table structure */
		$this->instance['brand_id'] = $result['brand_id'];
		$this->instance['name'] = $result['name'];
	}
		
}

?>