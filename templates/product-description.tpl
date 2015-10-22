</div>

</div>

<div class="panel panel-default">

    <a href="#collapse-2" data-toggle="collapse" class="only-acc collapsed">
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
    <a href="#collapse-3" data-toggle="collapse" class="only-acc collapsed">	
        <div class="panel-heading">
            <h4 class="panel-title">
                Отзывы покупателей
            </h4>
        </div>
    </a>	
    <div id="collapse-3" class="panel-collapse collapse">
        <ul id="commentRoot">