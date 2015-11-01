<?php

function importClass($className){
	require_once $className.'.class.php';

}

function document_root(){
	return dirname($_SERVER['PHP_SELF']);
}

?>