<?php
function get_news_sources($category, $country)
{
  $news_sources = get_curl('https://newsapi.org/v2/sources?country=' . $country . '&category=' . $category . '&apiKey=b0b0ec73a4cb4bd1b9f4a62d6071ad81', '');
  return $news_sources;
}

function get_headlines_by_elements($category, $country, $search)
{
  
  $headlines_groups = [get_curl('https://newsapi.org/v2/top-headlines?country=' . $country . '&category=' . $category . '&q=' . $search . '&pageSize=100&page=1&apiKey=b0b0ec73a4cb4bd1b9f4a62d6071ad81', '')];

  foreach ($headlines_groups[0]['articles'] as $headline_group) {
    $sources_by_elements[] = $headline_group['source'];
    $headlines_by_elements[] = $headline_group;
  }
  return [$sources_by_elements, $headlines_by_elements];
}

function get_headlines_by_source_ids($news_sources_ids, $search)
{
  $headlines_groups = [get_curl('https://newsapi.org/v2/top-headlines?sources=' . $news_sources_ids . '&q=' . $search . '&pageSize=50&page=1&apiKey=b0b0ec73a4cb4bd1b9f4a62d6071ad81', '')];
  foreach ($headlines_groups[0]['articles'] as $headline_group) {
    $headlines_by_source_ids[] = $headline_group;
    $sources_by_source_ids[] = $headline_group['source'];
  }
  return ($headlines_by_source_ids);
}

function get_everything_by_url_and_id($url, $id, $search)
{
  $everything_groups = [get_curl('https://newsapi.org/v2/everything?sources=' . $id . '&domains=' . $url . '&q=' . $search . '&pageSize=50&page=1&apiKey=b0b0ec73a4cb4bd1b9f4a62d6071ad81', '')];

  foreach ($everything_groups[0]['articles'] as $everything_group) {
    $sources_by_url_and_id[] = $everything_group['source'];
    $everything_by_url_and_id[] = $everything_group;
  }
  return [$sources_by_url_and_id, $everything_by_url_and_id];
}

function get_news_source($news_sources, $id)
{
  foreach ($news_sources as $news_source) {
    if ($id == $news_source['id']) {
      $source[] = $news_source;
    }
  }
  return $source;
}

function get_articles_news_source($id, $search)
{

  $articles_groups = [get_curl('https://newsapi.org/v2/top-headlines?sources=' . $id . '&q=' . $search . '&pageSize=50&page=1&apiKey=b0b0ec73a4cb4bd1b9f4a62d6071ad81', '')];

  foreach ($articles_groups[0]['articles'] as $article_group) {
    $articles[] = $article_group;
  }
  return $articles;
}

function get_icon($id, $news_sources)
{
  // foreach($news_sources as $news_source){
  // 	if($news_source['id'] == $id){
  // 		$icon_url = $news_source['url'];
  // 	}
  // }
  // return $icon_url;
}

function get_authors($articles)
{
  foreach ($articles as $article) {
    if (!empty($article['author'])) {
      $authors[] = ltrim(rtrim($article['author'])) . ' (' . $article['source']['name'] . ')';
    }
  }
  $authors = array_unique($authors);
  sort($authors);
  return ($authors);
}

function get_articles_author($articles, $name)
{
  foreach ($articles as $article) {
    if ($name == ltrim(rtrim($article['author'])) . ' (' . $article['source']['name'] . ')') {
      $author_articles[] = $article;
    }
  }
  return $author_articles;
}

function sort_news_atoz($array, $key)
{
  foreach ($array as $k => $v) {
    $b[] = strtolower($v[$key]);
  }
  asort($b);
  foreach ($b as $k => $v) {
    $c[] = $array[$k];
  }
  return ($c);
}

///////////////////////////////////PRINT NEWS STUFF///////////////////////////////////////////////////////////////

