<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
   $name = $_POST['name'];
   $phone = $_POST['phone'];
   $email = $_POST['email'];
   $message = $_POST['message'];
   
   //ini_set('display_errors', 'On');
   //error_reporting(E_ALL);

   if(($_GET['u'] ?? '')!="") $b = "_".$_GET['u'];
      else $b="";
   // echo "--".$b."--";

   $p = $_GET['p'] ?? '1';
   $w = $_GET['w'] ?? '1';
   if ($w=="2") echo '<meta name="robots" content="noindex">';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("<br><br>Error: Cannot create object, please make sure that 'website".$b.".xml' is in the 'data' directory.");
   $xml2=simplexml_load_file("data/website2.xml");
   //print_r($xml);
   //echo $xml->image[1];
   
   function ic_html($pname) {
      if (strpos(" ".$pname,chr(0xef))==1) $rt = '<i class="fa">'.substr($pname,0,3).'</i> '.substr($pname,4);
         else $rt = $pname;
      return $rt;
   }

   $si=(include 'dspcnt.php') or die("<br><br>Error: Unable to access 'dspcnt.php'.  Make sure this file is in the directory where the theme file is.");
   //if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
   $mps="http://";
   $mainpage = $mps.$_SERVER['HTTP_HOST'].str_replace("/index.php","",$_SERVER['SCRIPT_NAME']);
   if ($p=="2") echo "<link rel='prev' href='".$mainpage."'>"; else
      if ($p > "1") echo "<link rel='prev' href='?p=".($p - 1)."'>";
   if (($p < "6") && strlen($xml->page[intval($p)]->name)>2) echo "<link rel='next' href='?p=".($p + 1)."'>";
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
@media (min-width: 601px) {
	.label {text-align: right; padding-top: 8px; padding-right: 10px;}
}
<?php echo $xml->style ?>
</style>
</head>
<body>

<div class="w3-container w3-blue w3-center">
  <h1 style="text-shadow:1px 1px 0 #444"><?php echo $xml->title ?></h1>
</div>

<!-- Navigation bar -->
<div class="w3-bar w3-black">
  <?php
  for($i=1;$i<=6;$i++) {
	if($i==$p && $w=="1" && $name=="") $bs=" w3-gray"; else $bs="";
	if(strlen($xml->page[$i-1]->name)>2) 
	  echo "<a href='?u=".ltrim($b,"_")."&p=".$i."' class='w3-bar-item w3-button w3-hide-small".$bs."'>"
		.ic_html($xml->page[$i-1]->name)."</a>";
  }
  ?>
	<a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="myFunction()">&#9776;</a>
</div>
<div id="demo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium">
  <?php
  for($i=1;$i<=6;$i++) {
	if($i==$p && $w=="1" && $name=="") $bs=" w3-gray"; else $bs="";
	if(strlen($xml->page[$i-1]->name)>2) 
	  echo "<a href='?u=".ltrim($b,"_")."&p=".$i."' class='w3-bar-item w3-button".$bs."'>"
		.ic_html($xml->page[$i-1]->name)."</a>";
  }
  ?>
</div>

<!-- Page Content -->
<div class="w3-main">

<?php
if ($w=="1")
   if(strlen($xml->page[$p-1]->image)>4)
      echo "<img class='w3-image' src='".$xml->page[$p-1]->image."' style='width:100%'>\n";
if ($w=="2")
   if(strlen($xml2->page[$p-1]->image)>4)
      echo "<img class='w3-image' src='".$xml2->page[$p-1]->image."' style='width:100%'>\n";
?>

<div class="w3-container">
<?php
  if($name=="") dispContents($p,ltrim($b,"_"),$w);
  else if(sendDb($name,$phone,$email,$message))
          echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
       else echo "<b>Missing Name or Contact Info.</b>";
  echo "\n";?>
</div>
<?php
  if((($xml->page[$p-1]['type']=="form" && $w=="1") || 
     ($xml2->page[$p-1]['type']=="form" && $w=="2")) && $name=="") {
?>
     <form class="w3-container" role="form" method="post">
		 <div class="w3-row">
		   <div class="w3-third">
			  <div class="label">Name:</div>
		   </div>
		   <div class="w3-third">
			  <input type="text" class="w3-input w3-border" name="name">
		   </div>
		 </div>
		 <div class="w3-row w3-margin-top">
		   <div class="w3-third">
			  <div class="label">Contact Phone #:</div>
		   </div>
		   <div class="w3-third">
			  <input type="text" class="w3-input w3-border" name="phone">
		   </div>
		 </div>
		 <div class="w3-row w3-margin-top">
		   <div class="w3-third">
			  <div class="label">Email Address:</div>
		   </div>
		   <div class="w3-third">
			  <input type="email" class="w3-input w3-border" name="email">
		   </div>
		 </div>
		 <div class="w3-row w3-margin-top">
		   <div class="w3-third">
			  <div class="label">Message:</div>
		   </div>
		   <div class="w3-third">
			  <textarea class="w3-input w3-border" rows="5" name="message"></textarea>
		   </div>
		 </div>
		 <div class="w3-row w3-margin-top">
		   <div class="w3-third">
		      &nbsp;
		   </div>
		   <div class="w3-third">
			  <input type="submit" class="w3-button w3-black w3-round-large w3-margin-bottom" value="Submit">
		   </div>
		 </div>
     </form>
<?php
  }
  if($xml->page[$p-1]['type']=="comments" && $w=="1" && $name=="") {
?>
     <!-- begin htmlcommentbox.com -->
     <div class="w3-container" id="HCB_comment_box"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
     <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
     <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
     <!-- end htmlcommentbox.com --><?php
  }
?>
<div class="w3-container w3-light-grey w3-center">
	<h6>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</h6>
</div>
</div>

<script>

function myFunction() {
    var x = document.getElementById("demo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

</body>
</html>