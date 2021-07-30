<?php
session_start();

define('IN_ADMIN', true);

 
require_once('header.php');


?>

    
<?php

if (isset($_GET{'delete'}))

{

    $delete = Trim($_GET['delete']);

    $query = "DELETE FROM domain WHERE id=$delete";

    $result = mysqli_query($connection, $query);



    if (mysqli_errno($connection))
    {
        $msg = '<div class="alert alert-danger" role="alert">
						Delete error!
					</div>';
    } else
    {
        $msg = '<div class="alert alert-success" role="alert">
						Delete successfully!
					</div>';
    }
}

if (isset($_GET{'block'}))

{

    $block = Trim($_GET['block']);

    $query = "UPDATE domain SET block = 1 where id = '$block'";

    $result = mysqli_query($connection, $query);



    if (mysqli_errno($connection))
    {
        $msg = '<div class="alert alert-danger" role="alert">
						Block error!
					</div>';
    } else
    {
        $msg = '<div class="alert alert-success" role="alert">
						Block successfully!
					</div>';
    }
}
if (isset($_GET{'unblock'}))

{

    $unblock = Trim($_GET['unblock']);

    $query = "UPDATE domain SET block = 0 where id = '$unblock'";

    $result = mysqli_query($connection, $query);



    if (mysqli_errno($connection))
    {
        $msg = '<div class="alert alert-danger" role="alert">
						UnBlock error!
					</div>';
    } else
    {
        $msg = '<div class="alert alert-success" role="alert">
						UnBlock successfully!
					</div>';
    }
}
?>
   
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Manage Domain
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin/index.php">Admin</a></li>
            <li class="active">Manage Domain</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Report Domain List</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                <?php
                if(isset($msg)){
                    echo $msg;
                }?>
                <br />
                
 <?
	
	$result = mysqli_query($connection,"select * from domain order by date desc");
	if(mysqli_num_rows($result)<=0){echo"<center><font color=red>No data</font</center>";}else{
	$sobanghi=10; //Số thể loại hiển thị trong 1 trang
	$sotrang = ceil(mysqli_num_rows($result)/$sobanghi);
	
	if(isset($_GET["page"])){
		$page = intval($_GET["page"]);
	}else{
		$page = 1;
	}
	
	if ($page<=0) $page=1;
	if ($page>$sotrang)  $page=$sotrang;
	$result2=mysqli_query($connection,"select * from domain order by date desc limit ".($page-1)*$sobanghi.",".$sobanghi);
	?>            
 	
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="domain_Analyzer">
                	<thead>
                		<tr>
                           
                              <th>Domain</th>
                              <th>IP</th>
                              <th>Added Date</th>
                              <th>Details</th>
<th>Block</th>
							  <th>Delete</th>
                		</tr>
                	</thead>         
                    <tbody>  
<? while($r=mysqli_fetch_array($result2)){?>
					<tr>
	<td class="fr"><?=$r['domain'];?></td>
    <td class="fr"><?=$r['ip'];?></td>
    <td class="fr_2"><span class="ngay_cm"><?=$r['date'];?></span></td>
    <td class="fr_2"><a title="Details" target="_blank" href="../domain/<?=$r['domain'];?>" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-globe"></span> Details</a></td>
	<td class="fr_2">
	<?php
	$site_block =  $r['block'];
	if($site_block==0){
		echo '<a title="Block" href="../admin/domain.php?block='.$r['id'].'" class="btn btn-info btn-xs"> <span class="glyphicon glyphicon-eye-close"></span> Site Block</a>';
	}else{
		echo '<a title="Block" href="../admin/domain.php?unblock='.$r['id'].'" class="btn btn-warning btn-xs"> <span class="glyphicon glyphicon-eye-open"></span> Un-Block</a>';
	}
	?>
	</td>
	<td class="fr_2"><a title="Delete" href="../admin/domain.php?delete=<?=$r['id'];?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Delete</a></td>
  </tr>	

  <? }?>  
                    </tbody>
                </table>
<? showPageNavigation($page,$sotrang, '','?page=');?>
  <? }?> 


                <br />
                
                </div><!-- /.box-body -->

              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php
require_once(ADMIN_DIR.'footer.php');
?>