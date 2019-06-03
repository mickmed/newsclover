<?php
	include 'functions.php';
  include 'functions_n.php';
	include 'variables.php';
	
?>						  	
<!DOCTYPE html>
<html lang="en">
	<head><?php include 'head.html.php';?></head>
	<body onload="loadDeviceSize()">
		<div class="container main">	
		<?php include 'header.php';?>
			<div class="body-main">
		  <!--///////////////SUB MENU YELLOW///////////////////////////////----->
		  
			<div class="row"><?php 
			//  echo $main_menu;
			 if($main_menu == 'news'){?>
  			<div class="col-sm-3 col-xs-3 row-no-padding"><?php
  		 }
       ?>
  		  
  			  
    		  <div class = "sub-menu">
    		  
    		   	<form action="index.php" class="form-group">
					    <input type="hidden" name="main_menu" value="<?php echo $main_menu; ?>">
					    <input type="hidden" name="category" value="<?php echo $category; ?>">
					    
					    <select  name="country"  onchange="this.form.submit();" id="select_menu_country"> 
					      <?php 
					    
					      foreach($countries as $k=>$v){?>
					        <option <?php if($country == $k){echo 'selected="selected"';$country_value=$v;$country_key = $k;}?> value=<?php echo $k;?>><?php echo $v;?></option> 
					        	<?php
					      }
					      ?>                     
					    </select>
    
   
					    <!-- <select name="language"  onchange="this.form.submit();" id="select_menu_language">
					      <?php foreach($languages as $k=>$v){?>
					        <option <?php if($language == $k){echo 'selected="selected"'; $lang=$v;}?> value=<?php echo $k;?>><?php echo $v;?></option><?php
					      }?>                     
					    </select> -->
					  </form>
					   <form action="" class="source_type">
            		<input type="hidden" name="main_menu" value="<?php echo $main_menu; ?>">
				    		<input type="hidden" name="category" value="<?php echo $category; ?>">
				    		<input type="hidden" name="country" value="<?php echo $country; ?>">
				   			<input type="hidden" name="language" value="<?php echo $language; ?>">
				    	
							<?php /* ?>
							$source_type=="journalists") echo "checked"; ?>
							  value="journalists" onchange="this.form.submit();"> journalists
								</div>
							<?php */ ?>
							</form>
					</div>
		  		
		  		
		  		
		  		<div class ="row">
						
				      <!--------------------------MENU-LIST--------------------------->
             
					
              <div class="pre-scrollable col-sm-12 col-xs-12 row-no-padding pre-scrollable-news-list" id="menu-list">
              	
                <?php 
                 if($main_menu == 'news'){
                 	//printr($news_sources);
                  if($source_type !== 'journalists'){
                    print_news_sources($main_menu, $category, $country, $language, $news_sources, $id);
                  }else{
                    print_news_authors($main_menu, $category, $country, $authors, $name, $source_type);
                  }
                }
                ?> 
              </div>
            	
  				</div>
				</div>
				    
				<!-- /////////////////////////////////////////////// NEWS PRINT/////////////////////////////////-->
			 <?php

       if($main_menu == 'news'){?>
        <div class="col-sm-9 col-xs-9 row-no-padding">
        <div class = "sub-menu1">
        	<?php print_sub_menu1($category, $country, $country_value, $search, count($articles), $country_key);?>
			  </div>
			  <?php
       }?>
      <div class="row"><?php
          if($main_menu == 'news'){
            if(!empty($desc)){
              print_news_source_description($id, $desc, $url);
              $news_articles_class = 'pre-scrollable-news-articles';
            }
					
              print_news_articles($main_menu, $articles, $top_word, $news_articles_class, $news_sources);
          }
          
         
            //include 'counter.php';?>
          </div></div> 
			  </div>
		  </div>
	  
   



                
		<!--Footer-->
		<!-- <footer class="page-footer blue center-on-small-only">
		  <div class="container-fluid">
		    <div class="row">
		 		  <div class="col-md-12">
		        <ul id="webTicker" style="padding-left:40px;"><li><?php
							foreach($articles as $article){?>
				    		<a target="_blank" href = "<?php echo $article['url'];?>"><?php echo($article['title']).' - '.$article['source'].'&nbsp&nbsp&nbsp&nbsp';?></a><?php
							}?></li>
						</ul>
		      </div>
		    </div>
		    <!--Copyright-->
		    <!-- <div class="footer-copyright">
		      <div class="container-fluid">
		        © 2015 Copyright: <a href="https://www.NewsClover.com"> NewsClover.com </a>
		        
		      </div>
		    </div>
		    <!--/.Copyright-->
			<!-- </div>
		</footer>  --> 
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
// 
// $(function() {
	// count = <?php echo json_encode($count); ?>;
	// $('#select_menu_country').val(count);
// });

 










</script>





















