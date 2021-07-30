<?php
session_start();

define('IN_ADMIN', true);

 
require_once('header.php');


?>

    

<?php

if (isset($_GET{'delete'}))

{

    $delete = Trim($_GET['delete']);

    $query = "DELETE FROM pages WHERE id=$delete";

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

?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Manage Page
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin/index.php">Admin</a></li>
            <li class="active">Manage Domain Analyzer </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Custom Pages List</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
                <?php
                if(isset($msg)){
                    echo $msg;
                }?>
                <br />
                
    <a href="add-page.php" class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> Add new page</a>    
<br></br>
<?
	
	$result = mysqli_query($connection,"select * from pages order by id desc");
	if(mysqli_num_rows($result)<=0){echo"<center><font color=red>No data</font</center>";}else{
	$sobanghi=11; //Số thể loại hiển thị trong 1 trang
	$sotrang = ceil(mysqli_num_rows($result)/$sobanghi);
	
	if(isset($_GET["page"])){
		$page = intval($page);
	}else{
		$page = 1;
	}
	
	if ($page<=0) $page=1;
	if ($page>$sotrang)  $page=$sotrang;
	$result2=mysqli_query($connection,"select * from pages order by id desc limit ".($page-1)*$sobanghi.",".$sobanghi);
	?>            

	
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="custom_Page">

                	<thead>

                		<tr>


                              <th>Page Name</th>

                              <th>Page Title</th>

                              <th>Edit</th>

                              <th>Delete</th>

                		</tr>

                	</thead>         

                    <tbody>                        

	<? while($r=mysqli_fetch_array($result2)){?>
		<tr>
	<td class="fr"><?=$r['pagename'];?></td>
    <td class="fr"><?=$r['pagetitle'];?></td>
    <td class="fr_2"><a class="btn btn-info btn-xs" href="../admin/edit-page.php?id=<?=$r['id'];?>"> <span class="glyphicon glyphicon-edit"></span> Edit</a></td>
	<td class="fr_2"><a title="Delete" href="../admin/pages.php?delete=<?=$r['id'];?>" class="btn btn-danger btn-xs"> <span class="glyphicon glyphicon-remove"></span> Delete</a></td>
  </tr>	

  <? }}?>  
  
                    </tbody>

                </table>
 <? showPageNavigation($page,$sotrang, '','?page=');?>               
                <br />
                
                </div><!-- /.box-body -->

              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div>
<?php
require_once(ADMIN_DIR.'footer.php');
?>