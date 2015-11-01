<?php
importClass("model/dbconnection");
importClass("model/page");
?>
<?php
/* This block used to connection db and make query*/
$db = new Dbconnection();
$model['page'] = new Page();
?>
<div class="page-content <?php echo $model['page']->getPostType(); ?>">
	<?php require_once './views/elements/body_admin_top_nav.php'; ?>
	<div class="container theme-showcase" role="main">
	<?php 
		if ($model['page']->getInstance() == 'list-product'){
			require_once './views/elements/body_admin_list_product.php';
		}
		if ($model['page']->getInstance() == 'edit-product'){
			require_once './views/elements/body_admin_edit_product.php';
		}
		if ($model['page']->getInstance() == 'list-vendor'){
			require_once './views/elements/body_admin_list_vendor.php';
		}
	?> 
	</div> <!-- /container -->
</div> <!-- /page-content -->
