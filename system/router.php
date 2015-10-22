<?php

class Router {

    /*
     * @string
     * @url address
     */
    public $url;

    /*
     * @string
     * @url param
     */
    public $param;

    /*
     * @string
     * @url param
     */
    public $param_type;

    /*
     * @array
     * @url params
     */
    public $params;

    /*
     * @string
     * @url parameters
     */
    public $parameters;

    /*
     * @string
     * @url type of content
     */
    public $type;

    function __construct() {
        $this->response = new Response();
    }
     
    public function action_index() {}

    public function getUrlParameters() {

        $url = $this->response->getUrl();

        if($this->response->findChar($url)>0){
            $this->response->redirect(SITE_URL.$this->response->trim($url));
        }
 
        $request = new Request();
           
        if(!isset($request->post['key'])){

            if ($url !== '/') {
                $params = array(
                    'category'      => '-c-',
                    'product'       => '-p-',
                    'article'       => '-a-',
                    'undefined'     => '-pi-',
                    'template'      => '-t-',
                    'tarifi'        => 'tarifi',
                    'pokritie'      => 'pokritie',
                    'cart'          => 'cart',
                    'utm'           => 'utm_source',
                    'gclid'         => 'gclid',
                    'mtc-konnekt'   => 'mtc-konnekt',
                    'mainpage'      => 'mainpage',
                    'contakti'      => 'contakti',
                    'search'        => 'search',
                    'oplata'        => 'oplata',
                    'dostavka'      => 'dostavka',
                    'otzivi'        => 'otzivi'
                 );

                $redirect = null;
                foreach ($params as $key => $param_type) {

                    $pos_begin = stripos($url, $param_type);
                    $parts = explode(".html", substr($url, $pos_begin));
                    $param = $parts[0];
                    //var_dump($param);
                    if ($pos_begin !== false) {
                        $this->frontController($key, $param);
                        $redirect .= $param;
                        break;
                    } else {
                        $redirect .= '';
                    }
                }
                if ($redirect === '') {
                    $url_redirect = substr($param, 2);
                    $redirect = '' ? $this->frontController('404') :
                    $this->response->redirect(FULL_SITE.$url_redirect.'.html');
                }
            } else {
                $this->frontController('mainpage');
            }
            
        }else{
            $ajax = new Ajax();
            $ajax->hendler($request->post['key']);
        }

    }

    public function frontController($tpl_controller, $parameters='') {
       // echo "<p>tpl_controller: ".$tpl_controller." ".$parameters."</p>";
        
        switch ($tpl_controller) {
	    //templates
            case "category": 	$type = "category"; break;
            case "product": 	$type = "product"; break;
            case "article": 	$type = "article"; break;
            case "tarifi": 	$type = "tarifi"; break;
            case "pokritie": 	$type = "pokritie"; break;
            case "mtc-konnekt": $type = "mtc-konnekt"; break;
            case "undefined": 	$type = ""; break;
            case "template": 	$type = "template"; break;
            case "mainpage": 	$type = "mainpage"; break;
            case "404": 	$type = "404"; break;
            //static pages
            case "cart": 	$type = "cart"; break;
            case "utm": 	$type = "utm_source"; break;
            case "gclid": 	$type = "gclid"; break;
            case "contakti": 	$type = "contakti"; break;
            case "search": 	$type = "search"; break;
            case "oplata": 	$type = "oplata"; break;
            case "dostavka": 	$type = "dostavka"; break;
            case "otzivi": 	$type = "otzivi"; break;
            default:'';
        }

        $controllerIndex = new Controller_Index();
        $controllerIndex->indexAction($type, $parameters);
    }
}