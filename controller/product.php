<?php

/*
* 
* @descritpion: class product for display card product
* 
* Order of product templates:
* 
* 1) product.tpl
* 2) product_options.tpl
* 3) product_buy_button.tpl
* 4) product_description.tpl
* 5) product_characteristic.tpl
* 6) comments.tpl
* 7) product_middle_accordion.tpl
* 8) product_bottom.tpl
*/
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
        $this->response = new Response();
    }

    public function action_index($link) {
        if ($this->getProductByLink($link) === true) {
            $this->setTimeFromLeaveOrders();
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
            
            //(int) $this->getOptionsPrice($pid);
            $this->view->getContent('product_buy_button.tpl', $content);
            $this->getProductCharacteristicById($pid);
            $this->view->getContent('product-description.tpl', $content);
            $this->getComments($link);
            $this->loadProductBottom($pid);
            
            return true;
        } else {
            $this->response->redirectToMainSite();
            return null;
        }
    }

    public function getProductTDKbyId($id) {
        $tdk = new ModelProduct();
        $content = $tdk->getProductTDKbyId($id);
        if ($content) {
            $this->view->getHeader('header.tpl', $content);
        } else {
            $this->response->redirectToMainSite();
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
                        .       "<img src=".'img/m_charaterics/'.$images[$char['m_foto_id_characteristic'.$i]]['img']." width='50' height='50'>"
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
            $this->view->getContent('product-characteristic.tpl', 'Характеристики отсутствуют на данный товар');
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

    public function loadProductBottom($pid) {
        $phrase = $this->setTimeFromLeaveOrders();
        $content = ($phrase !== '') ? $phrase : '';
        $this->view->getContent('product-middle-accordion.tpl', $content);
        $this->getYoutubeVideo($pid);
    }

    public function getParentCategory() {
        $parent_category = ($_SESSION['parent_category']) ? $_SESSION['parent_category'] : '';
        $this->view->getSidebar($type, $parent_category);
    }
    
    public function getOptionsPrice($id) {
        $option = new ModelProduct();
        $content = $option->getProductOptionsPrice($id);

        if ($content) {
            $this->view->getContent('product_options.tpl',$content);
        }
    }
    
    public function getYoutubeVideo($id) {
        
        $product = new ModelProduct();
        $video = $product->getVideoReview($id);

        if($video){
           $patterns = explode('popup-youtube', $video[0]);
           $str=strpos($patterns[1], "<iframe"); 
           $item = substr($patterns[1], $str);
           $frame="<div class='video-block'>".$item. "</div>";
           if(!empty($item)){$this->view->getContent('product-video.tpl',$frame);}
           
        }
        $phrase = $this->setTimeFromLeaveOrders();
        $content = ($phrase !== '') ? $phrase : '';
        $this->view->getContent('product-bottom.tpl',$content);
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