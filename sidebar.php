<?php
if (!defined('IN_ADMIN')) die("Hacking attempt");


?>

<div class="col-md-3 visible-lg visible-md hidden-print sidebar"  id="rightCol">
        
	<div class="list-group">
	   <a href="<?php echo $facebook; ?>" class="list-group-item facebook-like">
			<h3 class="pull-right">
				<i class="fa fa-facebook-square"></i>
			</h3>
			<h4 class="list-group-item-heading count">
				Facebook</h4>
			<p class="list-group-item-text">
				Like us on Facebook</p>
		</a><a href="<?php echo $google; ?>" class="list-group-item google-plus">
			<h3 class="pull-right">
				<i class="fa fa-google-plus-square"></i>
			</h3>
			<h4 class="list-group-item-heading count">
				Google+</h4>
			<p class="list-group-item-text">
				Plus us on Google+</p>
		</a><a href="<?php echo $twitter; ?>" class="list-group-item twitter">
			<h3 class="pull-right">
				<i class="fa fa-twitter-square"></i>
			</h3>
			<h4 class="list-group-item-heading count">
				Twitter</h4>
			<p class="list-group-item-text">
				Follow us on Twitter</p>
		</a>
	</div>
			
	<div><form action="process.php" method="post" id="analyse">
			<div class="input-group">
			  <input type="text" class="form-control" name="url" id="url" placeholder="<?php echo $lang['8']; ?>">
			  <span class="input-group-btn">				
<button type="submit" class="btn seo" id="check"><span class="fa fa-check-circle-o" aria-hidden="true"></span> Search</button>

			  </span>
			</div><!-- /input-group -->
		</form></div>

	

	<div><h4><?php echo $lang['54']; ?></h4>
                
        <div>
        <?php echo $ads_spot3; ?>
        </div>
                
     
	</div>
                
       
    
                
    </div>
	</div>

    

</div> 