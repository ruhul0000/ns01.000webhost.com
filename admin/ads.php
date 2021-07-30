<?php
session_start();

define('IN_ADMIN', true);

 
require_once('header.php');

?>


<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST')

{

    $ads_spot1 = Trim($_POST['ads_spot1']);

    $ads_spot2 = Trim($_POST['ads_spot2']);

    $ads_spot3 = Trim($_POST['ads_spot3']);



    $query = "UPDATE site_ads SET ads_spot1='$ads_spot1', ads_spot2='$ads_spot2', ads_spot3='$ads_spot3' WHERE id='1'";


   if (!mysqli_query($connection, $query))

    {

        $msg = '<div class="alert alert-danger" role="alert">
						Ads saved error!
					</div>';

    } else

    {

        $msg = '<div class="alert alert-success" role="alert">
						Ads saved successfully
					</div>';

    }



}



$query = "SELECT * FROM site_ads";

$result = mysqli_query($connection,$query);

while ($row = mysqli_fetch_array($result))

{

    $ads_spot1 = Trim($row['ads_spot1']);

    $ads_spot2 = Trim($row['ads_spot2']);

    $ads_spot3 = Trim($row['ads_spot3']);

}

?>
 <div class="content-wrapper" style="min-height: 360px;">
        <!-- Content Header (Page header) -->
       <section class="content-header">

          <h1>

            Manage Ads 

            <small>Control panel</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="/admin/index.php">Admin</a></li>

            <li class="active">Manage Ads </li>

          </ol>

        </section>

        <!-- Main content -->
        <section class="content">
			<div class="box box-primary">
			 <div class="box-header with-border">

                  <h3 class="box-title">Site Ads Settings</h3>

                </div><!-- /.box-header -->

				<form class="form-horizontal" method="post">
				<div class="box-body">
						<?php
						if(isset($msg)){
							echo $msg;
						}?>
						<br />		
						<div class="form-group">
						<label for="ads_spot1" class="col-sm-2 control-label">Ads 728x90</label>
						<div class="col-sm-10">
						<textarea class="form-control" id="ads_spot1" rows="3" name="ads_spot1" placeholder="Top Ad 728x90"><?php echo $ads_spot1; ?></textarea>
						</div>
						</div>
						
						<div class="form-group">
						<label for="ads_spot2" class="col-sm-2 control-label">Ads 728x90</label>
						<div class="col-sm-10">
						<textarea class="form-control" id="ads_spot2" rows="3" name="ads_spot2" placeholder="Footer Ad 728x90"><?php echo $ads_spot2; ?></textarea>
						</div>
						</div>
						
						<div class="form-group">
						<label for="ads_spot3" class="col-sm-2 control-label">Ads 400x300</label>
						<div class="col-sm-10">
						<textarea class="form-control" id="ads_spot3" rows="3" name="ads_spot3" placeholder="Report Page Sidebar 400x300"><?php echo $ads_spot3; ?></textarea>
						</div>
						</div>
					<div class="box-footer">
						<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
						</div>
						</div>
					</div>
					</div>
					</form>
			</div>

        </section><!-- /.content -->
      </div>   
<?php
require_once(ADMIN_DIR.'footer.php');
?>