<?php

class Category extends Controller {

    public $link;
    public $id;
    public $request;
    
    public $view;
    
    function __construct(){
        $this->request = new Request();
        $this->view = new Controller_View();
    }
    
    public function action_index() {
        $this->getParentCategory($_SESSION['parent_category']);
    }
    
    public function getCategoryById($link) {
        $arrayCategoriesUrl = new ModelCategory();
        $content = $arrayCategoriesUrl->getCategoryById($link);
        $parent_category = $content[0];
        $_SESSION['parent_category'] = $parent_category;
        if ($content) {
            $cid = $content[0]['categories_id'];
	    (int) $this->getCategoryTDKbyId($cid);
            $this->view->getSidebar('category', $_SESSION['parent_category']);

            /*pagination*/
            $products_number = $arrayCategoriesUrl->getProductsNumber($cid);
            echo "<div class='category'>";
            (int) $this->getProductsByCategory($cid,'category');
            echo  "</div>";
            echo  "
                   <div class='container'> <form class='following-products'>
                        <div class='show_load'>Показано 
                            <span>".ITEM_TO_CATEGORY."</span>"
                            . " моделей из ".$products_number."</div>
                        <div
                            data-count=".ITEM_TO_CATEGORY." 
                            data-category-id='".$cid."'
                            data-count-max='".$products_number."' 
                            class='pagination' 
                        >
                        <img
                             src='".IMG.'/ajax-loader.gif'."' "
                            . "width='16px' height='16px'"
                            . "title='loader' alt='img loader'>"
                    . "Показать еще ".ITEM_TO_CATEGORY." моделей...</div>
                    </form></div>
                ";
             /*end pagination*/
            
        } else {
            $this->view->getContent('404.tpl', '');
        }
    }
    
    public function getCategoryTDKbyId($id) {
        $tdk = new ModelCategory();
        $content = $tdk->getCategoryTDKbyId($id);
        if ($content) {
            $this->view->getHeader('header.tpl', $content);
        } else {
            $this->view->getContent('404.tpl', '');
        }
    }
	
    public function getProductsByCategory($id,$ajax) {
      
        if($ajax===CATEGORY){
            $pagination = new Pagination();
            $pagination->init($id,0,15,$ajax);
        }
    }
    
    public function getParentCategory() {
        $parent_category = ($_SESSION['parent_category']) ? $_SESSION['parent_category'] : '';
        $this->view->getSidebar($type, $parent_category);
    }

}