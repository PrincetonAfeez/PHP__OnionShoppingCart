<?php 
include "./model/dbconnection.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();

$attachment_type = htmlentities($_POST["post_type"]);
$attachment_uri = htmlentities($_POST["uri"]);
$attachment_post = htmlentities($_POST["post_id"]);
$sql = "INSERT INTO attachment (post_type, uri, post_id) VALUES ('"
		.$attachment_type."','"
		.$attachment_uri."',"
		.$attachment_post
		.")";

$sqlResult = $db->insert($sql);
?>
<?php
if ($sqlResult){
	echo "<h2>NEW ATTACHMENT ADDED.</h2>";
}
?>
<a href="admin_list_attachments.php">Back</a>

