<?php

class Category extends Controller {

    public $link;
    public $id;
    public $request;
    
    public $view;
    
    function __construct(){
        $this->request = new Request();
        $this->view = new Controller_View();
        $this->response = new Response();
    }
    
    public function action_index() {
        $this->getParentCategory($_SESSION['parent_category']);
    }
    
    public function getCategoryById($link) {
        
        if(substr_count($link, "_")>=1){
            $id_cat = explode("_", $link);
            $max_key = max(array_keys($id_cat));
            $link = "-c-".$id_cat[$max_key];
            $pos = substr($this->response->getUrl(), 0, stripos($this->response->getUrl(), "-c-"));
            $redirect = SITE_URL.$this->response->trim($pos).$link.".html";
            $this->response->redirect($redirect);
        }

        $arrayCategoriesUrl = new ModelCategory();
        
        $content = $arrayCategoriesUrl->getCategoryById($link);
        $parent_category = $content[0];
        $_SESSION['parent_category'] = $parent_category;
	if($content[0]["categories_id"]==104){$this->response->redirect("modem-proizvoditeli-mob-a-148.html");}
        if ($content) {
            $cid = $content[0]['categories_id'];
            $products_number = $arrayCategoriesUrl->getProductsNumber($cid);
	    (int) $this->getCategoryTDKbyId($cid);
            $this->view->getSidebar('category', $_SESSION['parent_category']);

            /*pagination*/
            echo "<div class='category'>";
            (int) $this->getProductsByCategory($cid,'category');
            echo  "</div>";
            if(ITEM_TO_CATEGORY < $products_number){
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
                            . "width='16' height='16'"
                            . "title='loader' alt='img loader'>"
                    . "Показать еще ".ITEM_TO_CATEGORY." моделей...</div>
                    </form></div>
                ";
            }
            /*end pagination*/
            
        } else {
        //   $this->view->getContent('error.php');
            $this->response->redirectToMainSite();
        }

    }
    
    public function getCategoryTDKbyId($id) {
        $tdk = new ModelCategory();
        $content = $tdk->getCategoryTDKbyId($id);
        if ($content) {
            $this->view->getHeader('header.tpl', $content);
        } else {
        //    $this->view->getContent('error.php');
            $this->response->redirectToMainSite();
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