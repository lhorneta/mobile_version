<?php

class Template extends Controller {
    
    /*
     * @link from url for product
     * @type string
     */
    public $link;
    
    public $view;
    
    function __construct(){
        $this->view = new Controller_View();
        $this->response = new Response();
    }

    public function action_index($link) {
        $tid = substr($link, 3);
        $this->getTDKbyHelper();
        $this->getSidebar();
        $this->getListArticles($tid);
    }

    public function getTDKbyHelper() {
        $content = parent::load(HELPERS_PATH,'helper_tdk_inner_pages.php');
        if ($content['template']) {
            $this->view->getHeader('header.tpl', $content['template']);
        } else {
            //$this->view->getContent('error.php');
            $this->response->redirectToMainSite();
        }
    }

    public function getSidebar() {
        $content = parent::load(HELPERS_PATH,'helper_menu_mob_list_articles.php');
        $this->view->getSidebar($content[0][0]['url'], $content[0][0]['text']);
    }

    public function getListArticles($id) {
       $template = new ModelTemplate();
       $content = $template->getListArticlesById($id);
       echo "<div class='container'><div class = 'row contact-store'><ul>";
       $this->view->getContent('list-articles.tpl', $content);
       echo "</ul></div></div>";
     }
}