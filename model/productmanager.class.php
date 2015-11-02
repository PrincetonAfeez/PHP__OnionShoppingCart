<?php
importClass('model/product');

class ProductManager extends Product {
	
	protected $db;
	protected $productList;
	
	
	function __construct($dbconnection){
		$this->db = $dbconnection;
		$this->loadProductList();
	}
	
	
	public function getProductList(){
		return $this->productList;
	}

	public function getVariationRefMax(){
		$sql = "SELECT MAX(variation_ref) FROM variation";
		$result = $this->db->fetchone($sql);
		if ($result[0] == NULL) {
			return 0;
		} else {
			return $result[0];
		}
	}
	
	public function getVariationList(){
		$sql = "SELECT variation_ref, name FROM variation GROUP BY variation_ref ORDER BY name";
		return $this->db->fetchall($sql);
	}
	
	public function getVariationOptions($refId){
		$sql = "SELECT `option` FROM variation WHERE variation_ref=".$refId;
		return $this->db->fetchall($sql);
	}
	
	private function loadProductList($order='ASC'){
		/* action: sorting */
		if (isset($_POST['sort'])){
			$orderBy = $_POST['sort'];
		} else {
			$orderBy = 'product_id';
		}
		
		/* action filtering */
		$searchCondition = '';
		if (isset($_POST['searchkey'])){
			$searchCondition = " WHERE name LIKE '%".$_POST['searchkey']."%'".
								" OR product_id LIKE '%".$_POST['searchkey']."%'".
								" OR description LIKE '%".$_POST['searchkey']."%'";
		}
		
		$sql = "SELECT *
				FROM product".
				$searchCondition.
				" ORDER BY ".$orderBy." ".$order;
		$this->productList = $this->db->fetchall($sql);
	}
	
}

?>