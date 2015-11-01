
<!-- User define CSS -->
	<link href="<?php echo document_root(); ?>/asset/css/main.css" rel="stylesheet">
	<link href="<?php echo document_root(); ?>/asset/css/override_bootstrap.css" rel="stylesheet">
<?php
	$model['page'] = new Page();
	if ($model['page']->getPostType() == 'admin'){
		echo '	<link href="'.document_root().'/asset/css/admin.css" rel="stylesheet">'."\n"; 
	}
?>
<!-- User define CSS end -->
