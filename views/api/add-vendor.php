<?php
importClass('model/dbconnection');
$db = new Dbconnection();

/* Append the category table */
$sql = "INSERT INTO vendor (name, country_code, address, tel, fax)";
$sql .= " VALUES ('".htmlentities($_POST['name'])."',";
$sql .= "'".htmlentities($_POST['country_code'])."',";
$sql .= "'".htmlentities($_POST['address'])."',";
$sql .= "'".htmlentities($_POST['tel'])."',";
$sql .= "'".htmlentities($_POST['fax'])."')";

try{
	$result = array(
					"result"=>$db->insert($sql)
				);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
?>