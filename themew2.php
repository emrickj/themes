<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
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
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
</style>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Company<br>Name</b></h3>
  </div>
  <div class="w3-bar-block">
   <?php
   for($i=1;$i<=6;$i++) {
     if(strlen($xml->page[$i-1]->name)>2) 
        echo "<a href='#".$i."' onclick='w3_close()' class='w3-bar-item w3-button w3-hover-white'>" . ic_html($xml->page[$i-1]->name) . "</a>";
   }
   ?>  
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">&#9776;</a>
  <span>Company Name</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b><?php echo strip_tags($xml->title) ?></b></h1>
  </div>
<?php
   for($i=1;$i<=6;$i++) {
      if(strlen($xml->page[$i-1]->name)>2) {
         echo "<div class='w3-container' style='margin-top:80px' id='".$i."'>";
         echo "<h1 class='w3-xxxlarge w3-text-red'><b>".$xml->page[$i-1]->name.".</b></h1>";
         echo "<hr style='width:50px;border:5px solid red' class='w3-round'>";
      }
      if(strlen($xml->page[$i-1]->image)>4)
         echo "<img class='w3-image' src='".$xml->page[$i-1]->image."' style='width:100%'>\n";
      echo trim($xml->page[$i-1]->contents);
      echo "</div>";
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
       <input type="submit" class="w3-button w3-red w3-margin-bottom" value="Submit">
       </div>
     </div>  
     </form><?php
      if ($name!="") {
        $username="username";
        $password="password";
        $database="database";

        if ($name=="" || ($phone=="" && $email=="")) {
           echo "<div class='w3-panel w3-blue' id='alert'>";
           echo "<b>Missing Name or Contact Info.</b>";
           echo "</div>";
        } else {
           $link = mysqli_connect("sql209.byethost4.com",$username,$password,$database);
           //@mysql_select_db($database) or die( "Unable to select database");

           $query = "INSERT INTO idscts (name,phone,email,message) VALUES ('$name','$phone','$email','$message')";
           mysqli_query($link,$query);

           mysqli_close($link);
           
           echo "<div class='w3-panel w3-green' id='alert'>";
           echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
           echo "</div>";
         }
       }
     }
   }
?>

  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
    <span class="w3-button w3-black w3-xxlarge w3-display-topright">?</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>


<!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>