<?php

importClass('views/basicTemplate');

class View extends BasicTemplate {
	public function setBodyContent(){
		$this->html['body']['content'] = $this->template_folder.'index.php';
	}

	public function setHeadTitleText(){
		$this->html['head']['title'] = '好牧人澳洲產品代購';
	}
}

?>