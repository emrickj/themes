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

   // function below is used for Bootstrap 4.0 Navigation Bar for this current theme

   function displayMenu_nban($pa) {
	   $u = $GLOBALS['b'];
	   $n = $GLOBALS['name'];
	   $pn = $GLOBALS['p'];
	   if($u!="") $us="u=".ltrim($u,"_")."&"; else $us="";
	   $i=1;
	   foreach($pa as $item) {
		  if($i==$pn && $n=="") $bs=" active"; else $bs="";
		  if(strlen($pa[$pn-1]->image)>4)
		     if(strlen($item->image)<=4) $bs .= " img-hide";
		  echo "<li class='nav-item'><a class='nav-link".$bs."' href='?".$us."p=".$i++."'>"
		  . str_replace('"fa','"fa fa-fw',ic_html($item->name)) . "</a></li>\n";
	   }
   }
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		if(strlen($page[0]->image)>4)
		   echo "<img class='card-img-top' id='pgimg' src='".$page[0]->image."' alt='Card image' style='min-height: 1px;'>\n";
		?>
		<nav class="navbar navbar-expand-md bg-primary navbar-dark">
		  <a class="navbar-brand" href="#"><?php echo $xml->title ?></a>
		  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">
			<span class="navbar-toggler-icon"></span>
		  </button>
			<div class="collapse navbar-collapse" id="myNavbar">
			  <ul class="navbar-nav">
				<?php
				 $pg=$xml->xpath("/website/page[name!='']");
				 displayMenu_nban($pg);
				?>
			  </ul>
			</div>
		</nav>
		<div class='card-body' style='min-height: 1px;'><?php
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
					<input type="submit" class="btn btn-dark" value="Submit">
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
	 ?>
		<div class="card-footer">
			<center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
