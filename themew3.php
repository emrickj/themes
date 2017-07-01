<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
   $name = $_POST['name'];
   $phone = $_POST['phone'];
   $email = $_POST['email'];
   $message = $_POST['message'];
   
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   if(($_GET['u'] ?? '')!="") $b = "_".$_GET['u'];
      else $b="";
   // echo "--".$b."--";

   $p = $_GET['p'] ?? '1';
   $w = $_GET['w'] ?? '1';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   //print_r($xml);
   //echo $xml->image[1];
   
   function ic_html($pname) {
      if (strpos(" ".$pname,chr(0xef))==1) $rt = '<i class="fa">'.substr($pname,0,3).'</i> '.substr($pname,4);
         else $rt = $pname;
      return $rt;
   }

   require 'dspcnt.php';
   //if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
html,body,h1,h2,h3,h4 {font-family:"Lato", sans-serif}
.mySlides {display:none}
.w3-tag, .fa {cursor:pointer}
.w3-tag {height:15px;width:15px;padding:0;margin-top:6px}
</style>
<body>

<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-large w3-light-grey">
   <?php
   for($i=1;$i<=4;$i++) {
     if(strlen($xml->page[$i-1]->name)>2) {
        echo "<div class='w3-col s3'>";
        echo "<a href='#".$i."' class='w3-button w3-block'>" . ic_html($xml->page[$i-1]->name) . "</a>";
        echo "</div>";
     }
   }
   ?>  
  </div>
</div>

<!-- Content -->
<div class="w3-content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">
     <div class="w3-row w3-container">

<div class="w3-content w3-section" style="max-width:500px">

  <div class="w3-panel">
    <h1><b><?php echo strip_tags($xml->title) ?></b></h1>
  </div>

<?php
   for($i=1;$i<=6;$i++) {
      if(strlen($xml->page[$i-1]->image)>4)
         echo "<img class='mySlides' src='".$xml->page[$i-1]->image."' style='width:100%'>\n";
   }
?>
</div>

<?php
   for($i=1;$i<=4;$i++) {
      if(strlen($xml->page[$i-1]->name)>2) {
         echo "<div class='w3-padding-64' id='".$i."'>";
         echo trim($xml->page[$i-1]->contents);
         echo "</div>";
      }
      if($xml->page[$i-1]['type']=="comments") {
?>
     <!-- begin htmlcommentbox.com -->
     <div class="w3-container" id="HCB_comment_box"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
     <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
     <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
     <!-- end htmlcommentbox.com --><?php
      }
      if($xml->page[$i-1]['type']=="form") {
?>
     <form action="#alert" class="w3-container" role="form" method="post">
     <div class="w3-row">
       <div class="w3-col m6 l5">
       <p>
          <label for="name">Name:</label>
          <input type="text" class="w3-input w3-border w3-hover-border-black" name="name">
       </p>
       <p>
          <label for="phone">Contact Phone #:</label>
          <input type="text" class="w3-input w3-border w3-hover-border-black" name="phone">
       </p>
       <p>
          <label for="email">Email Address:</label>
          <input type="email" class="w3-input w3-border w3-hover-border-black" name="email">
       </p>
       <p>
          <label for="message">Message:</label>
          <textarea class="w3-input w3-border w3-hover-border-black" rows="5" name="message"></textarea>
       </p>
       <input type="submit" class="w3-button w3-black w3-margin-bottom" value="Send">
       </div>
     </div>  
     </form><?php
      if ($name!="")
        if(sendDb($name,$phone,$email,$message)) {
           echo "<div class='w3-panel w3-green' id='alert'>";
           echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
           echo "</div>";
        } else {
           echo "<div class='w3-panel w3-blue' id='alert'>";
           echo "<b>Missing Name or Contact Info.</b>";
           echo "</div>";
        }
     }
   }
?>

   </div>
</div>

<!-- Footer -->

<footer class="w3-container w3-padding-32 w3-light-grey w3-center">
  <h4>Footer</h4>
  <a href="#" class="w3-button w3-black w3-margin"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
  <div class="w3-xlarge w3-section">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>


<script>
// Slideshow
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2000); // Change image every 2 seconds
}
</script>

</body>
</html>
