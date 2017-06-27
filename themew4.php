<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
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
      if (strpos(" ".$pname,chr(0xef))==1) $rt = '<i class="fa">'.substr($pname,0,3).'</i> '.strtoupper(substr($pname,4));
         else $rt = strtoupper($pname);
      return $rt;
   }
   
   function ic_strip($pname) {
      if (strpos(" ".$pname,chr(0xef))==1) $rt = strtoupper(substr($pname,4));
         else $rt = strtoupper($pname);
      return $rt;
   }

   //if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
?>
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
body, html {
    height: 100%;
    line-height: 1.8;
}
/* Full height image header */
.bgimg-1 {
    background-position: center;
    background-size: cover;
    background-image: url("<?php echo $xml->page[0]->image ?>");
    background-color: #C0C0C0;
    min-height: 100%;
}
.w3-bar .w3-button {
    padding: 16px;
}
</style>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card-2" id="myNavbar">
    <a href="#home" class="w3-bar-item w3-button w3-wide">LOGO</a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">
   <?php
   for($i=1;$i<=6;$i++) {
     if(strlen($xml->page[$i-1]->name)>2) {
        echo "<a href='#p".$i."' class='w3-bar-item w3-button'>" . ic_html($xml->page[$i-1]->name) . "</a>";
     }
   }
   ?>  
    </div>
    <!-- Hide right-floated links on small screens and replace them with a menu icon -->

    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-black w3-card-2 w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close &#xD7;</a>
   <?php
   for($i=1;$i<=6;$i++) {
     if(strlen($xml->page[$i-1]->name)>2) {
        echo "<a href='#p".$i."' onclick='w3_close()' class='w3-bar-item w3-button'>" . ic_strip($xml->page[$i-1]->name) . "</a>";
     }
   }
   ?>  
</nav>

<!-- Header with full-height image -->
<header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-left w3-text-white" style="padding:48px">
    <span class="w3-jumbo w3-hide-small"><?php echo strip_tags($xml->title) ?></span><br>
    <span class="w3-xxlarge w3-hide-large w3-hide-medium"><?php echo strip_tags($xml->title) ?></span><br>
    <span class="w3-large"></span>
    <p><a href="#p1" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Learn more and start today</a></p>
  </div> 
  <div class="w3-display-bottomleft w3-text-grey w3-large" style="padding:24px 48px">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>
</header>

<?php
   for($i=1;$i<=6;$i++) {
      if($xml->page[$i-1]['type']=="page")
         if(strlen($xml->page[$i-1]->name)>2) {     
            echo "<div class='w3-container' style='padding:128px 16px' id='p".$i."'>";
            echo trim($xml->page[$i-1]->contents);
            echo "</div>";
         }
      if($xml->page[$i-1]['type']=="comments") {

     // begin htmlcommentbox.com -->
     echo "<div id='p".$i."'></div>";
     echo "<div class='w3-container' id='HCB_comment_box' style='padding:128px 16px'>";
?>   <a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
     <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
     <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
     <!-- end htmlcommentbox.com --><?php
      }
      if($xml->page[$i-1]['type']=="form") {

     echo "<div class='w3-container w3-light-grey' style='padding:128px 16px' id='p".$i."'>";
     echo trim($xml->page[$i-1]->contents);
?>   <div class="w3-row-padding" style="margin-top:64px">
     <div class="w3-half">
       <form action="#alert" class="w3-container" role="form" method="post">
       <p>
          <label for="name">Name:</label>
          <input type="text" class="w3-input w3-border" name="name">
       </p>
       <p>
          <label for="phone">Contact Phone #:</label>
          <input type="text" class="w3-input w3-border" name="phone">
       </p>
       <p>
          <label for="email">Email Address:</label>
          <input type="email" class="w3-input w3-border" name="email">
       </p>
       <p>
          <label for="message">Message:</label>
          <textarea class="w3-input w3-border" rows="5" name="message"></textarea>
       </p>
       <button class="w3-button w3-black w3-margin-bottom" type="submit" id="alert">
            <i class="fa fa-paper-plane"></i> SEND MESSAGE
          </button>
       </form>
<?php
      if ($name!="") {
        $username="username";
        $password="password";
        $database="database";

        if ($name=="" || ($phone=="" && $email=="")) {
           echo "<div class='w3-panel w3-blue'>";
           echo "<b>Missing Name or Contact Info.</b>";
           echo "</div>";
        } else {
           $link = mysqli_connect("sql209.byethost4.com",$username,$password,$database);
           //@mysql_select_db($database) or die( "Unable to select database");

           $query = "INSERT INTO idscts (name,phone,email,message) VALUES ('$name','$phone','$email','$message')";
           mysqli_query($link,$query);

           mysqli_close($link);
           
           echo "<div class='w3-panel w3-green'>";
           echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
           echo "</div>";
         }
       }
     }
   }
?>   </div>  
     </div>
     </div>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64">
  <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
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

// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
    } else {
        mySidebar.style.display = 'block';
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcWC8qwIy8ksmdcHLj-DBbBFDWNWLtQA&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

</body>
</html>
