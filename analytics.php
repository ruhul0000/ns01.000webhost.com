<?php
session_start();

define('IN_ADMIN', true);

define('D_S',DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath(dirname(__FILE__)) .D_S);
define('INCLUDE_DIR', ROOT_DIR .'include'.D_S);


require(ROOT_DIR.'config.php');
require(INCLUDE_DIR.'application.php');

require(INCLUDE_DIR.'lang_en.php');


// Check installation
$filename = 'install/install.php';

if (file_exists($filename)) {
    echo "<br /> <br />  <center>Redirecting to installer panel...</center>";
    echo '<meta http-equiv="refresh" content="1;url=/install/install.php">';
    exit();
} 

//Database Connection

$connection = dbConncet($dbHost,$dbUser,$dbPass,$dbName);


$query =  "SELECT * FROM site_config";

$result = mysqli_query($connection,$query);

        

while($row = mysqli_fetch_array($result)) {

    $title = Trim($row['title']);

    $description= Trim($row['description']);

    $keyword = Trim($row['keyword']);

    $contact_email = Trim($row['email']);

	
	$verify_code =  Trim($row['verify_code']);

	$domain_name =  Trim($row['domain_name']);

	$facebook =  Trim($row['facebook']);
	
	$twitter =  Trim($row['twitter']);
	
	$google =  Trim($row['google']);

}


//Get Ads Settings

$query = "SELECT * FROM site_ads";

$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_array($result))

{

    $ads_spot1 = Trim($row['ads_spot1']);

    $ads_spot2 = Trim($row['ads_spot2']);

    $ads_spot3 = Trim($row['ads_spot3']);

}


$url = htmlentities(strip_tags($_GET['domain']));

?>

<!DOCTYPE html>

<html>

    <head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

      <base href="/" />      

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <meta http-equiv="Content-Language" content="en" />

        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Meta Data-->

        <title><?php echo $url; ?> <?php if(isset($title)) { echo $title; } ?></title>

              
        <meta name="description" content="<?php echo $description; ?>" />

        <meta name="keywords" content="<?php echo $keyword; ?>" />

        <?php echo html_entity_decode($verify_code); ?>

        <link href="assets/css/theme.css" rel="stylesheet" />

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

		<script type='text/javascript' src='https://www.google.com/jsapi'></script>

</head>



<body>   


<div class="navbar-more-overlay"></div>
	<nav class="navbar navbar-inverse navbar-fixed-top animate">
		<div class="container navbar-more visible-xs">
			<form class="navbar-form navbar-left" action="process.php" method="post">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" name="url" id="url" placeholder="<?php echo $lang['8']; ?>">
						<span class="input-group-btn">
							<button type="submit" class="btn seo" id="check"><span class="fa fa-check-circle-o" aria-hidden="true"></span> Check Up!</button>
						</span>
					</div>
				</div>
			</form>
			<ul class="nav navbar-nav">
			<?php
		  
			$query = "SELECT * FROM pages"; 
			
			$result = mysqli_query($connection, $query);
			$numResults = mysqli_num_rows($result);
			$counter = 0;
			while($row = mysqli_fetch_array($result)) {
				$permalink = Trim($row['permalink']);
				$pagename = Trim($row['pagename']);
			?>
				<li>
					<a href="page/<?php echo $permalink; ?>/">
						<span class="menu-icon fa fa-angle-double-right"></span>
						<?php echo $pagename; ?>
					</a>
				</li>
			<?php				
				}

			?>

			<li>
				<a href="/contact/">
					<span class="menu-icon fa fa-angle-double-right"></span>						
					Contact Us</span>
				</a>
			</li>

			</ul>
		</div>
		<div class="container">
			<div class="navbar-header hidden-xs">
				<a class="navbar-brand" href="/" title="SeoStats"><img src="assets/img/logo_seostats.png" class="img-responsive" alt="SeoStats"></a>

			</div>

			<ul class="nav navbar-nav navbar-right mobile-bar">
				<li>
					<a href="/">
						<span class="menu-icon fa fa-home"></span>
						<span class="hidden-xs"><span class="fa fa-home" aria-hidden="true"></span> <?php echo $lang['1']; ?></span>
						<span class="visible-xs"> <?php echo $lang['1']; ?></span>
						
					</a>
				</li>
				<li>
					<a href="/recent/">
						<span class="menu-icon fa fa-bar-chart"></span>
						<span class="hidden-xs"><span class="fa fa-clock-o" aria-hidden="true"></span> <?php echo $lang['2']; ?></span>
						<span class="visible-xs"><?php echo $lang['3']; ?></span>
					</a>
				</li>
				<li class="hidden-xs">
					<a href="/contact/"><span class="fa fa-envelope"></span>
					<span class="hidden-xs"><?php echo $lang['4']; ?></span>
						  
					</a>
				</li>

				<li>
					<a href="#" data-target="#Modal_My_History_Site" data-toggle="modal">

						<span class="menu-icon fa fa-star"></span>
						<span class="hidden-xs"><span class="fa fa-clock-o" aria-hidden="true"></span> <?php echo $lang['5']; ?></span>
						<span class="visible-xs"><?php echo $lang['6']; ?></span>
						  
					</a>
				</li>
				
				
				<li class="visible-xs">
					<a href="#navbar-more-show">
						<span class="menu-icon fa fa-bars"></span>
						<?php echo $lang['7']; ?>
					</a>
				</li>
			</ul>
		</div>
	</nav>

