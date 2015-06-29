<?php

class Pagination {

    public $id;
    public $request;
    public $view;

    function __construct() {
        $this->request = new Request();
        $this->view = new Controller_View();
    }

    public function init($id, $limit_start, $limit_end, $ajax) {

        $products = new ModelCategory();
        $items = $products->getProductsByCategory($id, '', '');
        $content = array();
        //echo "<br/>limit_start ".$limit_start."<br/> limit_end ".$limit_end."<br/>";
        foreach ($items as $key => $item) {
            
            if ($key >= $limit_start && $key < $limit_end) {
               // echo " ".$key;
                $content[] = $item;
            }
        }

        if ($ajax !== 'paginator') {

            if ($content) {
                $this->view->getContent('category.tpl', $content);
            } else {
                $this->view->getContent('404.tpl', '');
            }
            
        } else {
            $content = $products->getProductsByCategory($id, $limit_start, $limit_end);
        }
    }

}
