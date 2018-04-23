<?php
   //ini_set('display_errors', 'On');
   //error_reporting(E_ALL);

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";

   $si=(include 'dspmenu.php') or die("<br><br>Error: Unable to access 'dspmenu.php'.  Make sure this file is in the directory where the theme file is.");
   $si=(include 'dspcnt.php') or die("<br><br>Error: Unable to access 'dspcnt.php'.  Make sure this file is in the directory where the theme file is.");
   
   $xml=simplexml_load_file("data/website".$b.".xml") or die("<br><br>Error: Cannot create object, please make sure that 'website".$b.".xml' is in the 'data' directory.");
   $page=$xml->xpath("/website/page[".$p."]");
   changeLinks($page);

   $lang = $page[0]['language'];
   if ($lang == "") $lang="en";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
.band {border-style: solid solid none solid; padding: 15px 15px 0 15px;}
#b1 {border-radius: 15px 15px 0 0;background-color: white;}
#b2 {border-radius: 33px 33px 0 0;background-color: blue;}
#b3 {border-radius: 51px 51px 0 0;background-color: yellow;}
#b4 {border-radius: 69px 69px 0 0;background-color: red;}
#title {
  position: absolute;
  top: 0px;
  z-index: 10;
  color: white;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}
#page-body {
  padding: 15px;
}
@media (min-width: 576px) {
	form label {text-align: right;}
}
@media (max-width: 575px) {
	body {background: linear-gradient(to right, red,orange,yellow,green,blue,indigo,violet);}
	.band {border-style: none; padding: 0;}
	#b1 {border-radius: 0;}
	#b2 {border-radius: 0;}
	#b3 {border-radius: 0;}
	#b4 {border-radius: 0;}
}
<?php echo $xml->style ?>
</style>
</head>
<body onload="setHeight();" onresize="setHeight();">
	<div class="container" style="padding-top: 20px;">
		<div class="band" id="b4">
		<div class="band" id="b3">
		<div class="band" id="b2">
		<div class="band" id="b1">
			<div class="d-none d-md-block" id="title">
				<b><h2><?php echo $xml->title ?></h2></b>
			</div>
			<?php
			if(strlen($page[0]->image)>4)
			   echo "<img src='".$page[0]->image."' style='width: 100%; height: auto;'>\n";
			?>
			<nav class="navbar navbar-expand-md navbar-light">
			  <a class="navbar-brand d-block d-md-none" href="#"><?php echo $xml->title ?></a>
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
			<div class="bg-light" id="page-body"><?php
			if($name=="") echo $page[0]->contents;
			   else if(sendEmail($name,$email,$subject,$message))
				  echo "Contact Information Submitted.  Thank you.";
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
						<input type="submit" class="btn btn-primary" value="Submit">
					 </div>
				  </div>
			   </form><?php
			}
			if($page[0]['type']=="comments" && $name=="") {
		 ?>
			   <!-- begin htmlcommentbox.com -->
			   <div id="HCB_comment_box" style="background-color: transparent;"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
			   <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
			   <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
			   <!-- end htmlcommentbox.com --><?php
			}
			echo "</div>\n";
	 ?>	   	<div style="font-size: .83em;" id="footer">
				<center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
		    </div>
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

function setHeight() {
$("#b1").css("height","initial");
if ($("#b1").innerHeight() < (window.innerHeight - 77))
   $("#b1").innerHeight(window.innerHeight - 77);
}
</script>
</html>
