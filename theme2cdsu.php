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
   
   $si=(include 'dspmenu.php') or die("<br><br>Error: Unable to access 'dspmenu.php'.  Make sure this file is in the directory where the theme file is.");
   $si=(include 'dspcnt.php') or die("<br><br>Error: Unable to access 'dspcnt.php'.  Make sure this file is in the directory where the theme file is.");

   $xml=simplexml_load_file("data/website".$b.".xml") or die("<br><br>Error: Cannot create object, please make sure that 'website".$b.".xml' is in the 'data' directory.");
   $xml2=simplexml_load_file("data/website2.xml");
   //print_r($xml);
   //echo $xml->image[1];

   // function below is used for Bootstrap 4.0 Navigation Bar for this current theme

   function displayMenu_nban($pn) {
	   $x = $GLOBALS['xml'];
	   $u = $GLOBALS['b'];
	   $n = $GLOBALS['name'];
	   if($u!="") $us="u=".ltrim($u,"_")."&"; else $us="";
	   for($i=1;$i<=6;$i++) {
		  if($i==$pn && $n=="") $bs=" active"; else $bs="";
		  if(strlen($x->page[$pn-1]->image)>4)
		     if(strlen($x->page[$i-1]->image)<=4) $bs .= " img-hide";
		  if(strlen($x->page[$i-1]->name)>2) 
			 echo "<li class='nav-item'><a class='nav-link".$bs."' href='?".$us."p=".$i."'>"
				. str_replace('"fa','"fa fa-fw',ic_html($x->page[$i-1]->name)) . "</a></li>\n";
	   }
   }
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
<div class="container-fluid" style="padding-top: 20px;padding-bottom: 20px;">
	<div class="card bg-light">
		<?php
		if(strlen($xml->page[$p-1]->image)>4)
		   echo "<img class='card-img-top' id='pgimg' src='".$xml->page[$p-1]->image."' alt='Card image'>\n";
		?>
		<nav class="navbar navbar-expand-md bg-primary navbar-dark">
		  <a class="navbar-brand" href="#"><?php echo $xml->title ?></a>
		  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">
			<span class="navbar-toggler-icon"></span>
		  </button>
			<div class="collapse navbar-collapse" id="myNavbar">
			  <ul class="navbar-nav">
				<?php displayMenu_nban($p) ?>
			  </ul>
			</div>
		</nav>
		<div class='card-body'><?php
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
					<input type="submit" class="btn btn-dark" value="Submit">
				 </div>
			  </div>
		   </form><?php
		}
		if($xml->page[$p-1]['type']=="comments" && $name=="") {
	 ?>
		   <!-- begin htmlcommentbox.com -->
		   <div id="HCB_comment_box" style="background-color: transparent;"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
		   <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
		   <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
		   <!-- end htmlcommentbox.com --><?php
		}
		echo "</div>\n";
	 ?>
		<div class="card-footer">
			<center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script> 
$(document).ready(function(){
    $(".img-hide").click(function(){
		ta = this;
		event.preventDefault();
        $("#pgimg").slideUp(1000);
		setTimeout(function(){ window.location.href = $(ta).attr("href"); }, 1000);
    });
});
</script>
</body>
</html>
