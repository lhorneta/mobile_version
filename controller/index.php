<?php

class Controller_Index extends Controller {
    
    /*
     * @get type of content
     * @type string
     */
    public $type;

    /*
     * @set url address layout
     * @type string
     */
    public $url_param;

    /*
     * @create new object class controller 
     * @type object
     */
    public $obj;

    /*
     * @create saves parent category
     * @type session
     */
    public $parent_category = null;
    
    public $view;
    public $request;
    
    function __construct(){
        $this->view = new Controller_View();
	$this->request = new Request();
    }
	
    public function indexAction($type, $url_param) {
        $this->setStaticTemplates();
        $this->getTypeOfTemplateDisplay($type, $url_param);
        $this->getParentCategory($type);
        $this->setDinamicTemplates($type);
    }
    
    
    public function getTDKStaticPagesHelper(){
        $content = parent::load(HELPERS_PATH,'helper_tdk_inner_pages.php');
        return $content;
    }
	
    public function getTypeOfTemplateDisplay($type, $url_param) {

        switch ($type) {
            case "category":
                $parent_category_index = array(
                    "parent_category" => '',
                    "link" => "mainpage",
                    "categories_name" => "Вернуться на главную"
                );
                $obj = new Category();
                $obj->getCategoryById($url_param);
                $parent_category = ($_SESSION['parent_category']) ? $_SESSION['parent_category'] : $parent_category_index;
                $this->view->getSidebar($type, $parent_category);
                break;
            case "product":
                $parent_category_index = array(
                    "parent_category" => '',
                    "link" => "mainpage",
                    "categories_name" => "Вернуться на главную"
                );
		$obj = new Product();
                $obj->action_index($url_param);
                break;
            case "article": $obj = new Article(); $obj->action_index($url_param);break;
            case "tarifi": $obj = new Information_Page(); $obj->action_index($url_param);break;
            case "pokritie": $obj = new Information_Page(); $obj->action_index($url_param);break;
            case "mtc-konnekt": $obj = new Information_Page(); $obj->action_index($url_param);break;
            case "undefined":  $this->view->getHeader('header.tpl',''); $this->getStaticPage("404","404 - Страница не найдена"); $this->view->get404(); break;
            case "template":  $obj = new Template(); $obj->action_index($url_param);break;
            case "cart": $this->getStaticPage("cart","Корзина");break;
            case "mainpage":$this->getStaticPage("mainpage","");break;
            case "404": $this->getStaticPage("404","404 - Страница не найдена");break;
            case "contakti": $this->getStaticPage("contakti","Контакты");break;
            case "search": $this->getStaticPage("search","");break;
            case "oplata": $this->getStaticPage("oplata","Оплата");break;
            case "dostavka": $this->getStaticPage("dostavka","Доставка");break;
            default: $this->getStaticPage("mainpage","");break;
        }
    }
	
    public function getStaticPage($page_type,$title) {
            $tdk = $this->getTDKStaticPagesHelper();
            $this->view->getHeader('header.tpl',$tdk[$page_type]);
            $this->view->getSidebar($page_type, $title);
            $this->view->getContent($page_type.TPL, '');
	}
	
    public function setStaticTemplates() {
        $this->view->indexAction();
    }

    public function getParentCategory($type) {
        if ($type !== 'category' && $type !== 'product') {
          //  $this->view->getSidebar($type, '');
        }
    }

    public function setDinamicTemplates($type) {
	$this->view->popupLocalstorageNotSupport();
        $this->view->getFooter($type);
    }

}