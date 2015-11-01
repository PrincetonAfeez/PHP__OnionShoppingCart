<?php /* Initialization */
$basePath = '.';
include $basePath.'/application/core_functions.php';
?>
<?php /* import classes */
importClass('controller/basic');
importClass('model/page');
?>
<?php /* Construct instances */
$model['page'] = new Page();
$controller['basic'] = new BasicController($model['page']);
$controller['basic']->loadView();
?>
