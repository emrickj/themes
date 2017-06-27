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
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
body, html {
    height: 100%;
    color: #777;
    line-height: 1.8;
}

/* Create a Parallax Effect */
.bgimg-1, .bgimg-2, .bgimg-3, .bgimg-4, .bgimg-5, .bgimg-6 {
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

/* First image (Logo. Full height) */
.bgimg-1 {
    background-image: url('<?php echo $xml->page[0]->image ?>');
    min-height: 100%;
}

/* Second image */
.bgimg-2 {
    background-image: url("<?php echo $xml->page[1]->image ?>");
    min-height: 400px;
}

/* Third image */
.bgimg-3 {
    background-image: url("<?php echo $xml->page[2]->image ?>");
    min-height: 400px;
}

/* Fourth image */
.bgimg-4 {
    background-image: url("<?php echo $xml->page[3]->image ?>");
    min-height: 400px;
}

/* Fifth image */
.bgimg-5 {
    background-image: url("<?php echo $xml->page[4]->image ?>");
    min-height: 400px;
}

/* Sixth image */
.bgimg-6 {
    background-image: url("<?php echo $xml->page[5]->image ?>");
    min-height: 400px;
}

.w3-wide {letter-spacing: 10px;}
.w3-hover-opacity {cursor: pointer;}

/* Turn off parallax scrolling for tablets and phones */
@media only screen and (max-device-width: 1024px) {
    .bgimg-1, .bgimg-2, .bgimg-3, .bgimg-4, .bgimg-5, .bgimg-6 {
        background-attachment: scroll;
    }
}
</style>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar" id="myNavbar">
    <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
      <i class="fa fa-bars"></i>
    </a>
    <a href="#home" class="w3-bar-item w3-button">HOME</a>
   <?php
   for($i=1;$i<=6;$i++) {
     if(strlen($xml->page[$i-1]->name)>2) 
        echo "<a href='#p".$i."' class='w3-bar-item w3-button w3-hide-small'>" . ic_html($xml->page[$i-1]->name) . "</a>";
   }
   ?>  
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-red">
      <i class="fa fa-search"></i>
    </a>
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
   <?php
   for($i=1;$i<=6;$i++) {
     if(strlen($xml->page[$i-1]->name)>2) 
        echo "<a href='#p".$i."' class='w3-bar-item w3-button' onclick='toggleFunction()'>" . ic_strip($xml->page[$i-1]->name) . "</a>";
   }
   ?>  
    <a href="#" class="w3-bar-item w3-button">SEARCH</a>
  </div>
</div>

<!-- First Parallax Image with Logo Text -->
<div class="bgimg-1 w3-display-container w3-opacity-min" id="home">
  <div class="w3-display-middle" style="white-space:nowrap;">
    <span class="w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity"><?php echo strtoupper($xml->title) ?></span>
  </div>
</div>
<?php
   for($i=1;$i<=6;$i++) {
      if(strlen($xml->page[$i-1]->name)>2) {
         if(($i > 1) && (strlen($xml->page[$i-1]->image)>4)) {
            echo "<div class='bgimg-".$i." w3-display-container w3-opacity-min'>";
            echo "<div class='w3-display-middle'>";
            echo "<span class='w3-xxlarge w3-text-white w3-wide'>".ic_strip($xml->page[$i-1]->name)."</span>";
            echo "</div>";
            echo "</div>";
         }
         echo "<div class='w3-content w3-container w3-padding-64' id='p".$i."'>";
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
    ?>   <div>
         <div class="w3-half">    
           <form action="#alert" role="form" method="post">
              <p><input type="text" class="w3-input w3-border" placeholder="Name" name="name"></p>
              <p><input type="text" class="w3-input w3-border" placeholder="Contact Phone #" name="phone"></p>
              <p><input type="email" class="w3-input w3-border" placeholder="Email" name="email"></p>
              <p><input type="text" class="w3-input w3-border" placeholder="Message" name="message"></p>
              <p><button class="w3-button w3-black w3-border" type="submit" id="alert">
                <i class="fa fa-paper-plane"></i> SEND MESSAGE
              </button></p>
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
          }?>
         </div>
         </div><?php
     }
     echo "</div>";
   }
   }
?>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64 w3-opacity w3-hover-opacity-off">
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

// Change style of navbar on scroll
window.onscroll = function() {myFunction()};
function myFunction() {
    var navbar = document.getElementById("myNavbar");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navbar.className = "w3-bar" + " w3-card-2" + " w3-animate-top" + " w3-white";
    } else {
        navbar.className = navbar.className.replace(" w3-card-2 w3-animate-top w3-white", "");
    }
}

// Used to toggle the menu on small screens when clicking on the menu button
function toggleFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

</body>
</html>
