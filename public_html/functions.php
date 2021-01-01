<?php

/////////////////////////////PRINT FUNCTIONS/////////////////////////////////////////////////

function print_sub_menu($category, $countries, $country)
{?>
	<form class="hidden-xs" action="index.php" class="form-group">
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <select   name="country"  onchange="this.form.submit();" id="select_menu_country">
      <?php foreach ($countries as $k => $v) {?>
        <option <?php if ($country == $k) {echo 'selected="selected"';
    $country_value = $v;
    $country_key = $k;}?> value=<?php echo $k; ?>><?php echo $v; ?></option>
      <?php
}?>
    </select>
		<?php if (!empty($country)) {?>
			<img class="flag" src="http://www.geonames.org/flags/x/<?php echo $country_key; ?>.gif">
		<?php
}?>
	</form>
	<?php
return [$country_value, $country_key];
}

function print_sub_menu1($categories, $countries, $category, $country, $country_value, $search, $articles, $country_key, $name, $url, $id)
{?>
	<div style="margin-top:5px;display:inline-block"><?php echo ($articles) . ' articles '; ?></div>
		<div class="hidden-xs buttons">
			<?php
if (!empty($search)) {?>
	 		<a href="?category=<?php echo $category; ?>&country=<?php echo $country; ?>&name=<?php echo $name; ?>&url=<?php echo $url; ?>&id=<?php echo $id; ?>">
		  	<button class="pull-right"><?php echo urldecode($search); ?><img class = "button-cross" src="cross.png"></button>
		  </a>&nbsp&nbsp
		 <?php }

    if (!empty($name)) {?>
	 		<a href="?category=<?php echo $category; ?>&country=<?php echo $country; ?>&name=&url=>&id=">
		  	<button class="pull-right"><?php echo $name; ?><img class = "button-cross" src="cross.png"></button>
		  </a>&nbsp&nbsp
		 <?php }
    if ($category !== 'all') {?>
	  <a href="?category=<?php echo 'all'; ?>&country=<?php echo $country; ?>&name=&url=>&id=">
	  	<button class="pull-right"><?php echo $category; ?><img class = "button-cross" src="cross.png"></button>
	  </a>&nbsp&nbsp
	<?php }

    if ($country !== '') {?>
	  <a href="?category=<?php echo $category; ?>&country=&name=&url=&id=">
	  	<button class="pull-right hidden-xs"><?php echo $country_value; ?><img class = "button-cross" src="cross.png"></button>
	  </a>&nbsp&nbsp
	<?php }

    ?>
	</div>

	<!-- <form action="index.php" class="form-group pull-right">
    <input type="hidden" name="main_menu" value="<?php echo $main_menu; ?>">
    <input type="hidden" name="category" value="<?php echo $category; ?>">

    <select  name="paginator"  onchange="this.form.submit();" id="select_paginator">
      <div class="paginator"><?php
foreach ($pages as $page) {
        if ($page == ($offset / 20) + 1) {$class_selected = 'page-selected';} else { $class_selected = ' ';}?>
        <a href = "?main_menu=<?php echo $main_menu; ?>&sub_menu=<?php echo $sub_menu; ?>&select_menu=<?php echo $select_menu; ?>&page=<?php echo $page; ?>">
          <div style = "padding:5px;display:inline" class = "<?php echo $class_selected; ?>"><?php echo $page; ?></div>
        </a><?php
}?>
  </div>
    </select>
  </form> -->
  <?php
}

function print_sub_menu_mobile($categories, $countries, $category, $country, $name)
{?>

	echo $categories, $countries
	<form action="index.php">
    <input type="hidden" name="country" value="<?php echo $country ?>">
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <select  name="category"  onchange="this.form.submit();" id="select_menu_category">
      <?php foreach ($categories as $v) {?>
        <option <?php if ($category == $v) {echo 'selected="selected"';}?> value=<?php echo $v; ?>><?php echo $v; ?></option>
      <?php
}?>
    </select>
    <select  name="country"  onchange="this.form.submit();" id="select_menu_country">
      <?php foreach ($countries as $k => $v) {?>
        <option <?php if ($country == $k) {echo 'selected="selected"';
    $country_value = $v;
    $country_key = $k;}?> value=<?php echo $k; ?>><?php echo $v; ?></option>
      <?php
}?>
    </select>

		<?php
if (!empty($name)) {?>
			<a href="?category=<?php echo $category; ?>&country=<?php echo $country; ?>&name=<?php echo ''; ?>&url=<?php echo $url; ?>&id=<?php echo $id; ?>">
	  	<button><?php echo $name; ?><img class = "button-cross" src="cross.png"></button>
	  </a>&nbsp&nbsp
		<?php	}?>
  </form> <?php
}

function print_filters_mobile($name)
{

    echo $name;

    if (!empty($search)) {?>
	 		<a class="hidden-xl hidden-lg hidden-md" href="?category=<?php echo 'all'; ?>&country=<?php echo $country; ?>&name=<?php echo $name; ?>&url=<?php echo $url; ?>&id=<?php echo $id; ?>">
		  <button class="pull-right"><?php echo urldecode($search); ?><img class = "button-cross" src="cross.png"></button>
		  </a>&nbsp&nbsp
		<?php }

    echo $name;

}

function source_checkbox($category, $country, $source_type)
{?>
    <form action="" class="source-type">

      <input type="hidden" name="category" value="<?php echo $category; ?>">
      <input type="hidden" name="country" value="<?php echo $country; ?>">


      <div class="checkbox-script pull-right">journalists&nbsp<input type="checkbox" name="source_type"
      <?php if (isset($source_type) && $source_type == "journalists") {
    echo "checked";
}
    ?>
      value="journalists" onchange="this.form.submit();"> </div>

    </form>

  <?php
}

function printr($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function get_curl($service_url, $headers)
{
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_URL, $service_url);
    if ($headers) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, "TestScript (http://preztweets.com; mick2090@gmail.com)");
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
    return ($sources);

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
