<?php

/**
 * Template Name: index
 */
class Controller_View extends View{
    
    /*
     * @set params to layout
     * @type array
     */
    public $content;

    /*
     * @set comments to layout
     * @type array
     */
    public $comments;

    /*
     * @set name template
     * @type string
     */
    public $template;

    public function indexAction() {
        
    }

    public function getHeader($template, $content) {
        parent::doHeader($template, $content);
    }

    public function getSidebar($template, $content) {

        if($template !==null && $template!=='' && $content !==NULL && $content !==''){
            
            $searchCat = '
                <div class="resize_one parent_category">
                        <a href=' . "?" . $content['link'] . '>
                                ' . $content['categories_heading_title'] . '
                        </a>
                </div><a class="rel_style" href="#menu"></a>';
 
            $searchProduct = '
                <div class="resize_one">
                            <a href=' . "?" . $content['link'] . '>
                                ' . $content['categories_heading_title'] . '
                            </a>
                        </div><a class="rel_style" href="#menu"></a>';
    
            $searchInfo = '
                <div class="resize_one parent_category">
                        <a href=' . "?" . $content . '>
                                ' . $content . '
                        </a>
                </div><a class="rel_style" href="#menu"></a>';
 
            $type_of_content = array(CATEGORY,PRODUCT,ARTICLE);
            $key = in_array($template, $type_of_content);
            if($key){  
               switch ($template) {
                    case CATEGORY: $search = $searchCat;break;
                    case PRODUCT:  $search = $searchProduct;break;
                    case ARTICLE:  $search = $searchInfo;break;
                    default:"";
                }
             }else{
                $search = $searchInfo;
              }
        }else{
            $this->getContent('yandex-search.tpl', '');
            $search = '';
        }

        parent::doHeader('sidebar-menu.tpl', $search);
    }

    public function getContent($template, $content) {
        if ($template) {
            parent::doDisplay($template, $content);
        }
    }

    public function getFooter($tpl) {
        $template = ($tpl === 'mainpage') ? 'footer.tpl' : 'footer-menu.tpl';

        parent::doFooter($template);
    }

    public function get404() {
        parent::do404('404.tpl');
    }

    public function popupLocalstorageNotSupport() {
        parent::localstorageNotSupport('popup-localstorage.tpl');
    }   
    
}