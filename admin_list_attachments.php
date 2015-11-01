<?php
include "./model/dbconnection.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();
$sql = "SELECT attach_id, post_type, uri, post_id
			FROM attachment
			ORDER BY post_type";
$sqlResult = $db->fetchall($sql);
?>
<table>
	<tr>
		<th>Attachment ID</th>
		<th>Post Type</th>
		<th>URI</th>
		<th>Post ID</th>
	</tr>
<?php
foreach ($sqlResult as $row){
	echo "
	<tr>
		<td align=\"center\">".$row["attach_id"]."</td>
		<td>".$row["post_type"]."</td>
		<td>".$row["uri"]."</td>
		<td>".$row["post_id"]."</td>
	</tr>
";
}
?>
	<tr>
		<td colspan="4"><form action="admin_action_add_attachment.php" method="post">
				Add New Brand<br />
				Post Type <select name="post_type">
					<option>categories</option>
					<option>product</option>
					<option>post</option>
				</select><br/>
				URI <input type="text" name="uri" size="20" /><br/>
				Post ID <input type="text" name="post_id" size="20" /><br/>
				<input type="submit" value="+">
			</form>
			</td>
	</tr>
</table>
