<? if($item){?>
<li id="comment'<?=$item['id'];?>'">
	<div class="commentContent">
		<img src="img/knopka.png" width="29" height="30" alt="knopka" title="кнопка комментариев">
		<div class="clear"></div>
		<span class="nickcomment"><?=$item['name'];?></span>
		<span><?=mb_strtolower($item['date_add']);?></span>
		<div class="comment"><?=$item['comment'];?></div> 
	</div>
 </li>
 <?}else{?>
 <li id="comment">
	<div class="commentContent">
		<img src="img/knopka.png" width="29" height="30" alt="knopka" title="кнопка комментариев>
		<div class="clear"></div>
		<span class="nickcomment"></span>
		<span></span>
		<div class="comment">Пока нет отзывов на данный товар</div> 
	</div>
 </li>
 <?}?>