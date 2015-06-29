
                        <!--<table id="tab13" border="1" cellspacing="0" style="border-color: #FFFFFF;">
                            <tbody>
                                <tr>
                                    <td class="one_b"><img src="img/one.jpg" width="56" height="48"></td>
                                    <td class="two_b"><span>С каким оператором будет работать этот модем?</span>
                                        <p>EVDO Rev. A до 3,1 мбит/с (Интертелеком, PeopleNet), EDGE до 240 кбит/с (Киевстар, МТС, Life), HSDPA - это надстройка над сетью 3G (UMTS), HSUPA до 7,2 мбит/с (Тримоб, он же Utel или Ого)</p></td>
                                </tr>

                                <tr>
                                    <td class="one_b"><img src="img/operating-system.jpg" width="56" height="48"></td>
                                    <td class="two_b"><span>С какими операционными системами работает?</span>
                                        <p>Совместим со всеми устройствами (планшетами, смартфонами, ноутбуками), которые работают по wi-fi (ОС Windows, Android, IOS). По usb с ОС Windows (32 и 64)</p></td>
                                </tr>

                                <tr>
                                    <td class="one_b"><img src="img/emkost-akkymylyatora.jpg" width="56" height="48"></td>
                                    <td class="two_b"><span>Какая емкость аккумулятора?</span>
                                        <p>1500 mAh - 5 часов автономной работы</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="one_b"><img src="img/under-antenna.jpg" width="56" height="48"></td>
                                    <td class="two_b"><span>Есть ли выход под внешнюю антенну?</span>
                                        <p>Роутер содержит выход под внешнюю антенну</p></td></tr>

                                <tr>
                                    <td class="one_b"><img src="img/skolko-polzovatelei.jpg" width="56" height="48"></td>
                                    <td class="two_b"><span>Сколько пользователей можно подключить одновременно?</span>
                                        <p>
                                            до 10 устройств по wi-fi и 1 устройство по usb
                                        </p></td>
                                </tr>

                                <tr>
                                    <td class="one_b"><img src="img/rabota-usb.jpg" width="56" height="48"></td>
                                    <td class="two_b"><span>Работает по usb кабелю?</span>
                                        <p>Работает по usb с ОС Windows (32 и 64 разрядными системами)</p></td>
                                </tr>

                                <tr>
                                    <td class="one_b"><img src="img/benefits.jpg" width="56" height="48"></td>
                                    <td class="two_b"><span>Преимущества!</span>
                                        <p>Обладает мощной внутренней начинкой, позволяет работать автономно более 5 часов, на передней панели роутер оснащен экраном и удобным функциональным меню</p></td>
                                </tr>


                                <tr>
                                    <td class="one_b"><img src="img/expert-opinion.jpg" width="56" height="48"></td>
                                    <td class="two_b"><span>Мнение специалиста!</span>
                                        <p>Устройство работает во всех странах мира и со всеми операторами. Рекомендуется для активных людей, которые любят путешествовать и часто бывают  в командировках</p></td>
                                </tr>


                            </tbody>
                        </table>-->
                    </div>

                </div>


                <div class="panel panel-default">

                    <a href="#collapse-2" data-toggle="collapse" class="only-acc">
                        <div class="panel-heading">
                            <h4 class="panel-title">Краткое описание</h4>
                        </div>
                    </a>
                    <div id="collapse-2" class="panel-collapse collapse">
                        <div class="content-description">
                            <?php 
                            $products_description = str_replace(array("/images","https://3gstar.com.uahttp://3gstar.com.ua/images"), "http://3gstar.com.ua/images",$item['products_description']);
                            echo $products_description;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">

                    <a href="#collapse-3" data-toggle="collapse" class="only-acc">	<div class="panel-heading">
                            <h4 class="panel-title">
                                Отзывы покупателей
                            </h4>
                        </div>
                    </a>	
                    <div id="collapse-3" class="panel-collapse collapse">
                        <ul id="commentRoot">