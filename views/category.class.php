<?php

include './views/basicTemplate.class.php';

class View extends BasicTemplate {
	public function setBodyContent(){
		$this->html['body']['content'] = $this->template_folder.'category.php';
	}

	public function setHeadTitleText(){
		$this->html['head']['title'] = 'Category | 好牧人澳洲產品代購';
	}
}

?>