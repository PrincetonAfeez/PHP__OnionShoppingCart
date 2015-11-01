<?php
importClass('model/vendor');

class VendorManager extends Vendor{
	
	public function getVendorList($searchkey='', $orderBy='vendor_id'){
		if (strlen($orderBy) == 0){
			$orderBy='vendor_id';
		}
		$searchCondition = '';
		if (strlen($searchkey) > 0){
			$searchCondition = " WHERE name LIKE '%".$searchkey."%'".
					" OR vendor_id LIKE '%".$searchkey."%'".
					" OR country_code LIKE '%".$searchkey."%'".
					" OR tel LIKE '%".$searchkey."%'".
					" OR fax LIKE '%".$searchkey."%'".
					" OR address LIKE '%".$searchkey."%'";
		}
		$sql = "SELECT *
				FROM vendor".
				$searchCondition.
				" ORDER BY ".$orderBy;
		return $this->db->fetchall($sql);
	}
		
}

?>