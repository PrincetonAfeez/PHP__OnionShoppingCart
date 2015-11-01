<?php 
include "./model/dbconnection.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();

$table = 'post';
$post_type = htmlentities($_POST["post_type"]);
$post_date = $_POST["date"];
$post_title = htmlentities($_POST["title"]);
$post_content = htmlentities($_POST["content"]);
$post_slug = htmlentities($_POST["slug"]);
$sql = "INSERT INTO '.$table.' (post_type, date, title, content, slug) VALUES ('"
		.$post_type."','"
		.$post_date."','"
		.$post_title."','"
		.$post_content."','"
		.$post_slug
		."')";

$sqlResult = $db->insert($sql);
?>
<?php
if ($sqlResult){
	echo "<h2>NEW POST ADDED.</h2>";
}
?>
<a href="admin_list_posts.php">Back</a>

