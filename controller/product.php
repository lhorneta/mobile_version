<?php

class Product extends Controller {
    
    /*
     * @link from url for product
     * @type string
     */
    public $link;

    /*
     * @array of all content into template
     * @type array
     */
    public $content = array();
     
    public $view;
    
    function __construct(){
        $this->view = new Controller_View();
    }

    public function action_index($link) {
        if ($this->getProductByLink($link) === true) {
            $this->getComments($link);
            $this->loadProductBottom();
            $this->setTimeFromLeaveOrders();
            //$this->getParentCategory($_SESSION['parent_category']);
        }
    }

    public function getProductByLink($link) {
        $pid = substr($link, 3);
        (int) $this->getProductTDKbyId($pid);
        $product = new ModelProduct();
        $content = $product->getProductById($pid);
        if ($content) {
            $parent_category_index = array(
                "parent_category" => '',
                "link" => "mainpage",
                "categories_heading_title" => "Вернуться на главную"
            );
            $parent_category = (isset($_SESSION['parent_category'])) ? $_SESSION['parent_category'] : $parent_category_index;
            $this->view->getSidebar('product', $parent_category);
            $this->view->getContent('product.tpl', $content);
            $this->getProductCharacteristicById($pid);
            $this->view->getContent('product-description.tpl', $content);
            return true;
        } else {
            $this->view->getContent('404.tpl', '');
            return null;
        }
    }

    public function getProductTDKbyId($id) {
        $tdk = new ModelProduct();
        $content = $tdk->getProductTDKbyId($id);
        if ($content) {
            $this->view->getHeader('header.tpl', $content);
        } else {
            $this->view->getContent('404.tpl', '');
        }
    }

    public function getProductCharacteristicById($id) {
        
        $characteristic = new ModelProduct();
        $characteristics = $characteristic->getProductCharacteristicById($id);
        
        $images = parent::load(HELPERS_PATH,'helper_characteristic.php');
        $char=$characteristics[0];

        $content = '';
        if($characteristics){
            for($i=0,$n=count($char);$i<$n;$i++){
              if(
                     isset($char['m_foto_id_characteristic'.$i])  &&
                      $char['m_characteristic'.$i] !==''
                ){
                    $content .= 
                        "<tr>"
                        .   "<td class='one_b'>"
                        .       "<img src=".'img/m_charaterics/'.$images[$char['m_foto_id_characteristic'.$i]]['img']." width='50px' height='50px'>"
                        .   "</td>"
                        .   "<td class='two_b'>"
                        .       $char['m_characteristic'.$i]
                        .   "</td>"
                        . "</tr>";
               }
            }
        }else{$content = '';}
        if ($content) {
            $this->view->getContent('product-characteristic.tpl', $content);
        } else {
            $this->view->getContent('product-characteristic.tpl', 'Характеристики отсуствуют на данный товар');
        }
    }
	
    public function getComments($link) {
        $product = new ModelProduct();
        $comments = $product->getCommentsByLink($link);
        if ($comments !== false) {
            $content = $comments;
        } else {
            $content = false;
        }
        $this->view->getContent('comments.tpl', $content);
    }

    public function loadProductBottom() {
        $phrase = $this->setTimeFromLeaveOrders();
        $content = ($phrase !== '') ? $phrase : '';
        $this->view->getContent('product-bottom.tpl', $content);
    }

    public function getParentCategory($content) {
        $parent_category = ($_SESSION['parent_category']) ? $_SESSION['parent_category'] : '';
        $this->view->getSidebar($type, $parent_category);
    }

    public function setTimeFromLeaveOrders() {
        $today = getdate();
        $hours = $today['hours'];
        $day = $today['wday'];
        $phrases = array(
            "day_time" => "в течение <strong>5 минут</strong>",
            "night_time" => "в ближайшее время"
        );
        if ($day >= 1 && $day <= 5 && $hours >= 8 && $hours < 21) {//Будние дни
            $phrase = $phrases['day_time'];
        } else if ($day >= 6 && $day <=0 && $hours > 10 && $hours < 18) {//Выходные дни (сб/вс)
            $phrase = $phrases['day_time'];
        } else {
            $phrase = $phrases['night_time'];
        }
        return $phrase;
    }

}