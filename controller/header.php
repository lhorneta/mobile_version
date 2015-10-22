<?php

class Header extends Controller {
    
   public $view;
    
    function __construct(){
        $this->view = new Controller_View();
        $this->response = new Response();
    }

    public function action_index($page_type) {
       $this->loadTempalte($page_type);
       
    }

    public function getTDK() {
        return parent::load(HELPERS_PATH,'helper_tdk_inner_pages.php');
    }

    public function loadTempalte($page_type) {
        $content = $this->getTDK();

        $this->view->getHeader('header.tpl', $content[$page_type]);
    }
    
    public function setRelCanonical() {
       return FULL_SITE.$this->response->trim($this->response->getUrl());
    }

}