<a href="<?="index.php?".substr($item['link'], 1);?>">
   <div class="card-blocks">

        <div class="container">
            <div class = "row abz-hone">
                <div class="col-xs-4">
                    <img  src="<?="http://3gstar.com.ua/images/".$item['products_image'];?>" 
                          alt="<?=$item['products_img_title'];?>" 
                          title="<?=$item['products_img_alt'];?>"
                          width="175"
                          height="175"
                          class="img-responsive">
                </div>
                <div class="col-md-8"> 
                    <div class="name-cart"><?=$item['products_name'];?></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="stars">
                                <!--<div class="rating">
                                        <div class="rating_sum" style="<?
                                                /*$rating_num = ($item['rating']*100)/5;
                                                $width = (125*$rating_num)/100;
                                                echo "width:".$width."px;";*/
                                        ?>"></div>
                                </div>-->
                                <!--<img src = "img/rating_star.gif">-->
                                <p>Есть в наличии</p>
                            </div>
                            <div class="price">
                                <p><?=round($item['products_price']);?><span> грн</span></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>	
</a>