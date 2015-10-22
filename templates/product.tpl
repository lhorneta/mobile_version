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
            <div class="carousel-inner-product product-slader">
                <div class="item active">
                    <img 
                        src="<?=FULL_SITE.'images/'.$item['products_image_lrg'];?>" 
                        alt="<?=$item['products_img_title'];?>" 
                        title="<?=$item['products_img_alt'];?>"
                        width="450"
                        height="450"
                        >
                </div>
                <? for($i=1;$i<=6;$i++){

                if($item["products_image_sm_".$i]){
                echo '<div class="item">
                <img 
                    src="'.FULL_SITE.'images/'.$item['products_image_sm_'.$i].'" 
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
        <div class="col-md-6 custom-price-block" id="block_width">
            <div id="accordion" class="panel-group">