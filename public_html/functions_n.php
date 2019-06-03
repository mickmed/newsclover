<?php

///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////NEWS STUFF////////////////////////////////////////////
function get_news_source($news_sources, $id){
	//printr($news_sources);
  foreach($news_sources as $news_source){
    if($id == $news_source['id']){
      $source[] = $news_source;
      
    }
  } 
	//printr($source);
  return $source;
}


function get_news_sources($category, $country, $language){
  
  $news_sources = get_curl('https://newsapi.org/v2/sources?language='.$language.'&country='.$country.'&category='.$category.'&apiKey=9b2e87cd02c24b0b9f38ab7fb6d56a55','');
  return $news_sources;
}


// function get_articles_keyword($keyword, $category, $country){
// 
	// $news_sources_temp = get_news_sources('','','');
	// $articles_groups = [get_curl('https://newsapi.org/v2/top-headlines?sources=bbc-news&q='.$keyword.'&pageSize=100&apiKey=44e5ca1e7d1d461bbfc466448884c1c9')];
// 
	// foreach($articles_groups[0]['articles'] as $article_group){
		// $articles[] = $article_group;
	// }
	// //printr(array_unique($news_sources, SORT_REGULAR));
	// //printr($articles);
	// return [$articles];
// 	
// }	

function get_articles($news_sources_ids, $category, $country){
  // printr($news_sources_ids);
	$articles_groups = get_curl('https://newsapi.org/v2/top-headlines?sources='.$news_sources_ids.'&apiKey=9b2e87cd02c24b0b9f38ab7fb6d56a55', '');
 	// printr($articles_groups[articles]);
	
  foreach($articles_groups['articles'] as $article_group){
  	$articles[] = $article_group;
  }
  // printr($articles[0]);
	
	$articles_groups1= get_curl('https://newsapi.org/v2/top-headlines?country='.$country.'&category='.$category.'&q='.$search.'&pageSize=50&page=1&apiKey=9b2e87cd02c24b0b9f38ab7fb6d56a55', '');
	 foreach($articles_groups1['articles'] as $article_group){
  	$articles1[] = $article_group;
  }
  // printr($articles1[0]);

	
	if(!empty($articles1)){
		
		$articles = array_merge($articles, $articles1);
	}else{
   
		$articles = $articles;
	}

  // echo 'there';
	// $articles= array_unique($articles, SORT_REGULAR);
	// printr($articles);  
	return $articles;
}

function get_icon($id, $news_sources){
	foreach($news_sources as $news_source){
		if($news_source['id'] == $id){
			$icon_url = $news_source['url'];
		}
	}
	return $icon_url;
}

function get_authors($articles){
  foreach($articles as $article){
  	if(!empty($article['author'])){
    	$authors[] = ltrim(rtrim($article['author'])).' ('.$article['source'][name].')';
    }
  }
  $authors = array_unique($authors);
  sort($authors);
  return($authors);
}

function get_articles_author($articles, $name){
  foreach($articles as $article){
    if($name == ltrim(rtrim($article[0]['author'])).' ('.$article[0]['source']['name'].')'){
      $author_articles[] = $article;
    }
  } 
  return $author_articles;
}



function sort_news_atoz($array, $key){
  foreach($array as $k => $v){
    $b[]=strtolower($v[$key]);
  }
  asort($b);
  foreach($b as $k => $v){
    $c[]=$array[$k];
  }
  return($c);
}


///////////////////////////////////PRINT NEWS STUFF///////////////////////////////////////////////////////////////


