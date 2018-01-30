<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
   if ($w=="2") echo '<meta name="robots" content="noindex">';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   $xml2=simplexml_load_file("data/website2.xml") or die("Error: Cannot create object");
   //print_r($xml);
   //echo $xml->image[1];
   //echo $_SERVER['HTTP_HOST']."\n";
   //echo $_SERVER['SCRIPT_NAME'];
   
   require 'dspmenu.php';
   require 'dspcnt.php';
      
   error_reporting(0);
   if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
   $mainpage = $mps.$_SERVER['HTTP_HOST'].str_replace("/index.php","",$_SERVER['SCRIPT_NAME']);
      if ($p=="2") echo "<link rel='prev' href='".$mainpage."'>"; else
   if ($p > "1") echo "<link rel='prev' href='?p=".($p - 1)."'>";
   if (($p < "6") && strlen($xml->page[intval($p)]->name)>2) echo "<link rel='next' href='?p=".($p + 1)."'>";
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
@media (min-width: 576px) {
	form label {text-align: right;}
}
<?php echo $xml->style ?>
</style>
</head>
<body id="demo">
<div class="d-block d-md-none">
<nav class="navbar bg-dark navbar-dark fixed-top">
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">
	<span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="navbar-nav">
       <?php displayMenu_nb($p) ?>
	</ul>
  </div>
</nav>
</div>
   <div class="container-fluid">
      <div class="d-block d-md-none" style="padding-top: 50px;"></div>
	  <div style="padding: 20px" id="title">
		<b><h2><center><?php echo $xml->title ?></center></h2></b>
	  </div>
      <div class="row">
         <div class="col-md-3 d-none d-md-block">
		    <div class="container">
				  <div style="padding-top: 20px;">
					  <div class="btn-group-vertical btn-group-lg bg-light rounded" style="position: fixed;">
						  <?php
						 for($i=1;$i<=6;$i++) {
						   if($i==$p && $w=="1" && $name=="") $bs="active"; else $bs="";
						   if(strlen($xml->page[$i-1]->name)>2) 
							  echo "<a href='?u=".ltrim($b,"_")."&p=".$i."' class='btn btn-outline-primary "
							  .$bs."'>" . ic_html($xml->page[$i-1]->name) . "</a>";
						 }
						 ?>
						 <ul class="dropdown-menu" role="menu">
						 <?php displayMenu_dd($p,$w,2) ?>
						 </ul>
						 <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
						 <?php echo strip_tags($xml2->title) ?> <span class="caret"></span></button>
					  </div>
				  </div>
                  <br>
                  <br>
			</div>
         </div>
         <div class="col-md-9" style="padding-top: 20px;padding-bottom: 20px;">
           <div class="card bg-light">
		             <?php
						if ($w=="1")
						   if(strlen($xml->page[$p-1]->image)>4)
							  echo "<img class='card-img-top' src='".$xml->page[$p-1]->image."'>\n";
						if ($w=="2")
						   if(strlen($xml2->page[$p-1]->image)>4)
							  echo "<img class='card-img-top' src='".$xml2->page[$p-1]->image."'>\n";
					 ?>
               <div class="card-body">
					 <?php
                        if($name=="") dispContents($p,ltrim($b,"_"),$w);
                        else if(sendDb($name,$phone,$email,$message))
                                echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
                             else echo "<b>Missing Name or Contact Info.</b>";
                        echo "\n";
                        if((($xml->page[$p-1]['type']=="form" && $w=="1") || 
                           ($xml2->page[$p-1]['type']=="form" && $w=="2")) && $name=="") {
                     ?>
                           <form class="form-horizontal" role="form" method="post">
                              <div class="form-group row">
                                 <label class="col-form-label col-sm-4" for="name">Name:</label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name">
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-form-label col-sm-4" for="phone">Contact&nbsp;Phone&nbsp;#:</label>
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
									<button class="btn btn-outline-primary" type="submit" disabled>
										<i class="fa fa-paper-plane"></i> SEND MESSAGE
									</button>
                                 </div>
                              </div>
                           </form><?php
                        }
                        if($xml->page[$p-1]['type']=="comments" && $w=="1" && $name=="") {
                     ?>
                           <!-- begin htmlcommentbox.com -->
                           <div id="HCB_comment_box" style="background-color: transparent;"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
                           <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
                           <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
                           <!-- end htmlcommentbox.com --><?php
                        }
                     ?>
               </div>
				<div class="card-footer">
					<center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
				</div>			   
           </div>
         </div>
      </div>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
<script>

//if ($(".container").height() < window.outerHeight)
//   $(".container").height(window.outerHeight);

</script>
</html>
