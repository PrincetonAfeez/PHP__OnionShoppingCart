<?php

importClass('views/basicTemplate');

class View extends BasicTemplate {
	
	public function setBodyContent(){
		$this->html['body']['content'] = $this->template_folder.'api.php';
	}
	
	public function showView(){
		$this->loadElement( $this->html['body']['content']);
	}
	
}

?>