function print_news_articles($main_menu, $articles, $top_word, $news_articles_class, $news_sources){?>
	
	<?php //printr($articles);?>
  <div class = "row">
    <div class="col-sm-12 col-xs-12 row-no-padding">
   
      <ul class = "row pre-scrollable news-articles <?php echo $news_articles_class?>"><?php  
        if(!isset($_GET['top'])){          
          foreach($articles as $article){?>
    
            <a target="_blank" href = "<?php echo $article['url'];?>"> 
            <li class="col-sm-2 col-xs-2 row-no-padding">
              <img style="width:90%" src="<?php echo $article['urlToImage'];?>" alt="">
            </li>
            <li class="col-sm-7 col-xs-7 row-no-padding">
              <p><?php echo($article['title']);?></p>
            </li>
            
            <li class="col-sm-2 col-xs-2 row-no-padding news-icon">
            	<?php $icon_url=get_icon($article['source']['id'],$news_sources);
            	if(!empty($icon_url)){?>
	            	<!-- https://icons.better-idea.org/icon?url=<?php echo $article[1];?>&size=70..120..200 -->
	              <img class="news-categories-pic" alt=""
	            	src="https://besticon-demo.herokuapp.com/icon?url=<?php echo $icon_url;?>/&size=80..120..200">
            	<?php
							}else{?>
								<div class="pull-right" style="font-size:9px;"><?php
								echo($article['source']['name']);?>
								</div>
							<?php
								
							}?>
            </li>
            </a><?php
          }
        }?>
      </ul>
    </div>
  </div>
  <?php
}


function print_news_sources($main_menu, $category, $country, $language, $news_sources, $id){?>
  <ul class="news-list"><?php
  foreach($news_sources as $news_source){
  	//printr($news_source['url']);
    if($id == $news_source['id']){$class_selected = 'source-selected';}else{$class_selected = ' ';}?>
      <a href="index.php?main_menu=<?php echo $main_menu; ?>&category=<?php echo $category;?>&country=<?php echo $country;?>&language=<?php echo $language;?>&id=<?php echo $news_source['id'];?>&desc=<?php echo $news_source['description'];?>&url=<?php echo $news_source['url'];?>">
        <span> 
          <li class = "<?php echo 'independent'.' '.$class_selected;?>">
          	
          	
            <img class="news-categories-pic" alt="" 
            src="https://besticon-demo.herokuapp.com/icon?url=<?php echo ($news_source['url']);?>/&size=80..120..200">
            
            <div><?php echo $news_source['name'];?></div>
          </li>
        </span>
      </a> 
    <?php
  }?>
  </ul><?php
}

  
function print_news_authors($main_menu, $category, $country, $authors, $author_name, $source_type){?>
  <ul><?php
  //printr($authors);
    foreach($authors as $author){
    	
      if($author_name == $author){$class_selected = 'source-selected';}else{$class_selected = ' ';}?>
      <a href="?author_name=<?php echo $author;?>&main_menu=<?php echo $main_menu ?>&category=<?php echo $category;?>&country=<?php echo $country;?>&source_type=<?php echo $source_type;?>">
        <span> 
          <li class = "<?php echo 'news_menu_list'.' '.$class_selected;?>">
            <?php echo $author;?>
          </li>
        </span>
      </a><?php
    }?>
  </ul><?php
}

function print_news_source_description($id, $desc, $url){
  ?>
 
  <ul class="news-description">
    <div class = "row">
      <div class="col-sm-1 col-xs-2 row-no-padding">
        
        <img class="news-categories-pic" alt="" src="https://besticon-demo.herokuapp.com/icon?url=<?php echo $url;?>&size=70..120..200">
        
      </div>
      <div class="col-sm-11 col-xs-10 row-no-padding">
        <?php echo ($desc); ?>
      </div>
    </div>
  </ul><?php
  
}
function print_key_words(){?>
     <div class="row">
        <div class="col-sm-12 col-xs-12">
          <div class="keywords"><?php 
            $top_words = array_splice($top_words, 1);
            //printr($top_words);
            foreach($top_words as $top_word){?>
              <a href="?main_menu=<?php echo $main_menu;?>&sub_menu=<?php echo $sub_menu;?>&top=<?php echo $top_word;?>"><?php echo $top_word;?></a>&nbsp;<?php
            }?>
          </div><?php 
          if(isset($_GET['top'])){
            foreach($articles as $article){
              if(strpos($article['title'], $_GET['top']) !== FALSE){
                $article['title'] = str_replace($_GET['top'],'<span style="color:red">'.$_GET['top'].'</span>', $article['title']);?>
                <div class="keyword-news">
                  <a href = "<?php echo $article['url'];?>">
                    <img src="<?php echo $article['urlToImage'];?>" alt="">
                    <?php echo($article['title']);?>
                    <img class="keyword-news-article-icon" src="<?php echo get_news_source_icon($news_sources_icons,$article['source_id'])?>" alt="">
                  </a>
                </div><?php
              }
            }
          }?>       
        </div>
       </div> 
  
  <?php
}


