<?php
class Controller{
	
    public $model;
    public $view_controller;
    public $request;
	
    function __construct()
    {
        $this->model = new Model();
        $this->view_controller = new View();
	$this->request = new Request();
    }
  
    public function load($page,$filename) {
        
        $path = $page. DS . $filename;

        if (file_exists($path) && $filename !== '') {
           $file = include($path);
	   return $file;
        }
            
    }
}