<?php

if (isDomainAvailible('http://'.$url))
{
    $url = getDomainName($url);
	
	$ip_client = RealIpAddress();

	$date = date('jS F Y h:i:s A');
	
	
	
    // Check new domain (or) not
	$qu = mysqli_query($connection, "SELECT * FROM domain WHERE domain='$url' and block = 0");
	if (mysqli_num_rows($qu) > 0)
	{
		// Already domain exits
		$error = 0;
		if(isset($_POST['update'])) {
			
			$url = strtolower(Trim($_POST['url']));
			
			$alexa = getGlobalAlexaRank($url);
			$pr_rank = google_page_rank($url);
			$safe_value = checkSafeBrowsing($url);
			$get_top_keyword_data = get_top_keyword($url);
			$get_top_country_data = get_top_country_alexa($url);
			$rec = dns_get_record($url, DNS_ALL); // get all records
			$header = get_my_headers('http://'.$url);
			$ip_host_info = get_host_info($url);
			
			$alexa_global_rank = $alexa[0];
			$alexa_pop = $alexa[1];
			$alexa_regional_rank = $alexa[2];
			$alexa_web = $alexa[3];
			$alexa_flag = $alexa[4];

			$pr = ($pr_rank == '' ? '0' : $pr_rank );

			if($safe_value == 204){
				$isSafe = true;
			}else{
				$isSafe = false;
			}

			$get_redirect = get_redirect($url);
			if($get_redirect==null){
				$get_redirect = $url;
			}

			if (strpos($get_redirect,'https') !== false) {
				$isHttps = 'https';
			} else {
				$isHttps = 'http';
			}
			
			$num_keyword = count($get_top_keyword_data)-1;
			
			$num_country = count($get_top_country_data);


			$record_count = count($rec);

			
			$ip = $ip_host_info[0];
			$country_ip = $ip_host_info[1];
			$city = $ip_host_info[2];
$as = $ip_host_info[3];
			$lat = $ip_host_info[5];
			$lon = $ip_host_info[6];
			
			$get_top_keyword_data= (array)$get_top_keyword_data;
			$get_top_keyword_data_data=mysqli_real_escape_string($connection,base64_encode(serialize($get_top_keyword_data)));
			
			$get_top_country_data = (array)$get_top_country_data;
			$get_top_country_data_data=mysqli_real_escape_string($connection,base64_encode(serialize($get_top_country_data)));
			
			$rec = (array)$rec;
			$rec_data=mysqli_real_escape_string($connection,base64_encode(serialize($rec)));
			
			$header = (array)$header;
			$header_data=mysqli_real_escape_string($connection,base64_encode(serialize($header)));
			
			$ip_host_info = (array)$ip_host_info;
			$ip_host_info_data=mysqli_real_escape_string($connection,base64_encode(serialize($ip_host_info)));

			
			
			$query_update="UPDATE domain SET ip ='$ip_client',https='$isHttps',alexa_global_rank='$alexa_global_rank',alexa_pop='$alexa_pop',alexa_global_rank='$alexa_global_rank',
alexa_pop='$alexa_pop',alexa_regional_rank='$alexa_regional_rank',alexa_web='$alexa_web',alexa_flag='$alexa_flag',pr_rank='$pr',safe_value='$isSafe',get_top_keyword_data='$get_top_keyword_data_data',get_top_country_data='$get_top_country_data_data',rec='$rec_data',header='$header_data',ip_host_info='$ip_host_info_data',block='0',date='$date' where domain='$url'";
			mysqli_query($connection,$query_update);
			
			
		}
		else{
		
		while($rs = mysqli_fetch_array($qu)) {
		
		$get_top_keyword_data= unserialize(base64_decode($rs['get_top_keyword_data']));
		$get_top_country_data= unserialize(base64_decode($rs['get_top_country_data']));
		$rec= unserialize(base64_decode($rs['rec']));
		$header= unserialize(base64_decode($rs['header']));
		$ip_host_info= unserialize(base64_decode($rs['ip_host_info']));
		$alexa_global_rank =  Trim($rs['alexa_global_rank']);
		$alexa_pop =  Trim($rs['alexa_pop']);
		$alexa_regional_rank =  Trim($rs['alexa_regional_rank']);
		$alexa_web =  Trim($rs['alexa_web']);
		$alexa_flag =  Trim($rs['alexa_flag']);
		$pr =  Trim($rs['pr_rank']);
		$isSafe =  Trim($rs['safe_value']);
                $date =  Trim($rs['date']);
		$isHttps =  Trim($rs['https']);
		
		}
		

		
		$num_keyword = count($get_top_keyword_data)-1;
		
		$num_country = count($get_top_country_data);


		$record_count = count($rec);

		
		$ip = $ip_host_info[0];
		$country_ip = $ip_host_info[1];
		$city = $ip_host_info[2];
$as = $ip_host_info[3];
		$lat = $ip_host_info[5];
		$lon = $ip_host_info[6];
		
		}
	}
	else
	{
		$query_domain = "SELECT * FROM domain WHERE domain='$url' and block = 1";

		$result_domain = mysqli_query($connection,$query_domain);
	
		if(mysqli_num_rows($result_domain) >= 1)
		{
			$error = 2;
			
		}else{
			$error = 0;
			$alexa = getGlobalAlexaRank($url);
			$pr_rank = google_page_rank($url);
			$safe_value = checkSafeBrowsing($url);
			$get_top_keyword_data = get_top_keyword($url);
			$get_top_country_data = get_top_country_alexa($url);
			$rec = dns_get_record($url, DNS_ALL); // get all records
			$header = get_my_headers('http://'.$url);
			$ip_host_info = get_host_info($url);
			
			$alexa_global_rank = $alexa[0];
			$alexa_pop = $alexa[1];
			$alexa_regional_rank = $alexa[2];
			$alexa_web = $alexa[3];
			$alexa_flag = $alexa[4];

			$pr = ($pr_rank == '' ? '0' : $pr_rank );

			if($safe_value == 204){
				$isSafe = true;
			}else{
				$isSafe = false;
			}

			$get_redirect = get_redirect($url);
			if($get_redirect==null){
				$get_redirect = $url;
			}

			if (strpos($get_redirect,'https') !== false) {
				$isHttps = 'https';
			} else {
				$isHttps = 'http';
			}
			
			$num_keyword = count($get_top_keyword_data)-1;
			
			$num_country = count($get_top_country_data);


			$record_count = count($rec);

			
			$ip = $ip_host_info[0];
			$country_ip = $ip_host_info[1];
			$city = $ip_host_info[2];
			$as = $ip_host_info[3];
			$isp = $ip_host_info[4];
			$lat = $ip_host_info[5];
			$lon = $ip_host_info[6];
			
			
			$get_top_keyword_data= (array)$get_top_keyword_data;
			$get_top_keyword_data_data=mysqli_real_escape_string($connection,base64_encode(serialize($get_top_keyword_data)));
			
			$get_top_country_data = (array)$get_top_country_data;
			$get_top_country_data_data=mysqli_real_escape_string($connection,base64_encode(serialize($get_top_country_data)));
			
			$rec = (array)$rec;
			$rec_data=mysqli_real_escape_string($connection,base64_encode(serialize($rec)));
			
			$header = (array)$header;
			$header_data=mysqli_real_escape_string($connection,base64_encode(serialize($header)));
			
			$ip_host_info = (array)$ip_host_info;
			$ip_host_info_data=mysqli_real_escape_string($connection,base64_encode(serialize($ip_host_info)));

			
			
			$query_insert="INSERT INTO domain (domain,ip,https,alexa_global_rank,alexa_pop,alexa_regional_rank,alexa_web,alexa_flag,pr_rank,safe_value,get_top_keyword_data,get_top_country_data,rec,header,ip_host_info, block, date) VALUES ('$url','$ip_client','$isHttps','$alexa_global_rank','$alexa_pop','$alexa_regional_rank','$alexa_web','$alexa_flag','$pr','$isSafe','$get_top_keyword_data_data','$get_top_country_data_data','$rec_data','$header_data','$ip_host_info_data','0','$date')";
			
			mysqli_query($connection,$query_insert);
		}
	}	
	
	
}
else
{
	$error = 3;
}

