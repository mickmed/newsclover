<?php

$main_menu_items = ['news'];
$main_menu = 'news';
if(isset($_GET['main_menu'])){
	$main_menu = $_GET['main_menu'];
}
//echo $_GET['search'];


$pages = [1,2,3,4,5,6,7,8,9,10];
  
  $page = 1;
  if(isset($_GET['page'])){
    $page = $_GET['page'];
  }
  
  $offset = ($page*20)-20;





/////////////////////////////////GET NEWS///////////////////////////////////////////////
if($main_menu == 'news'){
  include 'news_sources_icons.php';
  
	$source_type = 'sources';
 	if(isset($_GET['source_type'])){
 		$source_type = $_GET['source_type'];
 	}

	////////////categories///////////	
  $categories = ['all', 'general', 'business', 'health/science', 'technology', 'entertainment', 'sports'];   
    $category = 'general';
    if(isset($_GET['category'])){
      $category = $_GET['category'];
    } 
    //echo $select_menu;
    if($category == 'all'){
      $category = '';
			
    }
			
			
	  ////////////countries/////////////
		$countries = [''=>'world', 'gb'=>'united_kingdom', 'us'=>'united states', 'ar'=>'argentina', 'au'=>'australia', 'br'=>'brazil', 'ca'=>'canada', 'cn'=>'china', 'fr'=>'france', 'de'=>'germany', 'hk'=>'hong_kong', 'in'=>'india', 'ie'=>'ireland', 'il'=>'israel', 'it'=>'italy', 'nl'=>'netherlands', 'no'=>'norway', 'ru'=>'russia', 'sa'=>'saudia_arabia', 'za'=>'south_africa', 'es'=>'spain', 'se'=>'sweden'];
		
		$country = 'us';
	  if(isset($_GET['country'])){
	    $country = $_GET['country'];
	  } 
		
		
		////////////////languages///////////
		$languages = [''=>'all languages', 'en'=>'english', 'ar'=>'arabic', 'zh'=>'chinese','nl'=>'dutch', 'de'=>'german', 'fr'=>'french', 'he'=>'hebrew', 'it'=>'italian', 'no'=>'norwegian',  'pt'=>'portugese', 'ru'=>'russian',	'es'=>'spanish', 'se'=>'sweden', 'ud'=>'urdu'];
	  //$language = 'en';
	  if(isset($_GET['language'])){
	    $language = $_GET['language'];
		} 
	
	
	if(isset($_GET['search'])&&$category !== 'advanced'){
  	$search = ($_GET['search']);
		// $category='all';
		// $country='';
		// $language='';
  	// list($articles) = get_articles_keyword($search, '', '');
// 		
	}
	
	
	if($source_type == 'journalists'){
				
    if($category == "health/science"){
			$news_sources_health = get_news_sources('health', $country, $language);
		  $news_sources_science = get_news_sources('science', $country, $language);
			$news_sources = array_merge($news_sources_health['sources'], $news_sources_science['sources']);
		}else{
			$news_sources = get_news_sources($category, $country, $language);
			$news_sources = $news_sources['sources'];
		}

		foreach($news_sources as $news_source){
				$news_sources_ids[]=($news_source['id']);
			}
			$news_sources_ids = (implode(",", $news_sources_ids));
		  $articles = get_articles($news_sources_ids, $search);
		  $authors = get_authors($articles); 
		   
	    if(isset($_GET['author_name'])){
	      $name = $_GET['author_name'];
	      $id = $_GET['id'];
	      $articles = get_articles_author($articles, $name);
				
	    }
  	}else{
			if($category == "health/science"){
				$news_sources_health = get_news_sources('health', $country, $language);
			  $news_sources_science = get_news_sources('science', $country, $language);
				$news_sources = array_merge($news_sources_health['sources'], $news_sources_science['sources']);
			}else{
				$news_sources = get_news_sources($category, $country, $language);
				$news_sources = $news_sources['sources'];
				//printr($news_sources);
			}
	
			if(isset($_GET['id'])){
				$id = $_GET['id'];
			  $desc = $_GET['desc'];
				$url = $_GET['url'];
				$articles = get_articles($id, $search, $category, $country);
			}else{
			  $name = '';
			  $id = '';
			  $desc = '';
				foreach($news_sources as $news_source){
					$news_sources_ids[]=($news_source['id']);
				}
				$news_sources_ids = (implode(",", $news_sources_ids));
			//	printr($news_sources_ids);
			  $articles = get_articles($news_sources_ids, $search, $category, $country);
				//printr($articles);
		
			}
		}


	
	$articles = sort_news_atoz($articles, ('publishedAt'));
	//printr($articles);
  $articles = array_reverse($articles);  
	
	if($category == ''){
		$category = 'all';
	}
		
	
		
	
}		
		
