<?php

importClass('views/basicTemplate');

class View extends BasicTemplate {
	
	public function setHeadTitleText(){
		$this->html['head']['title'] = 'Admin | 好牧人澳洲產品代購';
	}
	
	public function setHeadJavascript(){
		$this->html['head']['javascript'] = $this->element_folder.'head_admin_javascript.php';
	}
	
	public function setBodyContent(){
		$this->html['body']['content'] = $this->template_folder.'admin.php';
	}
	
}

?>