<?php
session_start();

define('IN_ADMIN', true);


if(!isset($_SESSION['login'])){

header("Location: login.php");

exit();

}

require_once('header.php');


 


$query = "SELECT * FROM site_config";

$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_array($result))

{

    $title = Trim($row['title']);

    $description= Trim($row['description']);

    $keyword = Trim($row['keyword']);

    $contact_email = Trim($row['email']);

    $verify_code = Trim($row['verify_code']);

    $domain_name =  Trim($row['domain_name']);
	
	$facebook =  Trim($row['facebook']);
	
	$twitter =  Trim($row['twitter']);
	
	$google =  Trim($row['google']);


}

$domain = $_SERVER['HTTP_HOST'];



if ($_SERVER['REQUEST_METHOD'] == 'POST')

{

    $title = Trim($_POST['title']);

    $description = Trim($_POST['description']);

    $keyword = Trim($_POST['keyword']);
	
    $contact_email = Trim($_POST['email']);


	$verify_code_post =  mysqli_real_escape_string($connection,htmlspecialchars($_POST['verify_code']));

	$domain_name =  Trim($_POST['domain_name']);
	
	$facebook =  Trim($_POST['facebook']);
	
	$twitter =  Trim($_POST['twitter']);
	
	$google =  Trim($_POST['google']);

    $query = "UPDATE site_config SET title='$title', description='$description', keyword='$keyword', email='$contact_email', verify_code='$verify_code_post', domain_name='$domain_name', facebook='$facebook', twitter='$twitter', google='$google' WHERE id='1'";

    if (!mysqli_query($connection, $query))

    {

        $msg = '<div class="alert alert-success" role="alert">
							Settings: ' . mysqli_error($connection) . '
						</div>';

    } else

    {

        $msg = '<div class="alert alert-success" role="alert">
							Settings saved successfully
						</div>';

    }



}


?>

      <div class="content-wrapper">

        <section class="content-header">

          <h1>

            Website Settings   

            <small>Website Settings </small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="/admin/index.php">Admin</a></li>

            <li class="active">Website Settings  </li>

          </ol>

        </section>



        <!-- Main content -->

        <section class="content">



              <div class="box box-primary">

                <div class="box-header with-border">

                  <h3 class="box-title">General Settings</h3>

                </div><!-- /.box-header -->

                <form action="#" method="POST">

                <div class="box-body">

                


                    <div class="row" style="padding-left: 5px;">

                        <div class="col-md-12">

                                        <br />

                                        <div class="form-group">

                                            <label for="title">Title Tag</label>

                                            <input type="text" placeholder="Enter title of your site" id="title" name="title" value="<?php echo $title; ?>" class="form-control">

                                        </div>

                                        <div class="form-group">

                                            <label for="description">Meta description</label>

                                            <input type="text" placeholder="Enter description" id="description" name="description"  value="<?php echo $description; ?>" class="form-control">

                                        </div>

                                        <div class="form-group">

                                            <label for="keyword">Meta Keyword</label>

                                            <input type="text" placeholder="Enter keywords (separated by comma)" value="<?php echo $keyword; ?>"  id="keyword" name="keyword" class="form-control">

                                        </div>


                                        <div class="form-group">

                                            <label for="email">Contact Email</label>

                                            <input type="text" placeholder="Enter website contact email" id="email" value="<?php echo $contact_email; ?>" name="email" class="form-control">

                                        </div>

                                        

                                       <br />

                                       
										

										<div class="form-group">

                                            <label for="footer_tags">Webmaster Tool:</label> <small>(Console, Analytics, Bing, Alexa, Yandex code,...)</small>

                                            <textarea placeholder="Enter your Webmaster Tool" rows="3" id="verify_code" name="verify_code" class="form-control"><?php echo $verify_code; ?></textarea>

                                        </div>

										

										<div class="form-group">

                                            <label for="footer_tags">Domain Name:</label> <small>(Display on Footer Page)</small>

                                            <input type="text" placeholder="Enter your Domain Name" id="domain_name" name="domain_name" value="<?php echo $domain_name; ?>" class="form-control">

									

                                        </div>
										
										
										<div class="form-group">

                                            <label for="footer_tags">Facebook:</label>

                                            <input type="text" placeholder="Enter your Facebook url" id="facebook" name="facebook" value="<?php echo $facebook; ?>" class="form-control">

									

                                        </div>
										
										
										<div class="form-group">

                                            <label for="footer_tags">Twitter:</label>

                                            <input type="text" placeholder="Enter your Twitter url" id="twitter" name="twitter" value="<?php echo $twitter; ?>" class="form-control">

									

                                        </div>
										
										
										<div class="form-group">

                                            <label for="footer_tags">Google:</label>

                                            <input type="text" placeholder="Enter your Google url" id="google" name="google" value="<?php echo $google; ?>" class="form-control">

									

                                        </div>

									
										

           </div>

                    </div>

                <input type="submit" name="save" value="Save Changes" class="btn btn-primary"/>

                <br /> <br />

                

                </div><!-- /.box-body -->

                </form>

              </div><!-- /.box -->

      

        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
<?php
require_once(ADMIN_DIR.'footer.php');
?>
     