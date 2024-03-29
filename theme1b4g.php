<?php
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";

   if(isset($_GET['w'])) $w = $_GET['w'];
      else $w="1";
   if ($w=="2") echo '<meta name="robots" content="noindex">';

   require 'dspmenu.php';
   require 'dspcnt.php';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   $xml2=simplexml_load_file("data/website2.xml") or die("Error: Cannot create object");
   $xpath="/website/page[".$p."]";
   if ($w=="2") $page = $xml2->xpath($xpath); else $page = $xml->xpath($xpath);
   changeLinks($page);
   
   error_reporting(0);
   if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
   $mainpage = $mps.$_SERVER['HTTP_HOST'].str_replace("/index.php","",$_SERVER['SCRIPT_NAME']);

   $lang = $page[0]['language'];
   if ($lang == "") $lang="en";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php paginatePage($p) ?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
@media (max-width: 767px) {
	body {background: linear-gradient(to right, rgba(191,255,255,1), rgba(191,255,255,0), rgba(191,255,255,1))};
}
@media (min-width: 576px) {
	form label {text-align: right;}
}
#grad {
  background: linear-gradient(to right, rgba(191,255,255,1), rgba(191,255,255,0));
}
#title {
  color: white;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}
<?php echo $xml->style ?>
</style>
</head>
<body id="demo" onload="setHeight();" onresize="setHeight();">
<div class="d-block d-md-none">
<nav class="navbar bg-light navbar-light fixed-top">
  <a class="navbar-brand" href="<?php echo $mainpage ?>"><?php echo $xml->title ?></a>
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">
	<span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="navbar-nav">
        <?php
         $pn=$xml->xpath("/website/page/name[.!='']");
		 displayMenu_xn($pn);
		?>
	</ul>
  </div>
</nav>
</div>
   <div class="container-fluid">
      <div class="d-block d-md-none" style="padding-top: 50px;"></div>
      <div class="row">
         <div class="col-md-3 d-none d-md-block" id="grad">
		    <div class="container">
		          <div style="padding: 20px" id="title">
				     <b><h2><center><?php echo $xml->title ?></center></h2></b>
				  </div>
                  <br>
                  <div class="btn-group-vertical btn-group-lg bg-light rounded">
                     <?php
					 $i=1;
                     foreach ($pn as $item) {
                       if($i==$p && $w=="1" && $name=="") $bs="active"; else $bs="";
                       echo "<a href='?u=".ltrim($b,"_")."&p=".$i++."' class='btn btn-outline-primary "
                       .$bs."'>" . ic_html($item) . "</a>";
                     }
                     ?>
                     <ul class="dropdown-menu" role="menu">
                     <?php
						$pn2=$xml2->xpath("/website/page/name[.!='']");
					    displayMenu_xd($pn2,2);						
					 ?>
                     </ul>
                     <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                     <?php echo strip_tags($xml2->title) ?> <span class="caret"></span></button>
                  </div>
                  <br>
                  <br>
			</div>
         </div>
         <div class="col-md-9" style="padding-top: 20px;padding-bottom: 20px;">
           <div class="card bg-dark text-white">
				 <?php
				   if(strlen($page[0]->image)>4)
					  echo "<img class='card-img-top' src='".$page[0]->image."' style='min-height: 1px;'>\n";
				 ?>
               <div class="card-body">
					 <?php
                        if($name=="") echo $page[0]->contents;
                        else if(sendDb($name,$phone,$email,$message))
                                echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
                             else echo "<b>Missing Name or Contact Info.</b>";
                        echo "\n";
                        if($page[0]['type']=="form" && $name=="") {
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
									<div class="bg-light rounded" style="display: inline-block;">
										<button class="btn btn-outline-primary" type="submit" disabled>
											<i class="fa fa-paper-plane"></i> SEND MESSAGE
										</button>
									</div>
                                 </div>
                              </div>
                           </form><?php
                        }
                        if($page[0]['type']=="comments" && $w=="1" && $name=="") {
                     ?>
                           <!-- begin htmlcommentbox.com -->
                           <div id="HCB_comment_box" style="background-color: transparent;"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
                           <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
                           <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
                           <!-- end htmlcommentbox.com --><?php
                        }
                     ?>
               </div>
				<div class="card-footer bg-light text-dark">
					<center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
				</div>			   
           </div>
         </div>
      </div>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>

function setHeight() {
$(".container").css("height","initial");
if ($(".container").height() < window.innerHeight)
   $(".container").height(window.innerHeight);
}
</script>
</html>
