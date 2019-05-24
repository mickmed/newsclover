<nav class="navbar navbar-default navbar-fixed-top">
 
 
  <div class="container pink-blue hidden-xs">
   	
      <a class="navbar-brand" href="index.php"><img src="clover_clear.png" alt="NewsClover"></a> 
   		<ul class="nav navbar-nav navbar-left">
        <?php 
       
        foreach($categories as $c){
        	if($c == $category){$class = "main-menu-selected";}else{$class="";}
       		echo '<li class='.$class.'><a href="?category='.$c.'&country='.$country.'&language='.$language.'">'.$c.'</a></li>';
       	}
				
			
       	?> 
      </ul>
  		<form class="navbar-form navbar-right" action="index.php">
  			<input type="hidden" name="main_menu" value="<?php echo $main_menu; ?>">
				<input type="hidden" name="category" value="<?php echo $category; ?>">
				<input type="hidden" name="country" value="<?php echo $country; ?>">
				<input type="hidden" name="language" value="<?php echo $language; ?>">
				<input type="hidden" name="search" value="<?php echo $search; ?>">
		    <div class="form-group" style="display:inline;">
		        <div class="input-group">
               <input type="text" class="form-control search-bar" placeholder="Search" name="search">
               <div class="input-group-btn">
                  <button type="submit" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
               </div>
            </div>
	     	</div>
 			</form>
  </div><!--/.container -->
  
  
 <div class="container pink-blue hidden-sm hidden-md hidden-lg"> 
 
  
  <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapsible">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><img src="clover_clear.png" alt="Newsclover"></a>
      <form class="navbar-form navbar-right" action="index.php">
  			<input type="hidden" name="main_menu" value="<?php echo $main_menu; ?>">
				<input type="hidden" name="category" value="<?php echo $category; ?>">
				<input type="hidden" name="country" value="<?php echo $country; ?>">
				<input type="hidden" name="language" value="<?php echo $language; ?>">
				<input type="hidden" name="search" value="<?php echo $search; ?>">
		    <div class="form-group search-bar-group">
		        <div class="input-group">
               <input type="text" class="form-control search-bar" placeholder="Search" name="search">
               <div class="input-group-btn">
                  <button type="submit" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
               </div>
            </div>
	     	</div>
 			</form>
    </div>
  
  	<div class="navbar-collapse collapse" id="navbar-collapsible">
      
   		<ul class="nav navbar-nav">
        <?php 
        foreach($categories as $c){
        	if($c == $category){$class = "main-menu-selected";}else{$class="";}
       		echo '<li class='.$class.'><a href="?category='.$c.'&country='.$country.'&language='.$language.'">'.$c.'</a></li>';
       	}
       	
       	?> 
      </ul>
   </div>
   
  		
  
 </div>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
</nav>




	 
  





  


	