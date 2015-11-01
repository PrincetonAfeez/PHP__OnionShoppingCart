<?php
importClass('model/dbconnection');
$db = new Dbconnection();

/* Update the product table */
$sql['product'] = "UPDATE product SET ";
$sql['product'] .= "slug='".htmlspecialchars(htmlentities($_POST['slug']))."', ";
if (strlen($_POST['brand_id']) > 0) {
	$sql['product'] .= "brand_id='".htmlspecialchars(htmlentities($_POST['brand_id']))."', ";
} else {
	$sql['product'] .= "brand_id=NULL, ";
}
$richtext = $_POST['description'];
$richtext = preg_replace("/[\n\r]*/", '', $richtext);
$richtext = preg_replace("/'/", '&#39;', $richtext);
$sql['product'] .= "description='".htmlentities($richtext)."', ";

$sql['product'] .= "unit='".htmlspecialchars(htmlentities($_POST['unit']))."', ";
$sql['product'] .= "weight=".htmlspecialchars(htmlentities($_POST['weight'])).", ";
$sql['product'] .= " status='".htmlspecialchars(htmlentities($_POST['status']))."' ";
$sql['product'] .=	" WHERE product_id=".htmlentities($_POST['product_id']);

/* Append the cat_tag_relationship table */
$sql['add_cat_tag_relationship'] = "INSERT INTO cat_tag_relationship (product_id, relation_type, relation) ";
$sql['add_cat_tag_relationship'] .= "VALUES (".htmlentities($_POST['product_id']).", ";
$sql['add_cat_tag_relationship'] .= "'category', ";
if (strlen($_POST['cat_id']) > 0) {
	$sql['add_cat_tag_relationship'] .= htmlspecialchars(htmlentities($_POST['cat_id'])).")";
} else {
	$sql['add_cat_tag_relationship'] .= "NULL)";
}

/* Update the cat_tag_relationship table */
$sql['update_cat_tag_relationship'] = "UPDATE cat_tag_relationship SET";
if (strlen($_POST['cat_id']) > 0) {
	$sql['update_cat_tag_relationship'] .= " relation=".htmlspecialchars(htmlentities($_POST['cat_id']));
} else {
	$sql['update_cat_tag_relationship'] .= " relation=NULL";
}
$sql['update_cat_tag_relationship'] .= " WHERE product_id=".htmlentities($_POST['product_id']);

/* Append the attachment table */
$sql['add_attachment'] = "INSERT INTO attachment (post_id, post_type, uri) ";
$sql['add_attachment'] .= "VALUES (".htmlentities($_POST['product_id']).", ";
$sql['add_attachment'] .= "'product', ";
if (strlen($_POST['feature_image']) > 0) {
	$sql['add_attachment'] .= "'".htmlspecialchars(htmlentities($_POST['feature_image']))."')";
} else {
	$sql['add_attachment'] .= "'')";
}

/* Update the attachment table */
$sql['update_attachment'] = "UPDATE attachment SET";
if (strlen($_POST['feature_image']) > 0) {
	$sql['update_attachment'] .= " uri='".htmlspecialchars(htmlentities($_POST['feature_image']))."'";
} else {
	$sql['update_attachment'] .= " uri=NULL";
}
$sql['update_attachment'] .= " WHERE post_type='product' and post_id=".htmlentities($_POST['product_id']);

/* Check rather update or append */
$sql['check_cat_exist'] = "SELECT COUNT(id) AS num FROM cat_tag_relationship WHERE product_id=".htmlentities($_POST['product_id']);
$sql['check_attachment_exist'] = "SELECT COUNT(attach_id) AS num FROM attachment WHERE post_type='product' and post_id=".htmlentities($_POST['product_id']);

try{
	$sqlReturn = $db->update($sql['product']);
	$catCheck = $db->fetchone($sql['check_cat_exist']);
	if ($catCheck['num'] == 0){
		$sqlReturn = $sqlReturn and $db->insert($sql['add_cat_tag_relationship']);
	} else {
		$sqlReturn = $sqlReturn and $db->update($sql['update_cat_tag_relationship']);
	}
	$attachmentCheck = $db->fetchone($sql['check_attachment_exist']);
	if ($attachmentCheck['num'] == 0){
		$sqlReturn = $sqlReturn and $db->insert($sql['add_attachment']);
	} else {
		$sqlReturn = $sqlReturn and $db->update($sql['update_attachment']);
	}
	$result = array(
					"result"=>$sqlReturn
				);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
?>