?>
 <?php 
if($error==0){
	
?>  
<script type="text/javascript">	
$(document).ready(function(){
$('#screenshot').html('<img src="http://free.pagepeeker.com/v2/thumbs.php?size=l&url=<?php echo $url; ?>" alt="screenshot of <?php echo $url; ?>" class="thumbnail center-block img-responsive"/>');
});
</script>
		
<main class="homepage">

  <div class="container main-container">

	<div class="row">
			
	<main class="col-md-9" style="min-height:700px">
	
			
<div class="row site-thumbnail">
	<div class="col-sm-12 col-md-6">
		<div id="screenshot"></div>	
		
	</div>
	<div class="col-sm-12 col-md-6">

		<table class="table table-condensed">
		    <tbody>
			  <tr><td><?php echo $lang['21']; ?>:</td><td><?php echo $alexa_web;?></td></tr>

			  <tr>
			  <td><?php echo $lang['22']; ?>:</td>
			  <td>
			  <?php if($alexa_global_rank != ''){
			  ?>
			  <img src="assets/img/globe.png" alt="Global Rank" title="Global Rank"> #<?php echo number_format((int)$alexa_global_rank , 0, '.', ',');?>
			  <?php }else{
				  echo 'No Global Rank';
			  }
			  ?>
			  </td>
			  </tr>
			  
			  <tr><td><?php echo $lang['23']; ?>:</td><td><img width="80" height="15" alt="PR<?php echo $pr; ?>" src="assets/img/page-rank/pr<?php echo $pr; ?>.gif"></td></tr>
			  <tr><td><?php echo $lang['24']; ?>:</td><td><?php 
			if($isSafe){
			?>
			<img width="16" height="16" alt="<?php echo $isSafe; ?>" src="assets/img/se_icn_green.png"> Safe Browsing		
			<?
			}else{
			?>
			<img width="16" height="16" alt="<?php echo $isSafe; ?>" src="assets/img/se_icn_red.png"> Not Safe Browsing
			<?php
			}
			?></td></tr>
			  
			<?php if($alexa_regional_rank != 'N/A'){
			  ?>
			  <tr><td><?php echo $lang['25']; ?>:</td>
			  <td>
			  
			  <img src="assets/img/country-flags/<?php echo strtolower($alexa_flag);?>.png" width="16" height="12" border="0"> <?php echo $alexa_pop; ?> 
			  
			  (Ranked <em>#<?php echo number_format((int)$alexa_regional_rank , 0, '.', ','); ?></em> in <em><?php echo $alexa_pop; ?></em>)
			  
			  </td>
			  </tr>
			  <?php }
			  ?>
			  
			  <tr><td><?php echo $lang['26']; ?>:</td><td><img src="assets/img/country-flags/<?php echo strtolower($as);?>.png" width="16" height="12" border="0"> <?php echo $city; ?>, <?php echo $country_ip; ?></td></tr>
			  <tr><td><?php echo $lang['27']; ?>:</td><td>Using <?php echo $isHttps; ?></td></tr>
			  <tr><td><?php echo $lang['28']; ?>:</td><td><?php echo $date; ?></td></tr>
			  <tr><td colspan="2">
				<a href="http://<?php echo $url; ?>" class="btn btn-sm btn-default" target="_blank" rel="nofollow"><span class="fa fa-globe"></span> <?php echo $lang['29']; ?></a>
				<button id="update_data" type="button" class="btn btn-sm btn-default"><span class="fa fa-refresh"></span> <?php echo $lang['30']; ?></button></td></tr>

				<form id="form_update" action="<?php echo'http://',$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>" method="post">
				<input name="url" id="url" type="hidden" value="<?php echo $alexa_web;?>"/>
				<input name="update" id="update" type="hidden" value="update"/>
				</form>
				<script>
				$('#update_data').click(function() {
					$('#form_update').submit();
				});
				</script>
			  </tbody>
		</table>



	</div>
</div>


		

		<center>
        <?php echo $ads_spot1; ?>
        </center>

<div class="row traffic-graph">
	<div class="col-sm-12">
		<h4>Traffic Graph</h4>
		<ul class="nav nav-tabs" role="tablist">
			<li class="active">
				<a href="#rank" data-y="t" name="rank" role="tab" data-toggle="tab" aria-expanded="true">Traffic Rank</a>
			</li>
			<li role="presentation" class="dropdown">
	<a href="#" id="TabDrop" class="dropdown-toggle" data-toggle="dropdown" aria-controls="TabDrop-contents" aria-expanded="false">More
		<span class="caret"></span></a>
	<ul class="dropdown-menu" aria-labelledby="TabDrop" id="TabDrop-contents">
		<li>
			<a href="#reach" data-y="r" name="reach" role="tab" data-toggle="tab">Reach</a>
		</li>
		<li>
			<a href="#pageviews" data-y="p" name="pageviews" role="tab" data-toggle="tab">Pageviews</a>
		</li>
		<li>
			<a href="#pageviews_per_user" data-y="u" name="pageviews_per_user" role="tab" data-toggle="tab">Pageviews/User</a>
		</li>
		<li>
			<a href="#bounce" data-y="b" name="bounce" role="tab" data-toggle="tab">Bounce %</a>
		</li>
		<li>
			<a href="#time_on_site" data-y="s" name="time_on_site" role="tab" data-toggle="tab">Time on Site</a>
		</li>
		<li>
			<a href="#top_search" data-y="q" name="top_search" role="tab" data-toggle="tab">Search %</a>
		</li>
	</ul>
</li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="rank">Traffic Ranks</div>
			<div role="tabpanel" class="tab-pane fade" id="reach">Reach per million internet users</div>
			<div role="tabpanel" class="tab-pane fade" id="pageviews">Pageviews per million internet users</div>
			<div role="tabpanel" class="tab-pane fade" id="pageviews_per_user">Daily Pageviews per Visitor</div>
			<div role="tabpanel" class="tab-pane fade" id="bounce">Bounce Rate(Percentage)</div>
			<div role="tabpanel" class="tab-pane fade" id="time_on_site">Daily Time on Site(Minute)</div>
			<div role="tabpanel" class="tab-pane fade" id="top_search">Search Traffic(Percentage)</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<img class="alexa-graph" src="http://traffic.alexa.com/graph?o=lt&amp;y=t&amp;b=ffffff&amp;n=666666&amp;f=333333&amp;p=4e8cff&amp;r=6m&amp;t=2&amp;z=30&amp;c=1&amp;h=200&amp;w=500&amp;u=<?php echo $url; ?>">
			</div>
			<div class="col-sm-12 col-md-4">
				<ul class="list-unstyled">
					<li>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active">
								<div>
									<?php if($alexa_global_rank != ''){
									?>
									<div>Global Rank:</div>
									<div>
										<img src="assets/img/globe.png" alt="Global" title="Global">
										<strong class="text-24 text-middle" title="32,326"><?php echo number_format((int)$alexa_global_rank , 0, '.', ',');?></strong>
									</div>
									<?php }
									?>
								</div>
								<div class="mt10">
									<?php if($alexa_regional_rank != 'N/A'){
									?>
									<div>
										Rank in
										<?php echo $alexa_pop; ?>
										:
									</div>
									<div>
										<img src="assets/img/country-flags/<?php echo strtolower($alexa_flag);?>.png" width="16" height="12" border="0">
										<strong class="text-24 text-middle"><?php echo number_format((int)$alexa_regional_rank , 0, '.', ',');?></strong>
									</div>

									<?php }
									?>

								</div>
							</div>
							
						</div>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
</div>
</br>
<div class="row backlink-stats">
			<div class="col-sm-12">
			<h4>General Backlink</h4>
			
			<p>Get all the links that are pointing to your website. Some of the most important backlinks for <?php echo ucwords($alexa_web);?>  (ranked by Moz's domain authority score) are listed below:</p>
	
				<div class="table-responsive">	
					
					<img src="https://majestic.com/charts/backlinks-discovery/<?php echo $alexa_web;?>?w=970&amp;h=170&amp;IndexDataSource=F" class="mje" alt="majestic 99webtools.com">
					
				</div>
			</div>
</div>
		
		
		
		<div class="row traffic-stats">
			<div class="col-sm-12">
			<h4><?php echo $lang['31']; ?></h4>
			
			<p><?php echo ucwords($alexa_web);?> is ranked #<?php echo number_format((int)$alexa_global_rank , 0, '.', ',');?> in the world and ranked #<?php echo number_format((int)$alexa_regional_rank , 0, '.', ','); ?> in <?php echo $alexa_pop; ?>, a low rank means that this website gets lots of visitors. There are <?php echo $num_keyword; ?> keywords were found. Most visitors to this web site via keywords below.</p>
				<div class="table-responsive">	
					<table class="table table-bordered table-striped">
					<thead>
					<tr><th scope="col">No.</th><th scope="col">Keyword</th><th scope="col">Search %</th></tr></thead>
					<tbody>
					<?php 
					if($get_top_keyword_data["1"]["keyword"]!=''){
						$i=1;
						unset($get_top_keyword_data["0"]) ;
						foreach($get_top_keyword_data as $keywords => $keyword){ 
						echo '<tr>
						<td>'.$i.'</td>
												<td>'.ucwords($keyword["keyword"]).'</td>
												<td>'.$keyword["percent"].'</td>
												
											</tr>';		
								$i++;	
						}
					}else{
						echo '
						<tr>
							<td>No data</td>
							<td>No data</td>
							<td>No data</td>
						</tr>
						';
						
					}

					?>

					</tbody>
					</table>
				</div>
			</div>
		</div>


<script type='text/javascript'>
  google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

   function drawRegionsMap() {
     var data = google.visualization.arrayToDataTable([
		<?php
		$data ='[\'Country\'],';
		foreach($get_top_country_data as $countrys => $country){ 
			
			$data .= '[\''.trim($country["country"]).'\'],';
		}
		
		$data = substr(trim($data), 0, -1);
		echo $data;		
	
		?>
         ]);

     var options = {legend: 'none'};

     var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

     chart.draw(data, options);
   }
</script>

<div class="row visitor-map">
	<div class="col-sm-12">
	<h4><?php echo $lang['32']; ?></h4>
	<p>There are <?php echo $num_country; ?> countries were found, most visitors to this site are from <em><?php echo $get_top_country_data[0]["country"]; ?></em> and  about <em><?php echo $get_top_country_data[0]["percent"]; ?></em> visitors per day.</p>
		<div class="row">
		<div class="col-sm-7">
		<div id='regions_div'></div>
		</div>
		<div class="col-sm-5">
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
				<thead>
				<tr><th scope="col">No.</th><th scope="col">Country</th><th scope="col">Percent</th><th scope="col">Rank</th></tr></thead>
				<tbody>
				<?php 
				
				if($get_top_country_data['0']!="null"){
					$i=1;
						foreach($get_top_country_data as $countrys => $country){ 
						echo '<tr>
						<td>'.$i.'</td>
												<td>'.ucwords($country["country"]).'</td>
												<td>'.$country["percent"].'</td>
						<td>'.$country["rank"].'</td>
												
											</tr>';		
								$i++;	
							}
					
				}else{
						echo '
						<tr>
							<td>No data</td>
							<td>No data</td>
							<td>No data</td>
							<td>No data</td>
						</tr>
						';
						
					}
				

				?>


				</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
</div>


<div class="row server-ip-address">
	<div class="col-sm-12">
		<h4><?php echo $lang['34']; ?></h4>
		<p>Each site will have one or more IP addresses. Thare are <em>1</em> ip addresses for <em><?php echo ucwords($alexa_web);?></em>, one of which is <em><?php echo $ip;?></em>, and is located in <em><?php echo $city; ?>, <?php echo $country_ip; ?></em>.</p>
	<div class="row">							
<div class="col-sm-6">
		<div class="table-responsive">	
							<table class="table table-bordered table-striped">
								
								<tbody>
									<tr>
										<td>
											Server IP:
										</td>
										<td>
											<?php echo $ip; ?>
										</td>
										
									</tr>
									<tr>
										<td>
											Server location: 									
										</td>
										<td>
											<?php echo $city; ?>, <?php echo $country_ip; ?>
										</td>
										
									</tr>
									
									<tr>
										<td>
											Lat:
										</td>
										<td>
											<?php echo $lat; ?>
										</td>
										
									</tr>
									<tr>
										<td>
											Lon:
										</td>
										<td>
											<?php echo $lon; ?>
										</td>
										
									</tr>
									
								</tbody>
							</table>
		</div>
			</div>
			<div class="col-sm-6">
				<img src="http://maps.google.com/maps/api/staticmap?center=<?php echo $lat; ?>,<?php echo $lon; ?>&amp;zoom=8&amp;size=530x240&amp;maptype=roadmap&amp;sensor=false&amp;markers=color:red|label:C|<?php echo $lat; ?>,<?php echo $lon; ?>" class="google-img" alt="google map">
			</div>
</div>
								</div>
							</div>


<div class="row http-header">
	<div class="col-sm-12">
	<h4><?php echo $lang['35']; ?></h4>
		<p>HTTP header fields are components of the message header of requests and responses in the Hypertext Transfer Protocol (HTTP). They define the operating parameters of an HTTP transaction. The header fields are not directly displayed by normal web browsers like Internet Explorer, Google Chrome, Firefox etc. Below is the HTTP Header information of <?php echo ucwords($alexa_web);?>:</p>

<div class="table-responsive">		
<table class="table table-bordered table-striped">
                                        <tbody>

<?php


    foreach ($header as $h)
					{
						?>
							 <tr>
								<td align="left" class="border-maroon"><? echo $h;?></td>
							</tr>
						<?
					}

?>

											
                       
                                       
                                       
</tbody></table>
</div>
</div>
</div>

<center>
        <?php echo $ads_spot2; ?>
        </center>

<div class="row server-location-ips">
	<div class="col-sm-12">
	<h4><?php echo $lang['36']; ?></h4>
		<p>Domain Name Systes (DNS) translates easily memorized domain names to the numerical IP addresses needed for the purpose of locating computer services and devices worldwide. There are total <?php echo $record_count; ?> DNS record(s) of <?php echo ucwords($alexa_web);?>.</p>



<div class="table-responsive">
		<table class="table table-bordered table-striped" id="dns_record">
				<thead>
					<tr>
						<th>Host</th>
						<th>Type</th>
						<th>Class</th>
						<th>TTL</th>
						<th>Target / IP</th>
					</tr>
				</thead>
				<tbody>	
				<?php
					
					foreach($rec as $link => $stat){ 
						$host = (isset($stat['host']) ? $stat['host'] : null);
						$type = (isset($stat['type']) ? $stat['type'] : null);
						$class = (isset($stat['class']) ? $stat['class'] : null);
						$ttl = (isset($stat['ttl']) ? $stat['ttl'] : null);
						$ip = (isset($stat['ip']) ? $stat['ip'] : null);
						$mname = (isset($stat['mname']) ? $stat['mname'] : null);
						$serial = (isset($stat['serial']) ? $stat['serial'] : null);
						$target = (isset($stat['target']) ? $stat['target'] : null);
						$rname = (isset($stat['rname']) ? $stat['rname'] : null);
						$minimum = (isset($stat['minimum-ttl']) ? $stat['minimum-ttl'] : null);
						
							echo '
						<tr>
							<td>'.$host.'</td>
							<td>'.$type.'</td>
							<td>'.$class.'</td>
							<td>'.$ttl.'</td>
							<td>';
							if($ip!="")
							{
								echo '<b>ip:</b> '.$ip.'<br>';
							}
							if($mname!="")
							{
								echo '<b>mname:</b> '.$mname.'<br>';
							}
							if($serial!="")
							{
								echo '<b>serial:</b> '.$serial.'<br>';
							}
							if($target!="")
							{
								echo '<b>target:</b> '.$target.'<br>';
							}
							if($rname!="")
							{
								echo '<b>rname:</b> '.$rname.'<br>';
							}						

							if($minimum!="")
							{
								echo '<b>minimum-ttl:</b> '.$minimum.'<br>';
							}

							echo '</td>
						</tr>
						';
						
						
						
						}					
						
				
				?>
				</tbody>
		</table>
</div>
</div>
</div>



			</main>
 
<?php			  	
} 
if($error == 3){
?>
<main class="homepage">

  <div class="container main-container">

	<div class="row">
			
	<main class="col-md-9" style="min-height:700px">
	
<div class="page-header">
<h1><?php echo $lang['41']; ?></h1></div>
<div class="scroller">
<p><?php echo $lang['42']; ?></p>
<h2><?php echo $lang['43']; ?></h2>
<ul>
<li><?php echo $lang['44']; ?></li>
<li><?php echo $lang['45']; ?></li>
<li><?php echo $lang['46']; ?></li></ul>
</div>
</main>
<?php
}if($error == 2){
?>

<main class="homepage">

  <div class="container main-container">

	<div class="row">
			
	<main class="col-md-9" style="min-height:700px">
	
<div class="page-header">
<h1><?php echo $lang['47']; ?></h1></div>
<div class="scroller">
<p><?php echo $lang['48']; ?></p>
<h2><?php echo $lang['49']; ?></h2>
<ul>
<li><?php echo $lang['50']; ?></li>
<li><?php echo $lang['51']; ?></li>
<li><?php echo $lang['52']; ?></li></ul>
</div>
</main>
<?php 
}
?>
			  
            <?php
            // Sidebar
            require_once("sidebar.php");
            ?>
  	</div>
</div> </main> 
		<?php
require_once('footer.php');
?>