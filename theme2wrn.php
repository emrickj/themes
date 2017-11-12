<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
   $name = $_POST['name'];
   $email = $_POST['email'];
   $subject = $_POST['subject'];
   $message = $_POST['message'];
   
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   if ($name!="") {
      // echo $subject." ".$message." ".$name." ".$email;
      
   }
   if(isset($_GET['u']) && $_GET['u']!="") $b = "_".$_GET['u'];
      else $b="";
   // echo "--".$b."--";

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";
   
   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   $xml2=simplexml_load_file("data/website2.xml") or die("Error: Cannot create object");
   //print_r($xml);
   //echo $xml->image[1];

   require 'dspmenu.php';
   require 'dspcnt.php';
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
@media (min-width: 576px) {
	form label {text-align: right;}
}
<?php 
   echo $xml->style;
   echo "</style>\n";
   echo "</head>\n";
   echo "<body class='page".$p."' id='demo'>\n";
?>
<nav class="navbar navbar-expand-md bg-warning navbar-light">
  <a class="navbar-brand" href="#"><?php echo $xml->title ?></a>
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">
	<span class="navbar-toggler-icon"></span>
  </button>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="navbar-nav">
        <?php displayMenu_nb($p) ?>
      </ul>
    </div>
</nav>
   <div class="container">
      <div class="row">
         <div class="col-md-2">
         </div>
         <div class="col-md-8">
            <?php
            if(strlen($xml->page[$p-1]->image)>4)
               echo "<img class='img-fluid' src='".$xml->page[$p-1]->image."'>\n";
            ?>
            <br>
         </div>
         <div class="col-md-2">
         </div>
      </div>
      <div class="row">
         <div class="col-md-2">
         </div>
         <div class="col-md-8">
                     <?php
                        if($name=="") dispContents($p,ltrim($b,"_"));
                           else if(sendEmail($name,$email,$subject,$message))
                              echo "Contact Information Submitted.  Thank you.";
                        if($xml->page[$p-1]['type']=="form" && $name=="") {
                     ?>
                           <form class="form-horizontal" role="form" method="post">
                              <div class="form-group row">
                                 <label class="col-form-label col-sm-4" for="name">Name:</label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-form-label col-sm-4" for="email">Email Address:</label>
                                 <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-form-label col-sm-4" for="subject">Subject:</label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="subject">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-form-label col-sm-4" for="message">Message:</label>
                                 <div class="col-sm-6">
                                    <textarea class="form-control" rows="5" name="message"></textarea>
                                    <br>
                                    <input type="submit" class="btn btn-warning" value="Submit">
                                 </div>
                              </div>
                           </form><?php
                        }
                     ?>          
         </div>
         <div class="col-md-2">
         </div>
      </div>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</body>
</html>