function print_news_sources($category, $country, $language, $news_sources, $name)
{
  //printr($news_sources);
?>

  <ul class="pre-scrollable news-source-list">
    <?php
    foreach ($news_sources as $news_source) {
      if (isset($news_source['url'])) {
        $icon_url = $news_source['url'];
      } elseif (isset($news_source['name'])) {
        $icon_url = $news_source['name'];
      } elseif (empty($news_source['id'])) {
        $icon_url = $news_source(strtolower)['name'];
        //printr($icon_url);
      } else {
        //$sources=get_news_sources('','','');
        $icon_url = $icon_url = get_icon($news_source['id'], $sources['sources']);
        //printr($icon_url);
      }

      if (strtolower($name) == (strtolower($news_source['name']))) {
        $class_selected = 'source-selected';
      } else {
        $class_selected = '';
      } ?>
      <a href="?category=<?php echo $category; ?>&country=<?php echo $country; ?>&id=<?php echo $news_source['id']; ?>&name=<?php echo $news_source['name']; ?>&desc=<?php echo $news_source['description']; ?>&url=<?php echo str_replace(["http://www.", "https://www.", "http://"], "", $icon_url); ?>">
        <li class="<?php echo 'independent' . ' ' . $class_selected; ?>">
          <div class="col-sm-2 col-xs-2 row-no-padding news-source-img">

            <img class="news-categories-pic" alt="<?php echo $news_source['name']; ?>" src="https://besticon-demo.herokuapp.com/icon?url=<?php echo $icon_url; ?>&size=80..120..200">
          </div>

          <div class="col-sm-9 col-xs-9 row-no-padding source-name">
            <div><?php echo $news_source['name']; ?></div>
          </div>
        </li>
      </a>
    <?php
    } ?>
  </ul>
<?php
}

function print_news_authors($category, $country, $authors, $author_name, $source_type)
{ ?>
  <ul><?php
      foreach ($authors as $author) {
        if ($author_name == $author) {
          $class_selected = 'source-selected';
        } else {
          $class_selected = ' ';
        } ?>
      <a href="?author_name=<?php echo $author; ?>&category=<?php echo $category; ?>&country=<?php echo $country; ?>&source_type=<?php echo $source_type; ?>">
        <span>
          <li class="<?php echo 'news_menu_list' . ' ' . $class_selected; ?>">
            <?php echo $author; ?>
          </li><br><br>
        </span>
      </a><?php
        } ?>
  </ul>
<?php
}



function print_news_source_description($id, $desc, $url)
{ ?>
  <div class="news-description hidden-xs">
    <div class="col-sm-1 col-xs-2 row-no-padding">
      <img class="news-categories-pic" alt="" src="https://besticon-demo.herokuapp.com/icon?url=<?php echo $url; ?>&size=70..120..200">
    </div>
    <div class="col-sm-11 col-xs-10 row-no-padding">
      <?php echo $desc; ?>
    </div>
  </div>
<?php
}


function print_author_description($name)
{ ?>
  <div class="author-description">
    <div class="col-sm-1 col-xs-2 row-no-padding">
    </div>
    <div class="col-sm-11 col-xs-10 row-no-padding">
      <?php echo ($name); ?>
    </div>
  </div>
<?php
}


function print_news_articles($articles, $top_word, $max_height, $news_sources, $country_value, $category, $search, $rate_limited_message)
{ ?>
  <ul class="pre-scrollable news-articles <?php echo $max_height ?>">
    <?php
    if (isset($rate_limited_message) && !empty($rate_limited_message)) {
      print_rate_limited_message($rate_limited_message);
    }

    if (empty($articles)) {
      print_no_articles_message($country_value, $category, $search);
    }

    foreach ($articles as $article) { ?>

      <a target="_blank" href="<?php echo $article['url']; ?>">
        <li class="col-sm-2 col-xs-12 row-no-padding">
          <img style="width:90%" src="<?php echo $article['urlToImage']; ?>" alt="">
        </li>
        <li class="col-sm-7 col-xs-7 row-no-padding">
          <p><?php echo ($article['title']); ?></p>
        </li>

        <li class="col-sm-2 col-xs-2 row-no-padding news-icon">
          <?php $icon_url = get_icon($article['source']['id'], $news_sources);

          if (!empty($icon_url)) {
            $icon_url = $icon_url;
          } else {
            $icon_url = $article['source']['name'];
          } ?>
          <!-- https://icons.better-idea.org/icon?url=<?php echo $article[1]; ?>&size=70..120..200 -->
          <img class="news-categories-pic" alt="" src="https://besticon-demo.herokuapp.com/icon?url=<?php echo $icon_url; ?>&size=80..120..200">

          <div class="hidden-xs" style="font-size:8px;">
            <?php echo $article['source']['name']; ?>
          </div>
        </li>
      </a>
    <?php
    }
    ?>
  </ul>


<?php
}


function print_no_articles_message($country_value, $category, $search)
{
?>
  <div style="margin:5px 20px 5px 20px;">
    <?php

    echo 'sorry, there are no results for:<br><br>';
    echo 'country: ' . $country_value . '<br>';
    echo 'category: ' . $category . '<br>';
    echo 'search term: ' . $search; ?>
  </div>
<?php
}


