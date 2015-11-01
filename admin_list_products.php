<?php
include "./model/dbconnection.class.php";
include "./views/adminpage.class.php";
?>
<?php
/* This block used to connection db and make query
 *    to get the product table */
$db = new Dbconnection();
$sql = "SELECT *
			FROM product
			ORDER BY name";
$sqlResult = $db->fetchall($sql)
?>
<?php 
/* This block used to connection db and make query
 *    to get the brand table */
$sql = "SELECT brand_id, name
			FROM brand
			ORDER BY brand_id";
$brandTable = $db->fetchall($sql);
?>
<?php
$brand_list = new ArrayObject();
foreach ($brandTable as $brand){
	$brand_list[$brand["brand_id"]] = $brand["name"];
}
?>
<?php 
	$page = new Adminpage();
	
	$page->html_start();
	$page->head();
?>
<body>
<table cellpadding="2" cellspacing="0" border="1">
	<tr>
		<th>Product ID</th>
		<th>Brand Name</th>
		<th>Product Name</th>
		<th>Description</th>
		<th>Unit</th>
		<th>Weight</th>
		<th>Status</th>
	</tr>
<?php
foreach ($sqlResult as $row){
	if ($row["brand_id"] != NULL){
		$refBrandName = $brand_list[$row["brand_id"]];
	}
	else {
		$refBrandName = '<span style="color:#ccc">{null}</span>';
	}
	echo "<tr>
			<td align=\"center\">".$row["product_id"]."</td>
			<td>".$refBrandName."</td>
			<td><a href=\"admin_view_product_details.php?product=".$row["product_id"]."\">".$row["name"]."</a></td>
			<td>".$row["description"]."</td>
			<td>".$row["unit"]."</td>
			<td>".$row["weight"]."</td>
			<td>".$row["status"]."</td>
			</tr>";
	echo "\n";
}
?>

</table>
</body>
<?php 
	$page->html_end();
?>