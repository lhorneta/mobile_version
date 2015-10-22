<!--lhornet 3 prices-->
<?php
    $allowed_ips = "109.87.26.240 85.90.219.158 159.224.69.113 178.150.141.203 213.179.253.130 195.69.134.33 159.224.69.125 159.224.69.205 92.113.196.115 91.247.90.247";

    $ips = explode(" ",$allowed_ips);
    if (array_search(filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_DEFAULT),$ips) === FALSE) {
    echo "";
}else{
?>
    <div class="panel panel-default">

        <a 
            href="#collapse-p<?=$i;?>" 
            data-toggle="collapse"
            class="only-acc collapsed" 
            data-attr-price="<?=round($item['options_values_price']);?>" 
            data-attr-name="<?=$item['products_options_values_name'];?>" 
            data-attr-option-name="<?=$item['products_options_name'];?>" 
            data-attr-prefix="<?=$item['price_prefix'];?>" 
            data-attr-id="<?=$item['products_id'];?>" 
        >
            <div class="panel-heading">

                <input type='radio' name='custom_price' <? if($item['options_values_price']==0){echo "checked='checked'";}?> class="custom_input_radio" value='' id='price<?=$i;?>'>
                <div class="custom_radio"></div>
                <label for="price<?=$i;?>"><h4 class="panel-title"><?=round($item['options_values_price']);?> грн - <span class="option_name_custom"><?=$item['products_options_values_name'];?></span></h4></label>
            </div>
        </a>
        <div id="collapse-p<?=$i;?>" class="panel-collapse collapse"><?=$item['products_options_description'];?></div>

    </div>
			
<div class="oll-blok-infi btn-home2">
    <div class="price_category_custom">
        <div class="price noflo">
            <p class="price price-custom"><?=round($item['products_price']);?><span class="price-custom"> грн</span></p>
        </div>
        <div class="stars instock">
            <p>Есть в наличии</p>
        </div>
    </div>
    <div class="button-try-custom">
        <a 	
            href="cart"
            class="btn btn-success buy_button"
            data-id="<?='3gstar_'.$item['products_id'];?>"
            data-name="<?=$item['products_name'];?>"
            data-image="<?=FULL_SITE.'images/'.$item['products_image_lrg'];?>"
            data-price="<?=round($item['products_price']);?>"
            data-count="1"
            data-description="<?=$item['products_options_name'];?>"
            data-params='[
                {"option_price":"<?=round($item['options_values_price']);?>"},
                {"option_name":"<?=$item['products_options_values_name'];?>"},
                {"option_prefix":"<?=$item['price_prefix'];?>"},
                {"option_id":"<?=$item['products_id'];?>"}
            ]'
        >
            Купить
        </a>
    </div>
</div>
    <?php } ?>

<!--end lhornet 3 prices-->