function print_rate_limited_message($rate_limited_message)
{
?>
  <div style="margin:5px 20px 5px 20px;font-size:20px;">
    <?php

    echo $rate_limited_message . '<br><br>';
    ?>
  </div>
<?php
}

function print_key_words()
{ ?>
  <div class="row">
    <div class="col-sm-12 col-xs-12">
      <div class="keywords">
        <?php
        $top_words = array_splice($top_words, 1);
        //printr($top_words);
        foreach ($top_words as $top_word) { ?>
          <a href="?main_menu=<?php echo $main_menu; ?>&sub_menu=<?php echo $sub_menu; ?>&top=<?php echo $top_word; ?>"><?php echo $top_word; ?></a>&nbsp;<?php
                                                                                                                                                        } ?>
      </div>
      <?php
      if (isset($_GET['top'])) {
        foreach ($articles as $article) {
          if (strpos($article['title'], $_GET['top']) !== FALSE) {
            $article['title'] = str_replace($_GET['top'], '<span style="color:red">' . $_GET['top'] . '</span>', $article['title']); ?>
            <div class="keyword-news">
              <a href="<?php echo $article['url']; ?>">
                <img src="<?php echo $article['urlToImage']; ?>" alt="">
                <?php echo ($article['title']); ?>
                <img class="keyword-news-article-icon" src="<?php echo get_news_source_icon($news_sources_icons, $article['source_id']) ?>" alt="">
              </a>
            </div>
      <?php
          }
        }
      } ?>
    </div>
  </div>

<?php
}


function excluded_words()
{
  $excluded_words = ['AIa', 't', 'https', 'co', 'the', 'to', 'and', 'in', 'of', 'i', 'a', 'is', 'you', 'for', 'will', 'on', 'be', '-', 'that', 'with', 'at', 'are', 'the', 'have', 'it', 'our', 'by', 'great', 'was', 'all', 'has', 'my', 'we', 'We', 'me', 'not', 'so', 'out', 'this', 'from', 'a', 'her', 'as', 'who', 'just', 'about', 'she', 'u', 'they', 'am', 'going', 'but', 'he', 'get', 'your', 'been', 'amp', 'after', 's', 'over', 'says', 'is', 'up', 'no', 'why', 'rise', 'what', 'into', 'new', 'how', 'an', 'may', 'could', 'if', 'these', 'or', 'some', 'TV', 'his', 'between', 'claims', 'r', 'can', 'know', 'us', 'in', 'house', 'bill', 'u.s.', 'of the', 'more', 'than', 'say', '|', '•', 'cnn', 'video', "it's"];

  return $excluded_words;
}

function trans()
{
  $trans = array("Donald" => "Trump", "Attacker" => "Attack", "Vote On" => "Vote", "White" => "White House", "House" => "White House", "Health" => "Health Care", "Care" => "Health Care", "Trump's" => "Trump");

  return $trans;
}


function top_words($strings)
{
  //printr($strings);

  $strings = implode(" ", $strings); //make long string from strings
  $strings = explode(" ", ucwords(strtolower($strings))); //make array of single words

  //printr($strings);

  $pairs = array(); // make array of paired words
  for ($i = 0; $i < count($strings) - 1; $i++) {
    $pairs[] =  $strings[$i] . ' ' . $strings[$i + 1];
  }
  $pairs[] =  $strings[$i];
  //printr($pairs);

  $words_and_pairs = array_merge($strings, $pairs);

  //printr($words_and_pairs);


  $excluded_words = excluded_words();
  foreach ($excluded_words as $excluded_word) {

    $excluded_words_capped[] = ucfirst($excluded_word);
  }
  foreach ($excluded_words_capped as $excluded_word) {
    $excluded_words_nulled[$excluded_word] = '';
  }

  $trans = trans();

  $filtered_words = array_merge($excluded_words_nulled, $trans);

  //printr($filtered_words);

  foreach ($filtered_words as $find => $replace) {
    //echo $find;
    //echo $replace;
    $find_pos = array_keys($words_and_pairs, $find);
    $replacements[] = '';
    foreach ($find_pos as $replace_pos) {
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

function excluded_pairs()
{

  $excluded_pairs = ['injured in'];

  // foreach($excluded_words as $excluded_word){
  //    
  // $excluded_words[] = ucfirst($excluded_word);
  // }
  return $excluded_pairs;
}


function strpos_all($haystack, $needle)
{
  $offset = 0;
  $allpos = array();
  while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
    $offset   = $pos + 1;
    $allpos[] = $pos;
  }
  return $allpos;
}
