<?php

class BasicTemplate {
	protected  $html;
	protected  $element_folder;
	protected  $template_folder;
	
	function __construct(){
		$this->element_folder = './views/elements/';
		$this->template_folder = './views/templates/';
		$this->setBasic();
		$this->setHeadMeta();
		$this->setHeadPlugin();
		$this->setHeadCss();
		$this->setHeadJavascript();
		$this->setHeadTitleText();
		$this->setBodyContent();
	}
	
	public function setBasic(){
		$this->html['html']['start'] = $this->element_folder.'html_start.php';
		$this->html['html']['end'] = $this->element_folder.'html_end.php';
		
		$this->html['head']['start'] = $this->element_folder.'head_start.php';
		$this->html['head']['end'] = $this->element_folder.'head_end.php';
		
		$this->html['body']['start'] = $this->element_folder.'body_start.php';
		$this->html['body']['end'] = $this->element_folder.'body_end.php';
		
	}
	
	public function setHeadTitleText(){
		$this->html['head']['title'] = 'SiteSmart - Developed by The Onion Technology';
	}
	
	public function setHeadMeta(){
		$this->html['head']['meta'] = $this->element_folder.'head_meta.php';
	}
	
	public function setHeadPlugin(){
		$this->html['head']['plugin'] = $this->element_folder.'head_plugin.php';
	}
	
	public function setHeadCss(){
		$this->html['head']['css'] = $this->element_folder.'head_css.php';
	}
	
	public function setHeadJavascript(){
		$this->html['head']['javascript'] = $this->element_folder.'head_javascript.php';
	}
	
	public function setBodyContent(){
		$this->html['body']['content'] = '';
	}
	
	public function showView(){
		$this->loadElement( $this->html['html']['start']);
		$this->loadElement( $this->html['head']['start']);
		$this->loadElement( $this->html['head']['meta']);
		$this->printHtml('<title>'.$this->html['head']['title'].'</title>');
		$this->loadElement( $this->html['head']['plugin']);
		$this->loadElement( $this->html['head']['css']);
		$this->loadElement( $this->html['head']['javascript']);
		$this->loadElement( $this->html['head']['end']);
		$this->loadElement( $this->html['body']['start']);
		$this->loadElement( $this->html['body']['content']);
		$this->loadElement( $this->html['body']['end']);
		$this->loadElement( $this->html['html']['end']);
	}
	
	protected function loadElement($templatePath){
		if ($templatePath){
			require_once $templatePath;
		}		
	}
	
	protected function printHtml($text){
		echo $text;
	}
}