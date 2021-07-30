<?php
session_start();

define('IN_ADMIN', true);


 
 require_once('header.php');
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<?php
if (isset($_GET{'id'}))
{


    $page_id = Trim($_GET['id']);

    $sql = "SELECT * FROM pages where id='$page_id'";

    $result = mysqli_query($connection, $sql);





    while ($row = mysqli_fetch_array($result))

    {

        $page_ID = $row['id'];

        $page_name = $row['pagename'];

        $page_url = $row['permalink'];

        $page_title = $row['pagetitle'];

        $pagedescription = $row['pagedescription'];

        $page_content = $row['pagecontent'];

    }

}


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$page_name = Trim($_POST['pagename']);

	$page_url = Trim($_POST['permalink']);

	$page_title = Trim($_POST['pagetitle']);

	$pagedescription = Trim($_POST['pagedescription']);

	$page_content = Trim($_POST['pagecontent']);
	
	$page_ID = Trim($_POST['page_id']);
	
	$query = "UPDATE pages SET pagename='$page_name', permalink='$page_url', pagetitle='$page_title', pagedescription='$pagedescription', pagecontent='$page_content' WHERE id='$page_ID'";

	if (!mysqli_query($connection, $query))
	{

		$msg = '<div class="alert alert-danger" role="alert">
						Settings saved error!
					</div>
				';

	} else

	{

		$msg = '<div class="alert alert-success" role="alert">
						Settings saved successfully
					</div>
				';
				
	}

}


?>
    
   
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Edit Custom Pages Details
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin/index.php">Admin</a></li>
            <li class="active">Edit Custom Pages Details </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Custom Pages Details</h3>
                </div><!-- /.box-header -->

               
                <form method="post">
                <div class="box-body">
					 <?php
						if(isset($msg)){
							echo $msg;
						}?>
					<br />
				
					<div class="form-group">
						<label for="pagename">Page Name</label>
						<input type="text" class="form-control" id="pagename" name="pagename" value="<?php echo $page_name; ?>" placeholder="Pagename (required)">
						</div>
						
						<div class="form-group">
						<label for="permalink">Page permalink</label>
						<input type="text" class="form-control" id="permalink" name="permalink" value="<?php echo $page_url; ?>" placeholder="permalink (required)">
						</div>
						
						<div class="form-group">
						<label for="pagetitle">Page Title</label>
						<input type="text" class="form-control" id="pagetitle" name="pagetitle" value="<?php echo $page_title; ?>" placeholder="Title (required)">
						</div>
						
						<div class="form-group">
						<label for="pagedescription">Meta Description</label>
						<textarea class="form-control" id="pagedescription" name="pagedescription" rows="3" placeholder="Page Description (optional)"><?php echo $pagedescription; ?></textarea>
						</div>
						
						<div class="form-group">
						<label for="pagecontent">Page Content</label>
						<textarea id="editor1" name="pagecontent" class="form-control"><?php echo $page_content; ?></textarea>
						</div>
						<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_ID; ?>" />
						<div class="box-footer">
						<button type="submit" name="submit" class="btn btn-primary">Save Page</button>
						</div>
					</div>
					</form>
				
			</div>

              </div><!-- /.box -->
      
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php
require_once(ADMIN_DIR.'footer.php');
?>
<script type="text/javascript">
  $(function () {
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace('editor1');
  });
</script>
