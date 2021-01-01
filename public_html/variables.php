<?php

////////////LANGUAGE///////////	

$language = 'en';

$source_type = 'sources';
if (isset($_GET['source_type'])) {
	$source_type = $_GET['source_type'];
}


////////////CATEGORIES///////////	
$categories = ['all', 'general', 'business', 'health', 'science', 'technology', 'entertainment', 'sports'];
$category = 'general';
if (isset($_GET['category'])) {
	$category = $_GET['category'];
}
if ($category == 'all') {
	$category = '';
}

////////////COUNTRIES/////////////
$countries = ['' => 'world', 'gb' => 'united kingdom', 'us' => 'united states', 'ar' => 'argentina', 'au' => 'australia', 'at' => 'austria', 'be' => 'belgium', 'bg' => 'bulgaria', 'br' => 'brazil', 'ca' => 'canada', 'cn' => 'china', 'co' => 'columbia', 'cu' => 'cuba', 'cz' => 'czech republic', 'eg' => 'egypt', 'fr' => 'france', 'de' => 'germany', 'gr' => 'greece', 'hk' => 'hong_kong', 'hu' => 'hungary', 'in' => 'india', 'id' => 'indonesia', 'ie' => 'ireland', 'il' => 'israel', 'it' => 'italy', 'jp' => 'japan', 'lv' => 'latvia', 'lt' => 'lithuania', 'my' => 'malaysia', 'mx' => 'mexico', 'ma' => 'morocco', 'nl' => 'netherlands', 'nz' => 'new zealand', 'ng' => 'nigeria',  'no' => 'norway', 'ph' => 'philippines', 'pl' => 'poland', 'pt' => 'portugal', 'ro' => 'romania', 'ru' => 'russia', 'sa' => 'saudia_arabia', 'rs' => 'serbia', 'sg' => 'singapore', 'sk' => 'slovakia', 'si' => 'slovenia',  'za' => 'south_africa', 'kr' => 'south korea', 'se' => 'sweden', 'ch' => 'switzerland', 'tw' => 'taiwan', 'th' => 'thailand', 'tr' => 'turkey', 'ae' => 'uae', 'ua' => 'ukraine', 'es' => 'spain', 've' => 'venuzuala'];

$country = 'us';
if (isset($_GET['country'])) {
	$country = $_GET['country'];
}

//////////////SEARCH/////////////////
if (isset($_GET['search'])) {
	$search = urlencode($_GET['search']);
} else {
	$search = '';
}

// echo $search;

if (isset($_GET['name']) && !empty($_GET['name'])) {
	$name = $_GET['name'];
} else {
	$name = '';
}




//////////////RESULTS NO ELEMENTS/////////////////
if ((empty($country) && empty($category) && empty($search)) && empty($name)) {
	// echo 'hereerererere';
	$news_sources = get_news_sources($category, $country);
	$news_sources = $news_sources['sources'];

	foreach ($news_sources as $news_source) {
		$news_sources_ids[] = ($news_source['id']);
	}
	$news_sources_ids = (implode(",", $news_sources_ids));
	$headlines_by_source_ids = get_headlines_by_source_ids($news_sources_ids, $search);
	$articles = $headlines_by_source_ids;
}


////////////////RESULTS ONLY SEARCH ELEMENT////////////
if ((empty($country) && empty($category) && !empty($search)) && empty($name)) {

	list($sources_by_elements, $headlines_by_elements) = get_headlines_by_elements($category, $country, $search);
	list($sources_by_url_and_id, $everything_by_url_and_id) = get_everything_by_url_and_id($url, $id, $search);

	$news_sources_temp = array_merge_recursive((array)$sources_by_url_and_id, (array)$sources_by_elements);
	$sources_tempArr = array_unique(array_column($news_sources_temp, 'name'));
	$news_sources = (array_intersect_key($news_sources_temp, $sources_tempArr));

	$news_articles_temp = array_merge_recursive((array)$everything_by_url_and_id, (array)$headlines_by_elements);
	$articles_tempArr = array_unique(array_column($news_articles_temp, 'url'));
	$news_articles = (array_intersect_key($news_articles_temp, $articles_tempArr));
	$articles = $news_articles;
}

////////////////RESULTS COUNTRY and CATEGORY ELEMENTS, NO SEARCH////////////


