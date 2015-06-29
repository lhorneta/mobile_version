<?php
	if(DEBUG){
	 // список разрешенных IP адресов через пробел
	   $allowed_ips = "178.150.141.203 213.179.253.130 195.69.134.33 159.224.69.125 159.224.69.205 92.113.196.115 91.247.90.247";

	   if(isset($_SESSION['start_time'])){
		   $load_time = time()-$_SESSION['start_time'];
	   }else{
		   $load_time = 'empty';
	   }
	   
	   $usage_memory = memory_get_usage();
	   $peak_memory = memory_get_peak_usage();
		
		$ips = explode(" ",$allowed_ips);
		if (array_search(filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_DEFAULT),$ips) === FALSE) {
			echo "";
		}else{?>
			<div class='debug'>
			   <div class='debug_title'>DEBUG</div> <br/>
			   <strong>Время загрузки страницы: </strong>
			   <?=$load_time;?> c <br/>
			   <strong>Используемая память:</strong><br/>
			   Начальная: <?=round($usage_memory/1000);?> Kb <br/>
			   Пиковая: <?=round($peak_memory/1000);?> Kb <br/>
			   <strong>Суперглобальные массивы:</strong><br/>
			   <strong>GET:</strong> <? var_dump($_GET);?><br/>
			   <strong>POST:</strong> <? var_dump($_POST);?><br/>
			   <strong>SESSION:</strong> <? var_dump($_SESSION);?><br/>
			   <strong>COOKIE:</strong> <? var_dump($_COOKIE);?><br/>
			   <strong>LocalStorage:</strong><br/><p class='local_debug'></p><br/>
			   <strong>REQUEST:</strong> <? var_dump($_REQUEST);?><br/>
			   <strong>SERVER:</strong> <? var_dump($_SERVER);?><br/>
			</div>
		<?php 
			$load_time = 0;
		}
	}