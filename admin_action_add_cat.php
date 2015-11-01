<?php 
include "./model/dbconnection.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();

$new_cat = htmlentities($_POST["newCat"]);
$parent_cat = htmlentities($_POST["parentCat"]);
if (strlen($parent_cat) > 0){
	$sql = "INSERT INTO categories (name, parent_cat) VALUES ('".$new_cat."',".$parent_cat.")";
} else {
	$sql = "INSERT INTO categories (name) VALUES ('".$new_cat."')";	
}

$sqlResult = $db->insert($sql);
?>
<?php
if ($sqlResult){
	echo "<h2>NEW CATEGORY ADDED.</h2>";
}
?>
<a href="admin_list_root_categories.php">Back</a>

