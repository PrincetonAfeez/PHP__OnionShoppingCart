<?php
include "./model/dbconnection.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();
$sql = "SELECT post_id, post_type, date, title, content, slug
			FROM post
			ORDER BY post_type, post_id";
$sqlResult = $db->fetchall($sql);
?>
<table>
	<tr>
		<th>Post ID</th>
		<th>Post Type</th>
		<th>Date</th>
		<th>Title</th>
		<th>Content</th>
		<th>slug</th>
	</tr>
<?php
foreach ($sqlResult as $row){
	echo "
	<tr>
		<td align=\"center\">".$row["post_id"]."</td>
		<td>".$row["post_type"]."</td>
		<td>".$row["date"]."</td>
		<td>".$row["content"]."</td>
	</tr>
";
}
?>
	<tr>
		<td colspan="4"><form action="admin_action_add_post.php" method="post">
				Add New Post<br />
				Post Type <select name="post_type">
					<option>news</option>
					<option>home-heading-banner</option>
				</select><br/>
				Date <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" /><br/>
				Title <input type="text" name="title" size="50" /><br/>
				Slug <input type="text" name="slug" size=""50" /><br/>
				Content<br/>
				<textarea name="content" rows="5" cols="100"></textarea><br/>
				<input type="submit" value="+">
			</form>
			</td>
	</tr>
</table>
