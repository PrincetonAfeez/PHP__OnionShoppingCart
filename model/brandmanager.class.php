<?php
importClass('model/brand');

class BrandManager extends Brand {
	
	protected $db;
	protected $brandList;

	function __construct($dbconnection){
		$this->db = $dbconnection;
		$this->loadBrandList();
	}
	
	public function getBrandListId(){
		$brandListId = array();
		foreach ($this->brandList as $item){
			array_push($brandListId, $item['brand_id']);
		}
		return $brandListId;
	}
	
	public function sortBrandList($order='brand_id'){
		$this->loadBrandList($order);
	}

	private function loadBrandList($order='brand_id'){
		$sql = "SELECT *
				FROM brand
				ORDER BY ".$order;
		$this->brandList = $this->db->fetchall($sql);
	}
	
}

?>