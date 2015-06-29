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

    function __construct() {}
     
    public function action_index() {}

    public function getUrlParameters() {

        $url = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
        
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
                    'mtc-konnekt'   => 'mtc-konnekt',
                    'mainpage'      => 'mainpage',
                    'contakti'      => 'contakti',
                    'search'        => 'search',
                    'oplata'        => 'oplata',
                    'dostavka'      => 'dostavka'
                 );

                $redirect = null;
                foreach ($params as $key => $param_type) {

                    $pos_begin = stripos($url, $param_type);
                    $parts = explode(".html", substr($url, $pos_begin));
                    $param = $parts[0];
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
                    $redirect = '' ? $this->frontController('404', '') :
                    $this->redirectTo($url_redirect);
                }
            } else {
                $this->frontController('mainpage', '');
            }
            
        }else{
            $ajax = new Ajax();
            $ajax->hendler($request->post['key']);
        }

    }

    public function redirectTo($u_param) {
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: " . FULL_SITE . $u_param . ".html");
        exit();
    }
  
    public function ajax() {
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: " . FULL_SITE . $u_param . ".html");
        exit();
    }

    public function frontController($tpl_controller, $parameters) {
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
            case "contakti": 	$type = "contakti"; break;
            case "search": 	$type = "search"; break;
            case "oplata": 	$type = "oplata"; break;
            case "dostavka": 	$type = "dostavka"; break;
            default:'';
        }

        $controllerIndex = new Controller_Index();
        $controllerIndex->indexAction($type, $parameters);
    }
}