<?php
	//session_start();
	include 'counter.php';
	include 'functions.php';
	require_once('TwitterAPIExchange.php');
	//include 'connect.php;
	////////////////////////TRUMP DEFAULT SCREEN NAME/////////////////////////////////////////////////////
	if(!isset($_GET['screen_name'])){
		$screen_name = '@realDonaldTrump';
	}else{
		$screen_name = ($_GET['screen_name']);
	}
	
	
	//////////////////////GET TWEETS/////////////////////////////////////////////////////////////////////////
	if($screen_name !== '@'){
		$tweets_200 = get_tweets('&','100',$screen_name,3);
	}else{
		$errors['no twitter account'] = $_GET['first_name'].' '.$_GET['last_name'].' has no twitter account';
	}
	//save_tweets_file($responses, $conn);
	//$tweets_file = retrieve_tweets_file();
	
		
	////////////////////FILTER TWEETS BY DATE/////////////////////////////////////////////////////////////////
	$date_selectors = ['Mar', 'Feb', 'Jan', 'Prez Elect'];
	
	if(!isset($_GET['date'])){
		$date = "Mar";
	}else{
		$date = $_GET['date'];
	}	
		
	$tweets_dated = tweets_date_filter($date, $tweets_200);
	
	
	
	//////////////////////GET MEMBERS///////////////////////////////////////////////////////////////////////////
	$chamber = 'senate';
	if(isset($_GET['chamber'])){
		$chamber = $_GET['chamber'];
	}
	$members = get_members($chamber);
	//list($members,$democrats_twitter_accounts, $republicans_twitter_accounts, $democrats_names, $republicans_names) = get_congress_members();
	
	
	/////////////////////GET NEWS////////////////////////////////////////////////////////////////////////////
	$news_sources = get_news_sources();
	list($articles, $articles_titles) = get_news_articles($news_sources);
	$top_words = top_words($articles_titles);
	
	//printr($top_words);
	
	
	
	
?>
<!DOCTYPE html>
<html lang="en">
	<head><?php include 'head.html.php';?></head>
	<body>
		<div class="container">	
		<?php include 'header.php';	?>
			
				<div class="header">
					<div class="row">
						<!-- YELLOW BAR MENU ----------------------------------->
					<?php //foreach($news_titles as $title){echo $title.','. str_repeat('&nbsp;', 5);}?>
					<div class="row" style="padding-top:3px;">
						<div class="col-sm-4 col-xs-4" style="background-color:yellow;color:green;font-size:12px">
			  		  	<a href="?chamber=senate" style="<?php if($chamber == 'senate'){echo 'color:blue;font-size:12px;font-weight:bold';}?>">senate</a>
						<a href="?chamber=house" style="<?php if($chamber == 'house'){echo 'color:blue;font-size:12px;font-weight:bold';}?>">house</a>
						</div>
			  			<div class="col-sm-8 col-xs-8" style="background-color:yellow;color:green;font-size:12px;">
						<?php 
						foreach($date_selectors as $date_selector){
							if($date == $date_selector){$color = 'green';}else{$color = 'blue';}
							if($screen_name !== '@realDonaldTrump' && $date_selector == 'Prez Elect'){
									
							}else{
								echo'<a href="?date='.$date_selector.'&screen_name='.$screen_name.'" style="color:'.$color.';font-size:10px;padding:0px 20px">'.$date_selector.'</a>&nbsp&nbsp&nbsp';	
							}
						}	
						?>
		  		 		</div>
					</div>
		               
					</div>
				</div>	
				
			
					 
			<div class="row " style="margin-top:0px">
			<div class="pre-scrollable col-sm-2 col-xs-2" style="background-color:#d6f6f9;color:black;border-radius:10px;padding:4px;">
				<p>Democrats</p>
				<ul>
				<?php 
				foreach($members as $member){
					if($member['party'] == 'D'){
						if(isset($_GET['screen_name'])){
						//echo $_GET['screen_name'];
						if($_GET['screen_name'] == '@'.$member['twitter_account']){$color = 'purple';}else{$color = 'blue';}
						}else{
							$color = 'blue';
						}
    
          
          	
     
	
		
		 
		 
						//echo '<span><li style="padding-left:3px";><img src='.get_user_info($member['twitter_account'])['profile_image_url'].' alt="Smiley face" style="width:20px;margin:4px;border-radius:5px;">';	
						echo'<li style="display:block;float:left;clear:left;"><a href="?screen_name=@'.$member['twitter_account'].'&chamber='.$chamber.'&first_name='.$member['first_name'].'&last_name='.$member['last_name'].'" style="color:'.$color.'" data-toggle="tooltip" title="@'.$member['twitter_account'].' -'.$member['state'].'" data-placement="auto right">'.$member['first_name'] .' '.$member['last_name'].'</a></li></span>&nbsp';
					}
				}
				?>
				</ul>
			</div>
			
			<div class="pre-scrollable col-sm-2 col-xs-2" style="background-color:#f9d6d9;color:black;border-radius:10px;padding:4px;">
			    <p>Republicans</p>
				<ul>
				<?php 
				
				foreach($members as $member){
					if($member['party'] == 'R'){
						if(isset($_GET['screen_name'])){
						if($_GET['screen_name'] == '@'.$member['twitter_account']){$color = 'purple';}else{$color = 'blue';}
						}else{
							$color = 'blue';
						}
						echo'<li style="display:block;float:left;clear:left;"><a href="?screen_name=@'.$member['twitter_account'].'&chamber='.$chamber.'&first_name='.$member['first_name'].'&last_name='.$member['last_name'].'" style="color:'.$color.'" data-toggle="tooltip" title="@'.$member['twitter_account'].'"data-placement="auto right">'.$member['first_name'] .' '.$member['last_name'].'</a></li></span>&nbsp';
					}
				}
				?>
				</ul>
			</div>
			
			<div class="col-sm-8 col-xs 8 pre-scrollable" style="background-color:transparent;">
				<?php
				
				
				// $str = 'The text to test';
