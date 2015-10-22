<?php

class Footer extends Controller {
    
   public $view;
    
    function __construct(){
        $this->view = new Controller_View();
    }

    public function action_index($type_content='') {
       $template = ($type_content === 'mainpage' || $type_content === 'product') ? 'footer-menu.tpl' : $this->loadTempalte();
       
       $this->view->getContent($template);
    }

    public function loadTempalte() {
        $phrase = $this->setTimeFromLeaveOrders();
        $content = ($phrase !== '') ? $phrase : '';
        $this->view->getContent('footer-menu-popup.tpl', $content);
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