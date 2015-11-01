<?php

class Page{
	
	private $query;
	
	function __construct() {
		$this->query = $this->extract_uri($_SERVER['REQUEST_URI']);
	}
	
	/********************** GET/SETTER ***********************/
	public function getAppName(){
		return $this->query['app'];
	}
	
	public function getPostType(){
		return $this->query['postType'];
	}
	
	public function getInstance(){
		return $this->query['instance'];
	}
	
	public function getSubType(){
		return $this->query['subType'];
	}
	/******************** END GET/SETTER *********************/
	
	
	/****************** PRIVATE FUNCTIONS ********************/
	private function extract_uri($path){
		$query = new ArrayObject();
		
		$pathInfo = explode("/", $path);
		array_shift($pathInfo);
		
		$query['app'] = $pathInfo[0];
		if (sizeof($pathInfo) > 2){
			$query['postType'] = $pathInfo[1];
		} else {
			$query['postType'] = NULL;
		}
		$query['subType'] = array_slice(
								$pathInfo,
								sizeof($query),
								sizeof($pathInfo)-sizeof($query)-1
							);
		$query['instance'] = end($pathInfo);
		return $query;
	}
	/**************** END PRIVATE FUNCTIONS ******************/
	
}


?>
