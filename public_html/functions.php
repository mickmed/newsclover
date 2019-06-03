<?php

//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////PRINT FUNCTIONS/////////////////////////////////////////////////

function print_main_menu($main_menu_items, $main_menu){
	 foreach($main_menu_items as $main_menu_item){
          if($main_menu_item == $main_menu){$class = 'main-menu-selected';}else{$class = 'main-menu';}?>
            <a href="?main_menu=<?php echo $main_menu_item;?>" class="<?php echo $class ?>">
              <button>
                <?php echo $main_menu_item;?><img src="img/main_menu/<?php echo $main_menu_item;?>_button.png">
              </button>
            </a><?php
          }
}

function print_sub_menu($main_menu, $countries, $select_menu_country, $languages, $select_menu_language){
	
	
}

function print_sub_menu1($category, $country, $country_value, $search, $articles, $country_key){?>
	
	<img style ="height:20px" src="http://www.geonames.org/flags/x/<?php echo $country_key;?>.gif">
	<?php 
	 echo ($articles).' articles ';
	if(!empty($search)){?> 
 		<a href="?category=<?php echo 'all';?>&country=<?php echo $country;?>&language=<?php echo '';?>">
	  	<button class="pull-right"><?php echo $search;?><img class = "button-cross" src="cross.png"></button>
	  </a>&nbsp&nbsp
  <?php }
	
	if($country !== ''){?>
	  <a href="?category=<?php echo $category;?>&country=<?php echo '';?>&language=<?php echo $language;?>">
	  	<button class="pull-right"><?php echo $country_value;?><img class = "button-cross" src="cross.png"></button>
	  </a>&nbsp&nbsp
	<?php } 	
	  	

	
	
	
	if($category !== 'all'){?>
	  <a href="?category=<?php echo 'all';?>&country=<?php echo $country;?>&language=<?php echo $language;?>">
	  	<button class="pull-right"><?php echo $category;?><img class = "button-cross" src="cross.png"></button>
	  </a>&nbsp&nbsp
	<?php }
	
	?>
	<!-- <form action="index.php" class="form-group pull-right">
    <input type="hidden" name="main_menu" value="<?php echo $main_menu; ?>">
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    
    <select  name="paginator"  onchange="this.form.submit();" id="select_paginator"> 
      <div class="paginator"><?php 
    foreach($pages as $page){
      if($page == ($offset/20)+1){$class_selected = 'page-selected';}else{$class_selected = ' ';}?>
        <a href = "?main_menu=<?php echo $main_menu;?>&sub_menu=<?php echo $sub_menu;?>&select_menu=<?php echo $select_menu;?>&page=<?php echo $page;?>">
          <div style = "padding:5px;display:inline" class = "<?php echo $class_selected;?>"><?php echo $page;?></div>
        </a><?php
    }?>
  </div>                   
    </select>
  </form> -->
  <?php
}


function printr($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function get_curl($service_url, $headers){
  $curl = curl_init($service_url);
  curl_setopt($curl, CURLOPT_URL, $service_url);
  if($headers){
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  }
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt ($ch, CURLOPT_USERAGENT, "TestScript (http://preztweets.com; mick2090@gmail.com)");
  $curl_response = curl_exec($curl);
  if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additioanl info: ' . var_export($info));
  }
  curl_close($curl);
  $sources = json_decode($curl_response, true);
  if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
      die('error occured: ' . $decoded->response->errormessage);
  }
  return($sources);
    
}


function sort_atoz($array, $key){
  foreach($array as $k => $v){
    $b[]=strtolower($v[$key]);
  }
  asort($b);
  foreach($b as $k => $v){
    $c[]=$array[$k];
  }
  return($c);
}
// function trans($trans){
  // // $trans = trans();
    // // foreach($trans as $k => $v){
      // // if($v == $_GET['top']){
        // // $target_words[] = $k;
        // // $pair=($v);
      // // }
    // // }
// }

