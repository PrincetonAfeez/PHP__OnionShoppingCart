<?php 
include "./model/dbconnection.class.php";
?>
<?php 
/* This block read form data */
$product_id = $_GET['product'];
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();

$sql = "SELECT *
			FROM product
			WHERE product_id = ".$product_id;
$product_details = $db->fetchone($sql);
$sql = "SELECT brand_id, name
			FROM brand
			ORDER BY brand_id";
$brand_result = $db->fetchall( $sql );
?>
<?php


?>
<html>
<head>
<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>
</head>
<body>
<form method="post" action="admin_action_update_product.php">
<p>Product ID: <input type="text" name="product_id" value="<?php echo $product_details["product_id"]; ?>" readonly /></p>
<p>Name: <input type="text" name="name" size="100" value="<?php echo $product_details["name"]; ?>" /></p>
<p>Brand: 
	<select name="brand_id">
	<?php
		foreach ($brand_result as $brand_rec) {
			echo "<option value='".$brand_rec["brand_id"]."'";
			if ($brand_rec["brand_id"] == $product_details["brand_id"]){
				echo " selected";
			}
			echo ">".$brand_rec["name"]."</option>\n";
		}
	?>
	</select>
</p>
<p>Description:<br /><textarea name="description" cols="100" rows="10"><?php echo $product_details["description"]; ?></textarea></p>
<p>Unit: <input type="text" name="unit" value="<?php echo $product_details["unit"]; ?>" /></p>
<p>Weight: <input type="text" name="weight" value="<?php echo $product_details["weight"]; ?>" /> kg</p>
<p>Selling Price: $ <input type="text" name="price" value="" /></p>
<div style="border:1px solid #666; padding:10px;">
	<h3>Promotion Setting</h3>
	<p>Discount Price: <input type="text" name="discount_price" value="" /></p>
	<p>Start Date: <input type="date" name="start_date" value="<?php echo date("Y-m-d");?>" /></p>
	<p>End Date: <input type="date" name="end_date" value="" /></p>
</div>
<p><input type="submit" value="Update" /></p>
</form>
</body>
</html>
