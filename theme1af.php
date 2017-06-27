<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
   $name = $_POST['name'];
   $phone = $_POST['phone'];
   $email = $_POST['email'];
   $message = $_POST['message'];
   
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   if(isset($_GET['u']) && $_GET['u']!="") $b = "_".$_GET['u'];
      else $b="";
   // echo "--".$b."--";

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";

   if(isset($_GET['w'])) $w = $_GET['w'];
      else $w="1";

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   $xml2=simplexml_load_file("data/website2.xml") or die("Error: Cannot create object");
   //print_r($xml);
   //echo $xml->image[1];

   require 'dspmenu_nb.php';
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
t1 { white-space: pre-wrap;}
<?php 
   echo $xml->style;
   echo "</style>\n";
   echo "</head>\n";
   echo "<body";
   if ($w=="1") echo " class='page".$p."'";
   echo " id='demo'>\n";
?>
<nav class="navbar navbar-default navbar-fixed-top hidden-sm hidden-md hidden-lg">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="<?php echo "?u=".ltrim($b,"_") ?>"><?php echo $xml->title ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <?php displayMenu($p) ?>
      </ul>
    </div>
  </div>
</nav>
   <div class="container">
      <div class="row">
         <div class="hidden-sm hidden-md hidden-lg" style="padding-top: 50px;"></div>
         <div class="col-sm-2" style="padding: 20px">
         <b><h2><?php echo $xml->title ?></h2></b>
         </div>
         <div class="col-sm-10">
            <?php
            if ($w=="1")
               if(strlen($xml->page[$p-1]->image)>4)
                  echo "<img class='img-responsive' src='".$xml->page[$p-1]->image."'>\n";
            if ($w=="2")
               if(strlen($xml2->page[$p-1]->image)>4)
                  echo "<img class='img-responsive' src='".$xml2->page[$p-1]->image."'>\n";
            ?>
            <br>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-2 hidden-xs">
                  <br>
                  <div class="btn-group-vertical btn-group-lg" style="position: fixed;">
                     <?php
                     for($i=1;$i<=6;$i++) {
                       if($i==$p && $w=="1" && $name=="") $bs="active"; else $bs="";
                       if(strlen($xml->page[$i-1]->name)>2) 
                          echo "<a href='?u=".ltrim($b,"_")."&p=".$i."' class='btn btn-primary "
                          .$bs."'>" . ic_html($xml->page[$i-1]->name) . "</a>";
                     }
                     ?>
                     <ul class="dropdown-menu" role="menu">
                     <?php
                     for($i=1;$i<=6;$i++) {
                       if($i==$p && $w=="2" && $name=="") $bs=" class='active'"; else $bs="";
                       if(strlen($xml2->page[$i-1]->name)>2) 
                          echo "<li".$bs."><a href='theme1.php?u=".ltrim($b,"_")."&w=2&p=".$i."'>"
                          . str_replace('"fa ','"fa fa-fw ',$xml2->page[$i-1]->name) . "</a></li>\n";
                     }
                     ?>
                     </ul>
                     <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                     <?php echo strip_tags($xml2->title) ?> <span class="caret"></span></button>
                  </div>
                  <br>
                  <br>
         </div>
         <div class="col-sm-10">
           <div class="panel panel-primary">
               <div class="panel-body">
                     <?php
                        if ($name=="") {
                            if ($w=="1") echo str_replace('"?p=','"?u='.ltrim($b,'_').'&amp;p=',trim($xml->page[$p-1]->contents));
                            if ($w=="2") echo str_replace('"?p=','"?u='.ltrim($b,'_').'&amp;w=2&amp;p=',trim($xml2->page[$p-1]->contents));
                        } else {
                            $username="username";
                            $password="password";
                            $database="database";

                            if ($name=="" || ($phone=="" && $email=="")) {
                               echo "<b>Missing Name or Contact Info.</b>";
                            } else {
                               mysql_connect("sql209.byethost4.com",$username,$password);
                               @mysql_select_db($database) or die( "Unable to select database");

                               $query = "INSERT INTO idscts (name,phone,email,message) VALUES ('$name','$phone','$email','$message')";
                               mysql_query($query);

                               mysql_close();

                               echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
                            }
                           }
                        echo "\n";
                        if(($xml->page[$p-1]['type']=="form" && $w=="1") || 
                           ($xml2->page[$p-1]['type']=="form" && $w=="2") && $name=="") {
                     ?>
                           <form class="form-horizontal" role="form" method="post">
                              <div class="form-group">
                                 <label class="control-label col-sm-3" for="name">Name:</label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label col-sm-3" for="phone">Contact Phone #:</label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="phone">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label col-sm-3" for="email">Email Address:</label>
                                 <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label col-sm-3" for="message">Message:</label>
                                 <div class="col-sm-6">
                                    <textarea class="form-control" rows="5" name="message"></textarea>
                                    <br>
                                    <input type="submit" class="btn btn-info" value="Submit">
                                 </div>
                              </div>
                           </form><?php
                        }
                     ?>
               </div>          
           </div>
         </div>
      </div>
   </div>
</body>
</html>
