<?php 
include "./model/dbconnection.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();

$new_brand = htmlentities($_POST["newBrand"]);
$sql = "INSERT INTO brand (name) VALUES ('".$new_brand."')";

$sqlResult = $db->insert($sql);
?>
<?php
if ($sqlResult){
	echo "<h2>NEW BRAND ADDED.</h2>";
}
?>
<a href="admin_list_brands.php">Back</a>

