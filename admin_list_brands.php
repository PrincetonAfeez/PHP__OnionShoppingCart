<?php
include "./model/dbconnection.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();
$sql = "SELECT brd.brand_id, brd.name AS BrandName
			FROM brand AS brd
			ORDER BY BrandName";
$sqlResult = $db->fetchall($sql);
?>
<table>
	<tr>
		<th>Brand ID</th>
		<th>Brand Name</th>
	</tr>
<?php
foreach ($sqlResult as $row){
	echo "<tr>\n<td align=\"center\">".$row["brand_id"]."</td>\n<td>".$row["BrandName"]."</td>\n</tr>";
	echo "\n";
}
?>
	<tr>
		<td colspan="2"><form action="admin_action_add_brand.php" method="post">
				Add New Brand<br />
				<input type="text" name="newBrand" size="20" />
				<input type="submit" value="+">
			</form>
			</td>
	</tr>
</table>
