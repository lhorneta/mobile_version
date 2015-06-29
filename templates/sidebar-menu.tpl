<?php
//11.06.2015 Чижевский Михаил (Циклические ссылки)
include_once 'helpers/helper_menu_mob.php';          //подключение массива ссылок и шаблонов 
// $SMA - это массив всех ссылк.        
?> 
<!--  шапка + меню -->
<div id="place-holder">

    <div class="header"><?=$item;?></div>
    <nav id="menu">
        <ul>
            <?php
            
                $catalog_url = $_SERVER['REQUEST_URI'];
                $html="";
                    foreach ($SMA as $key => $title) {
                        $html .="<li><a href ='#router'>".$name_cat[$key]."</a><ul>";
                        foreach ($title as $value) {
                            if($value['url'] === $catalog_url){
                                $html .= "<li><span>".$value['text']."</span></li>";
                            }else{
                                $html .= "<li><a href='".$value['url']."'>".$value['text']."</a></li>";
                            }
                        }
                        $html .= "</ul></li>";
                    }
                //Еще один костыль
                if('/?Stati-posvjaschennye-internetu-t-2.html' === $catalog_url){
                    $html .= "<li><span>Статьи</span></li>";
                }else{
                    $html .= "<li><a href='/?Stati-posvjaschennye-internetu-t-2.html'>Статьи</a>";
                }
                echo $html;
            ?>   
        </ul>
    </nav>
</div><!--  end шапка + меню -->