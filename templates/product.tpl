<div class="container product-cart">
    <div class="row">
        <h1><?=$item['products_name'];?></h1>
        <div id="carousel" class="carousel slide">
            <!--Индикаторы слайдов-->
            <ol class="carousel-indicators">
                <? 

                if($item["products_image_lrg"]){
                    echo '<li class="active" data-target="#carousel" data-slide="0"></li>';
                }
                for($i=1;$i<=6;$i++){
                    if($item["products_image_sm_".$i]){
                        echo '<li data-target="#carousel" data-slide="'.$i.'"></li>';
                    }
                }
                ?>
            </ol>
            <!--Слайды-->
            <div class="carousel-inner product-slader">
                <div class="item active">
                    <img 
                        src="<?="http://3gstar.com.ua/images/".$item['products_image_lrg'];?>" 
                        alt="<?=$item['products_img_title'];?>" 
                        title="<?=$item['products_img_alt'];?>"
                        width="450"
                        height="450"
                        >
                </div>
                <? for($i=1;$i<=6;$i++){

                if($item["products_image_sm_".$i]){
                echo '	<div class="item">
                <img 
                    src="http://3gstar.com.ua/images/'.$item['products_image_sm_'.$i].'" 
                    alt="'.$item['add_title_sm_1'].'"
                    title="'.$item['add_alt_sm_1'].'"
                    width="450"
                    height="450"
                >
                </div>';
                }
                } ?>

            </div>
            <!--Стрелки переключения слайдов-->
            <a href="#carousel" class="left carousel-control" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <a href="#carousel" class="right carousel-control" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
        <div class="oll-blok-infi">
            <div class="price_category">
                <div class="price noflo">
                    <p><?=round($item['products_price']);?><span> грн</span></p>
                </div>
                <div class="stars instock">
                    <p>Есть в наличии</p>
                </div>
            </div>
            <div class="button-try">
                <a 	
                    href="index.php?cart"
                    data-id="<?='3gstar_'.$item['products_id'];?>"
                    data-name="<?=$item['products_name'];?>"
                    data-description=""
                    data-image="<?="http://3gstar.com.ua/images/".$item['products_image_lrg'];?>"
                    data-price="<?=round($item['products_price']);?>"
                    data-count="1"
                    data-params=""
                    class="btn btn-success buy_button"
                    >Купить</a>
            </div>
        </div>


    </div> 
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6" id="block_width">
            <div id="accordion" class="panel-group">
                <div id="sb-arrow"></div>
                <div class="panel panel-default">

                    <a href="#collapse-1" data-toggle="collapse" class="only-acc">
                        <div class="panel-heading">
                            <h4 class="panel-title">Характеристики</h4>
                        </div>
                    </a>

                    <!--<div id="collapse-1" class="panel-collapse collapse in">-->
                    <div id="collapse-1" class="panel-collapse collapse"> 
