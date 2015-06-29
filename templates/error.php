<?

session_start();

$link = substr($_SESSION['parent_category']['link'], 1);
header("HTTP/1.1 301 Moved Permanently");
header("Location: https://3gstar.com.ua/".$link);

exit();
unset($_SESSION['link']); 