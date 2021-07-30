<?php

session_start();

define('IN_ADMIN', true);
 
require_once('header.php');

?>


    <div class="container main-container">

        <div class="row">

            <div class="col-md-9" style="min-height:700px">

            <div class="row">

             
<?
	
	$result = mysqli_query($connection,"select * from domain order by date desc");
	if(mysqli_num_rows($result)<=0){echo"<center><font color=red>No data</font></center>";}else{
	$sobanghi=30; //Số thể loại hiển thị trong 1 trang
	$sotrang = ceil(mysqli_num_rows($result)/$sobanghi);
	
	if(isset($_GET["page"])){
		$page = intval($_GET["page"]);
	}else{
		$page = 1;
	}
	
	if ($page<=0) $page=1;
	if ($page>$sotrang)  $page=$sotrang;
	$result2=mysqli_query($connection,"select * from domain order by date desc limit ".($page-1)*$sobanghi.",".$sobanghi);
	$i=1;
	?>      

<h3 class="recently"><?php echo $lang['53']; ?></h3>
<center>
        <?php echo $ads_spot2; ?>
        </center>
<div class="table-responsive">	
	
		
		<table class="table table-bordered table-striped">
	<thead>
		<tr>
		    <th scope="col">No.</th>
			<th scope="col">Domain</th>
			<th scope="col">Pagerank</th>
			<th scope="col">Alexa Rank</th>
		</tr>
	</thead>
	<tbody>
		
		<? while($r=mysqli_fetch_array($result2)){
			$alexa_global_rank =  Trim($r['alexa_global_rank']);
			$pr =  Trim($r['pr_rank']);
			
		?>
		<tr>
		    <td >#<?php echo $i;?></td >
			<td>
				<img src="https://s2.googleusercontent.com/s2/favicons?domain_url=<?=$r['domain'];?>" width="16" height="16" alt="<?=$r['domain'];?>" title="<?=$r['domain'];?>" style="opacity: 1;">
				<a href="/domain/<?=$r['domain'];?>" title="<?=$r['domain'];?>"><?=$r['domain'];?></a>
			</td>
			<td>
				<img width="80" height="15" alt="PR<?php echo $pr; ?>" src="assets/img/page-rank/pr<?php echo $pr; ?>.gif" style="opacity: 1;">
			</td>
			<td>
			<span class="in-block alexaR v-align-t"></span>
				<?php if($alexa_global_rank != ''){?>					
				#<?php echo number_format((int)$alexa_global_rank , 0, '.', ',');?>
				<?php }else{
				echo '-';
				}?>
			</td>
           
		</tr>
		
			 <? $i++; }?> 
		</tbody>
	</table>
 </div>
<div class="text-center"><? showPageNavigation($page,$sotrang, '','recent/');?></div>
  <?}?> 


            </div>

            

            </div>

            <?php 

            // Sidebar 

            require_once("sidebar.php"); 

            ?>

        </div>

    </div>

    <br />
	
	<?php
require_once('footer.php');
?>