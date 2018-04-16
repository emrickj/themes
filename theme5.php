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
   $page=$xml->xpath("/website/page[position()=".$p."]");

   $lang = $page[0]['language'];
   if ($lang == "") $lang="en";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
	<div class="hidden-sm hidden-md hidden-lg" style="padding-top: 50px;"></div>
	<div style="padding-top: 20px;"></div>
   <div class="panel panel-default">
	   <div class="panel-heading hidden-xs">
		 <svg height="60" width="450">
			<filter id="lightMe1">
			  <feDiffuseLighting in="SourceGraphic" result="light"
				 lighting-color="white">
				 <fePointLight x="200" y="60" z="100" />
			  </feDiffuseLighting>
			  <feComposite in="SourceGraphic" in2="light"
				 operator="arithmetic" k1="1" k2="0" k3="0" k4="0"/>
			</filter>
			<text font-size="45" font-weight="bold" x="0" y="45" fill="rgb(191,191,255)" filter="url(#lightMe1)"><?php echo $xml->title ?></text> 
		 </svg>
		  <ul class="list-inline">
			<?php displayMenu($p) ?>
		  </ul>
	   </div>
	   <div class="panel-body">
				<?php
				if(strlen($page[0]->image)>4)
				   echo "<img class='img-responsive' style='display: block;margin: auto;' src='".$page[0]->image."'>\n";
				if($name=="") dispContents($p,ltrim($b,"_"),$w);
				else if(sendDb($name,$phone,$email,$message))
						echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
					 else echo "<b>Missing Name or Contact Info.</b>";
				echo "\n";
				if($page[0]['type']=="form" && $name=="") {
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
				if($page[0]['type']=="comments" && $name=="") {
			 ?>
				   <!-- begin htmlcommentbox.com -->
				   <div id="HCB_comment_box"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
				   <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
				   <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
				   <!-- end htmlcommentbox.com --><?php
				}
			 ?>
	   </div>
	   <div class="panel-footer" style="font-size: .83em;">
			 <center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
	   </div>
   </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
