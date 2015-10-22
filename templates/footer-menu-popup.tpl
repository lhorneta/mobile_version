<div class="container inf-footer">
    <div class="col-md-6 form-last">
        <div class="form_product_card">
            <p>Получить консультацию у специалиста</p>
            <div class="min_form">Оставьте Ваш телефон, наш эксперт перезвонит Вам <?=$item;?> и ответит на все вопросы!</div>
            <div class="min_form_load"><img src="img/spinner.gif" width="67" height="32" alt="спиннер" title="загрузка">Идет отправка заяки...</div>
            <div class="min_form_succ">Спасибо! Наши менеджеры свяжутся с вами <?=$item;?> и ответят на все вопросы</div>
            <form class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-10">
                        <input type="hidden" value="Получить консультацию у специалиста" name="form">
                        <input type="Name" name="input_product_phone" class="form-control" id="inputEmail1" placeholder="Введите номер телефона">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default btn-product-specialist">Оставить заявку</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="bttn-footer">
        <p class="b-call">
            <span class="b-call-to-order-box">Позвоните нам <strong><a href="tel:0 (800) 210-295">0 (800) 210-295</a></strong></span>
        </p>
        <p class="b-call">
            <span class="b-call-to-order-box">Звонки со стационарных и мобильных телефонов БЕСПЛАТНО!</span>
        </p>
    </div>
    <div class="info-3g">© Интернет магазин беспроводного интернета 3GStar 2008-<?=date("Y");?></div>
    <div class="btn-home2"><a href="<?php echo 'https://3gstar.com.ua'.filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT).'?from_mobile=true';?>">Полная версия сайта</a></div>
</div>



<footer class="footer">
    <div class="toolbox-wrapper" style="position: fixed; bottom:0; z-index: 101;"> 
        <div class="toolbox"> 
            <ul class="clearfix"> 

                <li>
                    <a class="nav-toggler toggle-slide-top" rel="search" href="#text">
                        <span><img src="img/search_orig.png" width="32" height="32"></span>Поиск
                    </a>
                </li> 
                <li>
                    <a href="<?=SITE_URL.'dostavka';?>">
                        <span><img width="32" src="img/delivery-orig.png" height="32"></span>Доставка
                    </a>
                </li> 
                <li>
                    <a href="<?=SITE_URL.'oplata';?>">
                        <span class="ibm"><img src="img/payment-orig.png" width="32" height="32"></span>Оплата
                    </a>
                </li> 
                <li>
                    <a href="<?=SITE_URL.'cart';?>">
                        <span class="ibm"><img src="img/shopping-cart.png" width="32" height="32"></span>Корзина
                    </a>
                </li>
                <li>
                    <a class="tbutton" rel="phone" href="<?=SITE_URL.'contakti';?>">
                        <span><img src="img/contact_info.png" width="32" height="32"></span>Контакты
                    </a>
                </li> 
            </ul> 
        </div> 
    </div>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script defer type="text/javascript" src="<?=JS.'/all.js';?>"></script>