<?php
session_start();

define('IN_ADMIN', true);
 
require_once('header.php');

?>


<main class="homepage">
<section class="bg">
<div class="container-fluid">
<div>
<h1><?php echo $lang['9']; ?></h1>
<h2><?php echo $lang['10']; ?></h2>
<div class="col-md-12 home-search">
		<div class="col-md-12 text-center">
		<span>



<form class="form-inline" action="process.php" method="post">
<div class="form-group form-group-lg">
<input type="text" class="form-control" id="url" size="50" name="url" placeholder="<?php echo $lang['8']; ?>" autocomplete="off"></div>
<div class="btn-group btn-group-lg"><button type="submit" class="btn seo" id="check"><span class="fa fa-check-circle-o" aria-hidden="true"></span> Check Up!</button></div></form>
<div class="col-md-12">
                                        <h5 class="al-center">
                                            <?php echo $lang['11']; ?>
                                        </h5>
                                    </div>
		</span>
		</div>
<center>
        <?php echo $ads_spot2; ?>
        </center>

	</div></div></div></section>


<section class="site-about" id="services">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12">
				<h3><span><?php echo $lang['12']; ?></span></h3>
				<p><?php echo $lang['60']; ?></p>
				<br></br>
                   
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa fa-star fa-5x blue_color"></span>
                                <h4>
                                    <strong><?php echo $lang['13']; ?></strong>
                                </h4>
                                <p><?php echo $lang['17']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                               <span class="fa fa-link fa-5x blue_color"></span>
                                <h4>
                                    <strong><?php echo $lang['14']; ?></strong>
                                </h4>
                                <p><?php echo $lang['18']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa fa-flash fa-5x blue_color"></span>
                                <h4>
                                    <strong><?php echo $lang['15']; ?></strong>
                                </h4>
                                <p><?php echo $lang['19']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa fa-globe fa-5x blue_color"></span>
                                <h4>
                                    <strong><?php echo $lang['16']; ?></strong>
                                </h4>
                                <p><?php echo $lang['20']; ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<br></br>


			<div class="row text-center">
			<h3><span><?php echo $lang['61']; ?></span></h3>
			<p><?php echo $lang['62']; ?></p>
			<br></br>
			<?php
			$query =  "SELECT * FROM domain ORDER BY id DESC LIMIT 4";

			$result = mysqli_query($connection,$query);


			while($row = mysqli_fetch_array($result)) {

				$domain = Trim($row['domain']);
			?>
			<div class="thumb col-xs-6 col-sm-3"><a href="/domain/<?php echo $domain; ?>" title="<?php echo ucwords($domain);?>"><img src="http://free.pagepeeker.com/v2/thumbs.php?size=l&url=<?php echo $domain; ?>" alt="<?php echo ucwords($domain);?>" class="img-thumbnail"></a></div>
			<?php
			}
			?>
			</div>

			</div>
			<!-- /.container -->
		</section>
	



<section>
<div class="container">
            <div class="row text-center">
                <div class="col-lg-10">

</div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
</section>



</main>
</div>


<?php
require_once('footer.php');
?>