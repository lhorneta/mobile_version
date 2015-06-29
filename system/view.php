<?php

class View {
     
    public function checkPathIncude($tpl, $item) {

        $path = TEMPLATE_PATH . DS . $tpl;

        //echo "<br/>TEMPLATE ".$path."<br/>";

        if ($tpl === 'sidebar-menu.tpl') {
            if (file_exists($path) && $tpl !== '') {
                include_once($path);
            }
        } else {
            if (file_exists($path) && $tpl !== '') {
                include($path);
            } else {
                //	echo "no such tpl";
            }
        }
    }

    public function doHeader($template, $content) {
        $this->checkPathIncude($template, $content);
    }

    public function doDisplay($template, $content) {

        if ($content) {
            if (is_array($content)) {
                foreach ($content as $key => $items) {
                    $this->checkPathIncude($template, $items);
                }
            } else {
                $this->checkPathIncude($template, $content);
            }
        } else {
            $this->checkPathIncude($template, '');
        }
    }

    public function doFooter($template) {
        $this->checkPathIncude($template, '');
    }

    public function do404($template) {
        $this->checkPathIncude($template, '');
    }

    public function localstorageNotSupport($template) {
        $this->checkPathIncude($template, '');
    }
}