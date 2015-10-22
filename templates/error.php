<?php

session_start();

$link = substr($_SESSION['parent_category']['link'], 1);
header("HTTP/1.1 301 Moved Permanently");
if($link){
    
    header("Location: https://3gstar.com.ua/".$link."?from_mobile=true");
 }
else{
    header("Location: https://3gstar.com.ua/".substr(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT), 1)."?from_mobile=true");
    
}

exit();
unset($_SESSION['link']); 