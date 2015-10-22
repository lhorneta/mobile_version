<?php

class Ajax {

    public $request;
    public $http;
     
    
    function __construct(){
        $this->request = new Request();
    }
    
    
    public function hendler($http){
        
        switch ($http['data']){
            case 'pagination':
                $limit_start = $http['count'];
                $limit_end = ITEM_TO_CATEGORY + $limit_start;
                $pagination = new Pagination();
                $pagination->init($http['id'],$limit_start,$limit_end,$http['data']);
                break;
        }
    }
}