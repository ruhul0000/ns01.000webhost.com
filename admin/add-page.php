<?php
session_start();

define('IN_ADMIN', true);

 
 require_once('header.php');
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$page_name = Trim($_POST['pagename']);

	$page_url = Trim($_POST['permalink']);

	$page_title = Trim($_POST['pagetitle']);

	$meta_des = Trim($_POST['pagedescription']);

	$page_content =  mysqli_real_escape_string($connection,Trim(htmlspecialchars($_POST['pagecontent'])));

	$query = "INSERT INTO pages (pagename,permalink,pagetitle,pagedescription,pagecontent) VALUES ('$page_name','$page_url','$page_title','$meta_des','$page_content')";

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
            Add Custom Pages Details
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin/index.php">Admin</a></li>
            <li class="active">Add Custom Pages Details </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Custom Pages Details</h3>
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
						<input type="text" class="form-control" id="pagename" name="pagename" value="" placeholder="Pagename (required)">
						</div>
						
						<div class="form-group">
						<label for="permalink">Page permalink</label>
						<input type="text" class="form-control" id="permalink" name="permalink" value="" placeholder="permalink (required)">
						</div>
						
						<div class="form-group">
						<label for="pagetitle">Page Title</label>
						<input type="text" class="form-control" id="pagetitle" name="pagetitle" value="" placeholder="Title (required)">
						</div>
						
						<div class="form-group">
						<label for="pagedescription">Meta Description</label>
						<textarea class="form-control" id="pagedescription" name="pagedescription" rows="3" placeholder="Page Description (optional)"></textarea>
						</div>
						
						<div class="form-group">
						<label for="pagecontent">Page Content</label>
						<textarea id="editor1" name="pagecontent" class="form-control"></textarea>
						</div>
						
						<div class="box-footer">
						<button type="submit" name="submit" class="btn btn-primary">Add Page</button>
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