// if($str{0} === strtoupper($str{0})) {
   // echo 'yepp, its uppercase';
// }
// else{
   // echo 'nope, its not upper case';
// }
				//printr($article_groups);
					// printr($news_sources);
	      			if(isset($_GET['top'])){
						foreach($articles as $article){
							
							//echo strpos($article['title'], strtolower($_GET['top']));
							// printr($pos);
// 							
							
							
							
							
							
							if(strpos($article['title'], $_GET['top']) !== FALSE){
								
								$article['title'] = str_replace($_GET['top'],'<span style="color:red">'.$_GET['top'].'</span>', $article['title']); 
								
								?>
								<a href = "<?php echo $article['url'];?>"><pre style="overflow:hidden"><img class="" style="float:left;width:100px" src="<?php echo $article['urlToImage'];?>" alt="news pic not available">&nbsp&nbsp<?php echo($article['title']).' &nbsp&nbsp';?><img class="" style="float:right;height:18px" src="<?php echo $article['news_source_small_logo'];?>" alt="news logo not available"><br><br><br></pre></a>
								<?php
							}
							
							if(strpos($article['title'], strtolower($_GET['top'])) !== FALSE){
								
								$article['title'] = str_replace(strtolower($_GET['top']),'<span style="color:red">'.strtolower($_GET['top']).'</span>', $article['title']); 
								
								?>
								<a href = "<?php echo $article['url'];?>"><pre style="overflow:hidden"><img class="" style="float:left;width:100px" src="<?php echo $article['urlToImage'];?>" alt="news pic not available">&nbsp&nbsp<?php echo($article['title']).' &nbsp&nbsp';?><img class="" style="float:right;height:18px" src="<?php echo $article['news_source_small_logo'];?>" alt="news logo not available"><br><br><br></pre></a>
								<?php
							}
						
					}
				
				
				
				}else{
				
			
				 
	  			if(isset($tweets_200)){
	  				 
					
					
	  				print_tweets($tweets_dated);
				}else{
					printr($errors['no twitter account']);
					}
					}
	  			?>
			</div>
		
	
	</div> 	 
		
	</div>
	<?php
	//echo "You are visitor number $counterVal to this site";
	//mysqli_close($conn);
	?>
	
</body>
</html>





<script>
$('p#test').tweetLinkify();
$('span#test').tweetLinkify();
</script>