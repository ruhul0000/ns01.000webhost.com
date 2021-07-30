<?php
if (!defined('IN_ADMIN')) die("Hacking attempt");

?>


<footer id="footer" class="midnight-blue">
  <div class="container">
    <div class="row">
      <p class="text-center">Copyright © <?php echo date("Y"); ?> <a href="/"><?php echo $domain_name; ?></a> All rights reserved. SHARED ON CODELIST.CC</p>


<p class="text-center">
<?php
		  
			$query = "SELECT * FROM pages"; 
			
			$result = mysqli_query($connection, $query);
			$numResults = mysqli_num_rows($result);
			$counter = 0;
			while($row = mysqli_fetch_array($result)) {
				$permalink = Trim($row['permalink']);
				$pagename = Trim($row['pagename']);
				echo '<a href="page/'.$permalink.'/">'.$pagename.'</a>';
				if( $counter == $numResults-1){ 


				}else{ //-- Okay, this isn't the last row 

					echo ' <span class="separator">|</span> ';

				}
				$counter++;
			}
	
?>

</p>
    </div>
  </div>
</footer>


<div class="modal fade M in" id="Modal_My_History_Site" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="ModalLabel">My Browsing History</h4>
			</div>
			<div class="modal-body">
			<ul class="list-unstyled">
			<?php
				$ipaddress = RealIpAddress();
				
				$query =  "SELECT * FROM domain WHERE ip =  '$ipaddress' ORDER BY DATE DESC LIMIT 10";

				$result = mysqli_query($connection,$query);										   
				if(mysqli_num_rows($result)<1){
				   echo '<div class="text-center text-warning">No history site found.</div>';
				}
				else {
				
				while($row = mysqli_fetch_array($result)) {

				$domain = $row['domain'];
				$date = $row['date'];

				?>
				
					<li class="row">
						<div class="col-sm-3">
							<a href="/domain/<?php echo $domain; ?>/"><img alt="<?php echo $domain; ?>" title="<?php echo $domain; ?>" src="http://free.pagepeeker.com/v2/thumbs.php?size=t&url=<?php echo $domain; ?>" class="img-thumbnail" style="opacity: 1;"></a>
						</div>
						<div class="col-sm-9">
							<h5 class="clearfix m0">
								<img src="https://s2.googleusercontent.com/s2/favicons?domain_url=<?php echo $domain; ?>" width="16" height="16" alt="<?php echo $domain; ?>" title="<?php echo $domain; ?>">
								<a href="/domain/<?php echo $domain; ?>/" title="<?php echo $domain; ?>"><?php echo $domain; ?></a>
							</h5>
							<small class="clearfix text-green">
								<a href="/domain/<?php echo $domain; ?>/" title="statscrop.com"><?php echo $domain; ?></a>
							</small>
							<small class="clearfix text-grey" title="<?php echo $date; ?>"><?php echo $date; ?></small>
						</div>
					</li>
				<?php 
					}
					
				}

				 ?>	
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

<script src="assets/js/script.js" type="text/javascript"></script>



</body>

</html>