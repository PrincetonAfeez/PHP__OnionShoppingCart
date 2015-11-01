<?php
include "./model/dbconnection.class.php";
include "./model/category.class.php";
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();
$category = new Category($db);
$rootCategoryList = $category->getRootCategoryList($db);
?>
<?php require_once './views/elements/body_top_nav.php'; ?>
<div class="container theme-showcase" role="main">
	<?php require_once './views/elements/body_carousel_banner.php'; ?>
	<?php require_once './views/elements/body_root_category_gallery.php'; ?>
	<?php require_once './views/elements/body_news_board.php'; ?>
</div> <!-- /container -->
<?php require_once './views/elements/body_footer.php'; ?>
