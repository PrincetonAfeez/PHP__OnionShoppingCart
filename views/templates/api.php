<?php
/* define object(s) */
$model['page'] = new Page();
?>
<?php
/* determine the API file from request path */
if ($model['page']->getInstance() != NULL){
	require_once './views/api/'.$model['page']->getInstance().'.php';}
?> 
