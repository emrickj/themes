<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";

   if(isset($_GET['w'])) $w = $_GET['w'];
      else $w="1";

   require 'dspmenu.php';
   require 'dspcnt.php';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   //print_r($xml);
   //echo $xml->image[1];
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
t1 { white-space: pre-wrap;}
body {
    position: relative;
}
ul.nav-pills {
    top: 150px;
    position: fixed;
}
@media (min-width: 576px) {
	form label {text-align: right;}
}
<?php 
   echo $xml->style;
   echo "</style>\n";
   echo "</head>\n";
   echo "<body";
   if ($w=="1") echo " class='page".$p."'";
   echo " id='demo' data-spy='scroll' data-target='#myScrollspy'>\n";
?>
<div class="d-block d-md-none">
<nav class="navbar bg-dark navbar-dark fixed-top">
      <a class="navbar-brand" href="#"><?php echo $xml->title ?></a>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">
		<span class="navbar-toggler-icon"></span>
      </button>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="navbar-nav">
        <?php displayMenu_na() ?>
      </ul>
    </div>
</nav>
</div>
   <div class="container">
      <div class="row" id="p1">
         <div class="d-block d-md-none" style="padding-top: 50px;"></div>
         <div class="col-md-3">
         </div>
         <div class="col-md-9" style="padding: 20px">
            <b><h2 style="text-align: center;"><?php echo $xml->title ?></h2></b>
            <br>
         </div>
      </div>
      <div class="row">
         <nav class="col-md-3 d-none d-md-block" id="myScrollspy">
           <ul class="nav nav-pills flex-column" role="menu">
           <?php displayMenu_na() ?>
           </ul>
         </nav>
         <div class="col-md-9">
           <div class="card bg-light">
               <div class="card-body">
                <?php
                   for($i=1;$i<=6;$i++) {
                         if(strlen($xml->page[$i-1]->name)>2) {
                         if($i!=1) {
                            echo "<div id='p".$i."'>";
                            echo "<div style='padding-top: 50px;'></div>";
                         } else echo "<div>";
                         if(strlen($xml->page[$i-1]->image)>4)
                            echo "<img class='img-fluid' style='display: block;margin: auto;' src='".$xml->page[$i-1]->image."'>\n";
                         echo trim($xml->page[$i-1]->contents);
                         if($xml->page[$i-1]['type']=="comments") {

                         // begin htmlcommentbox.com -->
                         echo "<div id='HCB_comment_box' style='color: inherit; background-color: inherit;'>";
                    ?>   <a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
                         <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
                         <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
                         <!-- end htmlcommentbox.com --><?php
                          }
                          if($xml->page[$i-1]['type']=="form") {
                    ?>    <form class="form-horizontal" role="form" method="post">
                            <div class="form-group row">
                               <label class="col-form-label col-sm-4" for="name">Name:</label>
                               <div class="col-sm-6">
                                  <input type="text" class="form-control" name="name">
                               </div>
                            </div>
                            <div class="form-group row">
                               <label class="col-form-label col-sm-4" for="phone">Contact Phone #:</label>
                               <div class="col-sm-6">
                                  <input type="text" class="form-control" name="phone">
                               </div>
                            </div>
                            <div class="form-group row">
                               <label class="col-form-label col-sm-4" for="email">Email Address:</label>
                               <div class="col-sm-6">
                                  <input type="email" class="form-control" name="email">
                               </div>
                            </div>
                            <div class="form-group row">
                               <label class="col-form-label col-sm-4" for="message">Message:</label>
                               <div class="col-sm-6">
                                  <textarea class="form-control" rows="5" name="message"></textarea>
                                  <br>
                                  <input type="submit" class="btn btn-info" value="Submit">
                               </div>
                            </div>
                         </form>
                <?php
                          if ($name!="")
                            if(sendDb($name,$phone,$email,$message)) {
                               echo "<div class='alert alert-success'>";
                               echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
                               echo "</div>";
                            } else {
                               echo "<div class='alert alert-info'>";
                               echo "<b>Missing Name or Contact Info.</b>";
                               echo "</div>";
                            }
                        }
                        echo "</div>";
                     }
                   }
                ?>               
               </div>
				<div class="card-footer">
					<center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
				</div>			   
           </div>
		   <br>
         </div>
      </div>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
