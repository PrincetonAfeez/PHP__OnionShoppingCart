<?php

Class BasicController {
	protected $model;
	
	function __construct($model) {
		$this->model = $model;
	}
	
	public function loadView(){
		if ($this->model->getPostType() == NULL){
			require_once './views/index.class.php';
		} else {
			require_once './views/'.$this->model->getPostType().'.class.php';
		}
		$viewInstance = new View();
		$viewInstance->showView();
	}
	
}
?>