function excluded_words(){
  $excluded_words = ['AIa', 't', 'https', 'co', 'the', 'to', 'and', 'in', 'of', 'i', 'a', 'is', 'you', 'for', 'will', 'on', 'be', '-', 'that', 'with', 'at', 'are', 'the', 'have', 'it', 'our', 'by', 'great', 'was', 'all', 'has', 'my', 'we', 'We', 'me', 'not', 'so', 'out', 'this', 'from', 'a', 'her', 'as','who', 'just', 'about', 'she', 'u', 'they', 'am', 'going', 'but', 'he', 'get', 'your', 'been', 'amp', 'after', 's', 'over', 'says', 'is', 'up', 'no', 'why', 'rise', 'what', 'into', 'new', 'how', 'an', 'may','could', 'if', 'these', 'or', 'some', 'TV', 'his', 'between', 'claims','r', 'can', 'know', 'us', 'in', 'house', 'bill', 'u.s.','of the', 'more', 'than', 'say', '|', '•', 'cnn', 'video',"it's"];
  
  return $excluded_words;
}

function trans(){
  $trans = array("Donald" => "Trump", "Attacker" => "Attack", "Vote On" => "Vote", "White" => "White House", "House" => "White House", "Health" => "Health Care", "Care" => "Health Care", "Trump's" => "Trump");
  
  return $trans;
}


function top_words($strings){
  //printr($strings);
  
  $strings = implode(" ",$strings);//make long string from strings
  $strings = explode(" ",ucwords(strtolower($strings)));//make array of single words
  
  //printr($strings);
  
  $pairs = array();// make array of paired words
  for($i=0;$i<count($strings)-1;$i++) {
    $pairs[] =  $strings[$i].' '.$strings[$i+1];
  }
  $pairs[] =  $strings[$i];
  //printr($pairs);
  
  $words_and_pairs = array_merge($strings, $pairs);
  
  //printr($words_and_pairs);
  
  
  $excluded_words = excluded_words();
  foreach($excluded_words as $excluded_word){
    
    $excluded_words_capped[] = ucfirst($excluded_word);
  }
  foreach($excluded_words_capped as $excluded_word){
    $excluded_words_nulled[$excluded_word] = '';  
  }
  
  $trans = trans();
  
  $filtered_words = array_merge($excluded_words_nulled, $trans);
  
//printr($filtered_words);
  
  foreach($filtered_words as $find => $replace){
    //echo $find;
    //echo $replace;
    $find_pos = array_keys($words_and_pairs, $find);
    $replacements[] = '';
    foreach($find_pos as $replace_pos){
      //echo $replace_pos;
      $replacements[$replace_pos] = $replace;
      //printr($replace_pos);
    }
    
  }
  //printr($replacements);
    $words_and_pairs_filtered = array_replace($words_and_pairs, $replacements);
  //printr($words_and_pairs_filtered);
  
  
  $words_and_pairs_counts = array_count_values($words_and_pairs_filtered);
    arsort($words_and_pairs_counts);
  
   //printr($words_and_pairs_counts);
    $top_words = array_slice($words_and_pairs_counts, 0, 20);
  
  //printr(($top_words));
  return array_keys($top_words);
  
}








function excluded_pairs(){
  
  $excluded_pairs = ['injured in'];
  
  // foreach($excluded_words as $excluded_word){
//    
    // $excluded_words[] = ucfirst($excluded_word);
  // }
  return $excluded_pairs;
  
}




function strpos_all($haystack, $needle) {
    $offset = 0;
    $allpos = array();
    while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
        $offset   = $pos + 1;
        $allpos[] = $pos;
    }
    return $allpos;
}

