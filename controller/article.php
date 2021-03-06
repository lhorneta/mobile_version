<?php
class Article extends Controller{
	
    /*
    * @link from url for article
    * @type string
    */
    public $link;
     
    public $view;
    
    function __construct(){
    
        $this->view = new Controller_View();
        $this->response = new Response();
    }
    
    public function action_index($link){
        $this->getArticleById($link);
    }

    public function getArticleById($url){
        $article_url = $this->response->getUrl();
        $aid = substr($url, 3);
        $article = new ModelArticle();
        $content = $article->getArticleContentById($aid);
        $tdk = $article->getArticleTDKbyId($aid);
        $this->view->getHeader('header.tpl', $tdk);
        $this->view->getSidebar($article_url, $content[0]['articles_name']);
        $this->view->getContent('article.tpl',$content);
    }
    
}