<?php

class Response {

    public function redirect($url) {
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $url);
        exit;
    }

    public function error($url) {
        header('HTTP/1.0 404 Not Found');
        header('Location: ' . $url);
        exit;
    }

    public function getUrl() {
        return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
    }

    public function getHttpReferer() {
        return filter_input(INPUT_SERVER, 'HTTP_REFERER');
    }

    public function getHttps() {
        return filter_input(INPUT_SERVER, 'HTTPS');
    }
           
    public function getServerPort() {
        return filter_input(INPUT_SERVER, 'SERVER_PORT');
    }
    
    public function getUserIp() {
        return filter_input(INPUT_SERVER, 'REMOTE_ADDR');
    }
    
    public function getServerName() {
        return filter_input(INPUT_SERVER, 'SERVER_NAME');
    }

    public function trim($url) {
        $trim = array("index.php?","/","?");
        return str_replace($trim,"",$url);
    }

    public function findChar($url) {
        $pos = strpos($url, "?");
        
        $poss = strpos($url, "index.php");
        $posss = strpos($url, "index.php?");
        if($pos || $poss || $posss){return $pos;}
    }
  
    public function redirectToMainSite() {
        $this->redirect(FULL_SITE.$this->trim($this->getUrl())."?from_mobile=true");
    }
    
    public function curPageUrl() {
        $pageURL = 'http';
        if ($this->getHttps() == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ( $this->getServerPort() !== "80") {
            $pageURL .= $this->getServerName() . ":" . $this->getServerPort() . $this->getUrl();
        } else {
            $pageURL .= $this->getServerName() . $this->getUrl();
        }
        return $pageURL;
    }
   
}