if ((!empty($country) || !empty($category)) && empty($name)) {
	if (empty($search)) {
		$news_sources = get_news_sources($category, $country);
		$news_sources = $news_sources['sources'];

		list($sources_by_elements, $headlines_by_elements) = get_headlines_by_elements($category, $country, $search);


		$news_sources_temp = array_merge_recursive((array)$news_sources, (array)$sources_by_elements);
		$sources_tempArr = array_unique(array_column($news_sources_temp, 'name'));
		$news_sources = (array_intersect_key($news_sources_temp, $sources_tempArr));

		foreach ($news_sources as $news_source) {
			$news_sources_ids[] = ($news_source['id']);
		}
		// printr($news_sources_ids);

		$news_sources_ids = (implode(",", $news_sources_ids));
		// printr($news_sources_ids);

		//list($sources_by_url_and_id, $everything_by_url_and_id) = get_everything_by_url_and_id($url, $id, $search);
		// $headlines_by_source_ids = get_headlines_by_source_ids($news_sources_ids);

		// $articles_temp = array_merge_recursive( (array)$headlines_by_elements, (array)$headlines_by_source_ids );
		// //printr($articles_temp);
		// $articles_tempArr = array_unique(array_column($articles_temp, 'title'));
		// //printr($articles_tempArr);
		// $news_articles = (array_intersect_key($articles_temp, $articles_tempArr));
		$articles = $headlines_by_elements;
		// printr($articles);
		$authors = get_authors($articles);
		//printr($articles);
		if (isset($_GET['author_name'])) {
			$name = $_GET['author_name'];
			$id = $_GET['id'];
			$articles = get_articles_author($articles, $name);
		}
	}
}
////////////////RESULTS ALL ELEMENTS INCLUDING SEARCH////////////

if ((!empty($country) || !empty($category)) && empty($name)) {



	if (!empty($search)) {
	
		$news_sources = get_news_sources($category, $country);
		//$news_sources = $news_sources['sources'];
		list($sources_by_elements, $headlines_by_elements) = get_headlines_by_elements($category, $country, $search);

		$news_sources_temp = array_merge_recursive((array)$news_sources['sources'], (array)$sources_by_elements);
		$sources_tempArr = array_unique(array_column($news_sources_temp, 'name'));
		$news_sources = (array_intersect_key($news_sources_temp, $sources_tempArr));

		foreach ($news_sources as $news_source) {
			$news_sources_ids[] = ($news_source['id']);
		}
		$news_sources_ids = (implode(",", $news_sources_ids));

		//list($sources_by_url_and_id, $everything_by_url_and_id) = get_everything_by_url_and_id($url, $id, $search);
		$headlines_by_source_ids = get_headlines_by_source_ids($news_sources_ids, $search);

		$articles_temp = array_merge_recursive((array)$headlines_by_elements, (array)$headlines_by_source_ids);
		$articles_tempArr = array_unique(array_column($articles_temp, 'url'));
		$news_articles = (array_intersect_key($articles_temp, $articles_tempArr));
		$articles = $news_articles;
		foreach ($articles as $article) {
			$sources[] = $article['source'];
			//printr($articles);
		}
		$news_sources = $sources;
		//printr($news_sources);
	}
}




if (isset($_GET['name']) && !empty($_GET['name'])) {

	//printr('name');
	$name = strtolower($_GET['name']);
	$id = $_GET['id'];
	$desc = $_GET['desc'];
	$url = strtolower($_GET['url']);


	list($sources_by_elements, $headlines_by_elements) = get_headlines_by_elements($category, $country, $search);
	foreach ($headlines_by_elements as $headline) {
		if (strtolower($headline['source']['name']) == $name) {

			$headlines_by_elements[] = $headline;
			$sources_by_elements1[] = $headline['source'];
		}
	}
	//printr(($headlines_by_elements1));



	if (!empty($id)) {
		list($sources_by_source_id, $headlines_by_source_id) = get_headlines_by_source_ids($id, $search);
	}
	//printr($headlines_by_source_id);



	list($sources_by_url_and_id, $everything_by_url_and_id) = get_everything_by_url_and_id($url, $id, $search);
	//printr($everything_by_url_and_id);


	$news_sources_temp = array_merge_recursive((array)$sources_by_source_id, (array)$sources_by_elements1, (array)$sources_by_url_and_id);
	$sources_tempArr = array_unique(array_column($news_sources_temp, 'name'));
	$news_sources = (array_intersect_key($news_sources_temp, $sources_tempArr));
	//printr($news_sources);

	$articles_temp = array_merge((array)$headlines_by_elements11, (array)$headlines_by_source_id, (array)$everything_by_url_and_id);
	$articles_tempArr = array_unique(array_column($articles_temp, 'title'));
	$news_articles = (array_intersect_key($articles_temp, $articles_tempArr));
	$articles = $news_articles;
	//printr($headlines_by_elements);

} else {
	$name = '';
	$id = '';
	$url = '';
}



$articles = sort_news_atoz($articles, ('publishedAt'));
$articles = array_reverse($articles);








if ($category == '') {
	$category = 'all';
}
		
	
	
	
	
// if($news_sources['code'] == 'rateLimited'){
		// //printr($news_sources);
		// $rate_limited_message = "This is non-profit website. We're down for maintenance. Please come back shortly to view news from over 5000 sources and 52 countries. Thank you for your patronage.";
	// }else{
	//$news_sources = $news_sources['sources'];
