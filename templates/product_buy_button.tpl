            </div>
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
            href="cart"
            class="btn btn-success buy_button"
            data-id="<?='3gstar_'.$item['products_id'];?>"
            data-name="<?=$item['products_name'];?>"
            data-image="<?=FULL_SITE.'images/'.$item['products_image_lrg'];?>"
            data-price="<?=round($item['products_price']);?>"
            data-count="1"
            data-description=""
            data-params=""
        >
            Купить
        </a>
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

                    <a href="#collapse-1" data-toggle="collapse" class="only-acc collapsed">
                        <div class="panel-heading">
                            <h4 class="panel-title">Характеристики</h4>
                        </div>
                    </a>
                    <div id="collapse-1" class="panel-collapse collapse">