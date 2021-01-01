<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';
include 'functions_n.php';
include 'variables.php';

?>
<!DOCTYPE html>
<html lang="en">
	<?php include 'head.html.php';?>
	<body onload="loadDeviceSize()">
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12';
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>

		<div class="container main">
			<?php include 'header.php';?>
			<div class="container">
              	<div class="attribution">&copy2018 NewsClover Web powered by <a href =NewsApi.org>NewsApi.org</a></div>
  <!-- <iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.newsclover.com&width=450&layout=standard&action=like&size=small&show_faces=true&share=true&height=80&appId" width="450" height="80" style="border:none;overflow:hidden;height:50px" scrolling="no" frameborder="0" allowTransparency="true" ></iframe> -->
			</div>
			<div class="body-main">
				<!-------------------SUB MENU YELLOW------------------------------->
				<div class="row">


					<div class="col-xs-12 row-no-padding sub-menu pull-right hidden-sm hidden-md hidden-lg hidden-xl">
						<?php print_sub_menu_mobile($categories, $countries, $category, $country, $name);?>
					</div>

					<div class="col-sm-3 col-xs-3 row-no-padding hidden-xs">
						<div class = "sub-menu">
			    		<?php list($country_value, $country_key) = print_sub_menu($category, $countries, $country);?>
						</div>
					</div>
					<div class="col-sm-9 col-xs-9 row-no-padding hidden-xs">
						<div class = "sub-menu1">
	            		<?php print_sub_menu1($categories, $countries, $category, $country, $country_value, $search, count($articles), $country_key, $name, $url, $id);?>
				    </div>
				</div>
			</div>


			 
			  <!--------------------------SOURCE-LIST--------------------------->
 				<div class="row">
			 		<div class="col-sm-3 col-xs-3 row-no-padding">



			  	 	<div class ="row">
				  		<?php source_checkbox($category, $country, $source_type);?>
							<div class="col-sm-12 col-xs-12 row-no-padding source-list" id="menu-list">
								<div class="row">
									<?php 
									echo ($language);
									if ($source_type !== 'journalists') {
										print_news_sources($category, $country, $language, $news_sources, $name);
									} else {
										print_news_authors($category, $country, $authors, $name, $source_type);
									}
									?>
	              </div>
	            </div>
	          </div>
	        </div>

				<!----------------------------NEWS-LIST--------------------------------->

				  <div class="col-sm-9 col-xs-9 row-no-padding shoonga">


	       	  <div class="row">
	       	  	<?php
if (!empty($desc)) {
    print_news_source_description($id, $desc, $url);
    $max_height = 'max-height';
}
if (isset($_GET['author_name'])) {
    print_author_description($name);
    $max_height = 'max-height';
}
?>
	          </div>

          	<div class="row">
	          	<div class="col-sm-12 col-xs-12 row-no-padding"><?php

// print_news_articles($articles, $top_word, $max_height, $news_sources, $country_value, $category, $search, $rate_limited_message);
?>
	            </div>
        	 	</div>


        	</div>
        </div>
         <div id="footer">
		      <div class="container">
							<div class="attribution">
<div class="fb-like" data-href="http://www.newsclover.com" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
 </div>
  <!-- <iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.newsclover.com&width=450&layout=standard&action=like&size=small&show_faces=true&share=true&height=80&appId" width="450" height="80" style="border:none;overflow:hidden;height:50px" scrolling="no" frameborder="0" allowTransparency="true" ></iframe> -->



		      </div>
		    </div>
      </div>
		</div>
  </body>
</html>










<script>
$(function() {
	$('#webTicker').webTicker({
		height:'40px'
	});
});






//js for loading menu list to previously selected
// $(function() {
   // $(window).unload(function() {
      // var scrollPosition = $("ul.news-list").scrollTop();
      // localStorage.setItem("scrollPosition", scrollPosition);
   // });
   // if(localStorage.scrollPosition) {
      // $("ul.news-list").scrollTop(localStorage.getItem("scrollPosition"));
   // }
// });


$(function() {
	lang = <?php echo json_encode($language); ?>;
	$('#select_menu_language').val(lang);
});



$(document).ready(function() {
  function setHeight() {
    windowHeight = ($(window).innerHeight())-150;
    $('.news-source-list').css('min-height', windowHeight);
  };
  setHeight();

  $(window).resize(function() {
    setHeight();
  });
});

$(document).ready(function() {
  function setHeight() {
    windowHeight = ($(window).innerHeight())-150;
    $('.news-articles').css('min-height', windowHeight);
  };
  setHeight();

  $(window).resize(function() {
    setHeight();
  });
});

$(document).ready(function() {
  function setHeight() {
    windowHeight = ($(window).innerHeight())-80;
    $('.main').css('min-height', windowHeight);
  };
  setHeight();

  $(window).resize(function() {
    setHeight();
  });
});

</script>





















