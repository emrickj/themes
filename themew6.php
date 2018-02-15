<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<?php
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   $p = $_GET['p'] ?? '1';
   $w = $_GET['w'] ?? '1';

   require 'dspcnt.php';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   //print_r($xml);
   //echo $xml->image[1];
   
   function ic_html($pname) {
      if (strpos(" ".$pname,chr(0xef))==1) $rt = '<i class="fa">'.substr($pname,0,3).'</i> '.substr($pname,4);
         else $rt = $pname;
      return $rt;
   }

   //if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
<?php echo $xml->style ?>
</style>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-wide w3-padding w3-card-2">
    <a href="#home" class="w3-bar-item w3-button"><?php echo $xml->title ?></a>
    <!-- Float links to the right. Hide them on small screens -->
    <div class="w3-right w3-hide-small">
   <?php
   for($i=1;$i<=3;$i++) {
     if(strlen($xml->page[$i-1]->name)>2) 
        echo "<a href='#p".$i."' class='w3-bar-item w3-button'>" . ic_html($xml->page[$i-1]->name) . "</a>";
   }
   ?>  
    </div>
  </div>
</div>

<!-- Header -->
<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
  <img class="w3-image" src="<?php echo $xml->page[0]->image ?>" width="1500" height="800">
  <div class="w3-display-middle w3-margin-top w3-center">
    <h1 class="w3-xxlarge w3-text-white"><?php echo $xml->title ?></h1>
  </div>
</header>

<!-- Page content -->
<div class="w3-content w3-padding" style="max-width:1564px">

<?php
   for($i=1;$i<=3;$i++) {
      if(strlen($xml->page[$i-1]->name)>2) {
         echo "<div class='w3-container w3-padding-32' id='p".$i."'>";
         echo "<h3 class='w3-border-bottom w3-border-light-grey w3-padding-16'>".$xml->page[$i-1]->name."</h3>";
         echo trim($xml->page[$i-1]->contents);
         if($xml->page[$i-1]['type']=="comments") {

         // begin htmlcommentbox.com -->
         echo "<div id='HCB_comment_box'>";
    ?>   <a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
         <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
         <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
         <!-- end htmlcommentbox.com --><?php
          }
          if($xml->page[$i-1]['type']=="form") {
    ?>    <form action="#alert" role="form" method="post">
              <input type="text" class="w3-input w3-section" placeholder="Name" name="name">
              <input type="text" class="w3-input w3-section" placeholder="Contact Phone #" name="phone">
              <input type="email" class="w3-input w3-section" placeholder="Email" name="email">
              <input type="text" class="w3-input w3-section" placeholder="Message" name="message">
              <button class="w3-button w3-black w3-section" type="submit" id="alert">
                <i class="fa fa-paper-plane"></i> SEND MESSAGE
              </button>
           </form>
<?php
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
     echo "</div>";
   }
   }
?>
  
<!-- End page content -->
</div>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-16">
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>

<!-- Add Google Maps -->
<script>
function myMap()
{
  myCenter=new google.maps.LatLng(41.878114, -87.629798);
  var mapOptions= {
    center:myCenter,
    zoom:12, scrollwheel: false, draggable: false,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapOptions);

  var marker = new google.maps.Marker({
    position: myCenter,
  });
  marker.setMap(map);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

</body>
</html>
