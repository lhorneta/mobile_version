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
        $this->response = new Response();
    }
	
    public function action_index($url) {
        $str = "/" . $url . ".html";
        $this->getInformationPageId($str);
    }

    public function getInformationPageId($url) {
        
        $page_id = new ModelInformationPage();
        $ipid = $page_id->getInformationPageIdByLink($url);
        $id = $ipid[0];

        switch($id){//301 redirects in 3gstar
            case 43:  $id=131;
           // case 133: $id=131;
        }

        if ($id) {
            $this->getInformationPageTDK($id);
            $this->getInformationPageDescription($id);
        } else {
            $this->response->redirectToMainSite();
        }
    }

    public function getInformationPageTDK($id) {
        $tdk = new ModelInformationPage();
        $content = $tdk->getInformationPageTDKbyId($id);
        if ($content) {
            $this->view->getHeader('header.tpl', $content);
        } else {
            $this->response->redirectToMainSite();
        }
    }

    public function getInformationPageDescription($id) {
	$page_url = $this->response->getUrl();
        $info_page = new ModelInformationPage();
        $page = $info_page->getInformationPageById($id);
        $this->view->getSidebar($page_url, $page[0]['pages_name']);
        $this->view->getContent('information-page.tpl', $page);
    }

}