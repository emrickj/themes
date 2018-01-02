<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
   $name = $_POST['name'];
   $email = $_POST['email'];
   $subject = $_POST['subject'];
   $message = $_POST['message'];
   
   //ini_set('display_errors', 'On');
   //error_reporting(E_ALL);

   if ($name!="") {
      // echo $subject." ".$message." ".$name." ".$email;
      
   }
   if(isset($_GET['u']) && $_GET['u']!="") $b = "_".$_GET['u'];
      else $b="";
   // echo "--".$b."--";

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";
   
   $xml=simplexml_load_file("data/website".$b.".xml") or die("<br><br>Error: Cannot create object, please make sure that 'website".$b.".xml' is in the 'data' directory.");
   $xml2=simplexml_load_file("data/website2.xml");
   //print_r($xml);
   //echo $xml->image[1];

   $si=(include 'dspmenu.php') or die("<br><br>Error: Unable to access 'dspmenu.php'.  Make sure this file is in the directory where the theme file is.");
   $si=(include 'dspcnt.php') or die("<br><br>Error: Unable to access 'dspcnt.php'.  Make sure this file is in the directory where the theme file is.");
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
t1 { white-space: pre-wrap;}
<?php 
   echo $xml->style;
   echo "</style>\n";
   echo "</head>\n";
   echo "<body class='page".$p."' id='demo'>\n";
?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#"><?php echo $xml->title ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <?php displayMenu($p) ?>
      </ul>
    </div>
  </div>
</nav>
   <div class="container" style="padding-top: 76px;">
      <div class="row">
         <div class="col-sm-2">
         </div>
         <div class="col-sm-8">
		    <div class="panel panel-primary">
				<?php
				if(strlen($xml->page[$p-1]->image)>4)
				   echo "<img src='".$xml->page[$p-1]->image."' style='width: 100%;height: auto;'>\n";
				?>
				<div class="panel-body">
					 <?php
						if($name=="") dispContents($p,ltrim($b,"_"));
						   else if(sendEmail($name,$email,$subject,$message))
							  echo "Contact Information Submitted.  Thank you.";
						if($xml->page[$p-1]['type']=="form" && $name=="") {
					 ?>
						   <form class="form-horizontal" role="form" method="post">
							  <div class="form-group">
								 <label class="control-label col-sm-3" for="name">Name:</label>
								 <div class="col-sm-6">
									<input type="text" class="form-control" name="name">
								 </div>
							  </div>
							  <div class="form-group">
								 <label class="control-label col-sm-3" for="email">Email Address:</label>
								 <div class="col-sm-6">
									<input type="email" class="form-control" name="email">
								 </div>
							  </div>
							  <div class="form-group">
								 <label class="control-label col-sm-3" for="subject">Subject:</label>
								 <div class="col-sm-6">
									<input type="text" class="form-control" name="subject">
								 </div>
							  </div>
							  <div class="form-group">
								 <label class="control-label col-sm-3" for="message">Message:</label>
								 <div class="col-sm-6">
									<textarea class="form-control" rows="5" name="message"></textarea>
									<br>
									<input type="submit" class="btn btn-primary" value="Submit">
								 </div>
							  </div>
						   </form><?php
						}
						if($xml->page[$p-1]['type']=="comments" && $name=="") {
					 ?>
						   <!-- begin htmlcommentbox.com -->
						   <div id="HCB_comment_box"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
						   <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
						   <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
						   <!-- end htmlcommentbox.com --><?php
						}
					 ?>
				</div>
				<div class="panel-footer">
					<center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
				</div>
            </div>				 
         </div>
         <div class="col-sm-2">
         </div>
      </div>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>