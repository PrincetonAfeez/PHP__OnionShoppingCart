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