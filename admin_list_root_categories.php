<?php
include "./model/dbconnection.class.php";
include "./views/adminpage.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();
$sql = "SELECT *
			FROM categories
			WHERE parent_cat is NULL
			ORDER BY name";
$sqlResult = $db->fetchall($sql);
?>
<?php 
	$page = new Adminpage();
	
	$page->html_start();
	$page->head();
?>
<body>
<table>
	<tr>
		<th>Category ID</th>
		<th>Category Name</th>
	</tr>
<?php
foreach ($sqlResult as $row){
	echo "<tr>\n<td align=\"center\">".$row["cat_id"]."</td>\n<td>".$row["name"]."</td>\n</tr>";
	echo "\n";
}
?>
	<tr>
		<td colspan="2"><form action="admin_action_add_cat.php" method="post">
				Add New Root Category<br />
				<input type="text" name="newCat" size="20" />
				<input type="submit" value="+">
			</form>
			</td>
	</tr>
</table>
</body>
<?php 
	$page->html_end();
?>
