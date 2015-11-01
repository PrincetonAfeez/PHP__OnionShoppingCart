<?php
class Adminpage{
	
	private $title;
	private $charset;
	private $basepath;
	
	public function __construct($title='Admin page',$charset='utf-8',$basepath='/pms'){
		$this->title = $title;
		$this->charset = $charset;
		$this->basepath = $basepath;
	}
	
	public function setCharset($charset){
		$this->charset = $charset;
	}
	
	public function html_start(){
		echo '<!DOCTYPE html>
<html lang="zh-tw">
		';
	}
	
	public function head(){
		echo '
<head>
    <meta http-equiv="Content-Type" content="text/html;charset='.$this->charset .'">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>'.$this->title.'</title>
    
	<!-- Plug-in goes here -->
			
		<!--jQuery -->
		<script src="'.$this->basepath.'/asset/scripts/jquery-2.1.4.min.js"></script>
		<script src="'.$this->basepath.'/asset/scripts/jquery-migrate-1.2.1.min.js"></script>
				
	    <!-- Bootstrap -->
	    <link href="'.$this->basepath.'/asset/lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
	    <script src="'.$this->basepath.'/asset/lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
	    		
	<!-- Plug-in end -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
		';
	}

	public function html_end(){
		echo '</html>';
	}
}
?>