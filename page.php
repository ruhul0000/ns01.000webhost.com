<?php

session_start();

define('IN_ADMIN', true);

 
require_once('header.php');

$permalink = Trim($_GET['permalink']); 

$query = mysqli_query($connection, "SELECT * FROM pages WHERE permalink='$permalink'");

if (mysqli_num_rows($query) > 0)

{

    $data = mysqli_fetch_array($query);

    

    $editID = $data['id'];

    $pagename = $data['pagename'];

    $permalink = $data['permalink'];

    $pagetitle = $data['pagetitle'];

    $pagedescription = $data['pagedescription'];

    $pagecontent = $data['pagecontent'];

} 
?>


    <div class="container main-container">

        <div class="row">

            <div class="col-md-9" style="min-height:700px">

            <div class="row">

             

              <div class="col-md-11 post">

              <div class="romantic_free">

                <h4 style="margin-left: 2px; font-size: 24px;"><?php echo ucfirst($pagetitle); ?></h4>

                  </div>


              </div>

            </div>

            

                <hr /><br />

                

                <?php echo $pagecontent; ?>

                


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