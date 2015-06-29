<?php

class Information_Page extends Controller {
    
    /*
     * @url from information page
     * @type string
     */
    public $url;
    public $view;
    
    function __construct(){
        $this->view = new Controller_View();
    }
	
    public function action_index($url) {
        $str = "/" . $url . ".html";
        $this->getInformationPageId($str);
    }

    public function getInformationPageId($url) {
        $page_id = new ModelInformationPage();
        $ipid = $page_id->getInformationPageIdByLink($url);
        $id = $ipid[0];
        $id = ($id==='43')?$id=131:$id;//да, это костыль, а ты идеален?
        if ($id) {
            $this->getInformationPageTDK($id);
            $this->getInformationPageDescription($id);
        } else {
            $this->view->getContent('404.tpl', '');
        }
    }

    public function getInformationPageTDK($id) {
        $tdk = new ModelInformationPage();
        $content = $tdk->getInformationPageTDKbyId($id);
        if ($content) {
            $this->view->getHeader('header.tpl', $content);
        } else {
            $this->view->getContent('404.tpl', '');
        }
    }

    public function getInformationPageDescription($id) {
	$page_url = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
        $info_page = new ModelInformationPage();
        $page = $info_page->getInformationPageById($id);
        $this->view->getSidebar($page_url, $page[0]['pages_name']);
        $this->view->getContent('information-page.tpl', $page);
    }

}