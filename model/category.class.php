<?php

class Category {
	
	protected $db;
	protected $record;

	function __construct($dbconnection){
		$this->db = $dbconnection;
	}
	
	public function getRootCategoryList(){
		$sql = "SELECT *
				FROM categories
				WHERE parent_cat is NULL
				ORDER BY name";
		return $this->db->fetchall($sql);
	}
	
	public function getCategoryList($instantName){
		$sql = "SELECT cat_id
				FROM categories
				WHERE slug = '".$instantName."'";
		$result = $this->db->fetchone($sql);
		
		$sql = "SELECT *
				FROM categories
				WHERE parent_cat = '".$result['cat_id']."'";
		return $this->db->fetchall($sql);
	}
	
	public function getCategoryIcon(){
		$this->validateRecord();
		$sql = "SELECT uri
				FROM attachment
				WHERE post_type='categories' and post_id='".$this->getCategoryId()."'";
		$result = $this->db->fetchall($sql);
		if (sizeof($result) > 0){
			$result = end($result);
			return $result['uri'];
		}
	}
	
	public function getCategoryId(){
		$this->validateRecord();
		return $this->record['cat_id'];
	}
	
	public function getCategoryIdBySlug($slug){
		$sql = "SELECT cat_id
				FROM categories
				WHERE slug='".$slug."'";
		$result = $this->db->fetchall($sql);
		if (sizeof($result) > 0){
			$result = end($result);
			return $result['cat_id'];
		}
	}
	
	public function getCategoryName(){
		$this->validateRecord();
		return $this->record['name'];
	}
	
	public function getCategoryNameBySlug($slug){
		$sql = "SELECT name
				FROM categories
				WHERE slug='".$slug."'";
		$result = $this->db->fetchall($sql);
		if (sizeof($result) > 0){
			$result = end($result);
			return $result['name'];
		}
	}
	
	public function getCategorySlug(){
		$this->validateRecord();
		return $this->record['slug'];
	}
	
	public function getProductList($cat_id, $order='ASC'){
		$sql = "SELECT product_id
				FROM product
				WHERE product_id in (SELECT product_id
				FROM cat_tag_relationship
				WHERE relation_type='category'
				AND relation=".$cat_id.")
				AND status='on'
				ORDER BY product_id ".$order;
		$result = $this->db->fetchall($sql);
		$product_list = [];
		foreach ($result as $item){
			array_push($product_list, $item['product_id']);
		}
		return $product_list;
	}
	
	public function setCategoryRecord($record){
		$this->record = $record;
	}
	
	private function validateRecord(){
		if (!isset($this->record)){
			throw new Exception('Empty record in category.');
		}
	}
	
}

?>