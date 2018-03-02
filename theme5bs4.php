<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
   //ini_set('display_errors', 'On');
   //error_reporting(E_ALL);

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";

   if(isset($_GET['w'])) $w = $_GET['w'];
      else $w="1";

   $si=(include 'dspmenu.php') or die("<br><br>Error: Unable to access 'dspmenu.php'.  Make sure this file is in the directory where the theme file is.");
   $si=(include 'dspcnt.php') or die("<br><br>Error: Unable to access 'dspcnt.php'.  Make sure this file is in the directory where the theme file is.");

   $xml=simplexml_load_file("data/website".$b.".xml") or die("<br><br>Error: Cannot create object, please make sure that 'website".$b.".xml' is in the 'data' directory.");
   $xml2=simplexml_load_file("data/website2.xml");
   //print_r($xml);
   //echo $xml->image[1];
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
   echo "<body";
   if ($w=="1") echo " class='page".$p."'";
   echo " id='demo'>\n";
?>
<div class="d-block d-md-none">
<nav class="navbar bg-light navbar-light fixed-top">
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
<div class="container" style="padding-top: 20px;padding-bottom: 20px;">
	<div class="d-block d-md-none" style="padding-top: 50px;"></div>
   <div class="card">
	   <div class="card-header bg-dark text-white">
	     <div class="d-none d-md-block">
			 <svg height="60" width="450">
				<filter id="lightMe1">
				  <feDiffuseLighting in="SourceGraphic" result="light"
					 lighting-color="white">
					 <fePointLight x="200" y="60" z="100" />
				  </feDiffuseLighting>
				  <feComposite in="SourceGraphic" in2="light"
					 operator="arithmetic" k1="1" k2="0" k3="0" k4="0"/>
				</filter>
				<text font-size="45" font-weight="bold" x="0" y="45" fill="white" filter="url(#lightMe1)"><?php echo $xml->title ?></text> 
			 </svg>
		 </div>
		 <div class="d-block d-md-none">
		    <?php echo $xml->title ?>
		 </div>
	   </div>
	   <div class="d-none d-md-block" style="padding: 5px;">
		  <ul class="nav nav-pills">
			<?php displayMenu_nb($p) ?>
		  </ul>
	   </div>
		<?php
		if ($w=="1")
		   if(strlen($xml->page[$p-1]->image)>4)
		      echo "<img src='".$xml->page[$p-1]->image."' style='width: 100%;height: auto;'>\n";
		if ($w=="2")
		   if(strlen($xml2->page[$p-1]->image)>4)
			  echo "<img src='".$xml2->page[$p-1]->image."' style='width: 100%;height: auto;'>\n";
		?>
	   <div class="card-body bg-light">
				<?php
				if($name=="") dispContents($p,ltrim($b,"_"),$w);
				else if(sendDb($name,$phone,$email,$message))
						echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
					 else echo "<b>Missing Name or Contact Info.</b>";
				echo "\n";
				if(($xml->page[$p-1]['type']=="form" && $w=="1") || 
				   ($xml2->page[$p-1]['type']=="form" && $w=="2") && $name=="") {
			 ?>
				   <form class="form-horizontal" role="form" method="post">
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
							<input type="submit" class="btn btn-dark" value="Submit">
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
	   <div class="card-footer" style="font-size: .83em;">
			 <center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
	   </div>
   </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>