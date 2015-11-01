<?php

importClass('views/basicTemplate');

class View extends BasicTemplate {
	public function setBodyContent(){
		$this->html['body']['content'] = $this->template_folder.'product.php';
	}
	
	public function setHeadJavascript(){
		$this->html['head']['javascript'] = $this->element_folder.'head_product_javascript.php';
	}
	
	public function setHeadTitleText(){
		$this->html['head']['title'] = 'Product | 好牧人澳洲產品代購';
	}
}

?>