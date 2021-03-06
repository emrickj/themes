<?php
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   $p = $_GET['p'] ?? '1';
   $w = $_GET['w'] ?? '1';

   require 'dspcnt.php';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   $page = $xml->xpath("/website/page[name!='' and position()<=4]");
   
   function icon($pname) {
      if (strpos(" ".$pname,chr(0xef))==1) $rt = substr($pname,0,3);
         else $rt = "&#xf0ec;";
      return $rt;
   }
   
   function ic_strip($pname) {
      if (strpos(" ".$pname,chr(0xef))==1) $rt = strtoupper(substr($pname,4));
         else $rt = strtoupper($pname);
      return $rt;
   }

   //if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
.w3-row-padding img {margin-bottom: 12px}
/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 120px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}
</style>
<body class="w3-black">

<!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <!-- Avatar image in top left corner -->
  <img src="<?php echo $page[0]->image ?>" style="width:100%">
  <a href="#p1" class="w3-bar-item w3-button w3-padding-large w3-black">
    <i class="fa w3-xxlarge"><?php echo icon($page[0]->name) ?></i>
    <p><?php echo ic_strip($page[0]->name) ?></p>
  </a>
   <?php
   $i=0;
   foreach ($page as $item)
     if(++$i!=1)
        echo "<a href='#p".$i."' class='w3-bar-item w3-button w3-padding-large w3-hover-black'><i class='fa w3-xxlarge'>"
        . icon($item->name) . "</i><p>" . ic_strip($item->name) . "</p></a>";
   ?>  
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
   <?php
   $i=1;
   foreach ($page as $item)
	 echo "<a href='#p".$i++."' class='w3-bar-item w3-button' style='width:25% !important'>"
	 . ic_strip($item->name) . "</a>";
   ?>  
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large" id="main">
  <!-- Header/Home -->
  <header class="w3-container w3-padding-32 w3-center w3-black" id="p1" lang="<?php echo $page[0]['language'] ?>">
<?php
    echo trim($page[0]->contents);
?>
    <img src="<?php echo $page[0]->image ?>" class="w3-image" width="992" height="1108">
  </header>

<?php
   $i=0;
   foreach ($page as $item) {
	   if (++$i!=1) {
		  if($item['type']=="page") {
			echo "<div class='w3-padding-64 w3-content' id='p".$i."' lang='".$item['language']."'>";
			echo trim($item->contents);
			echo "</div>";
		  }
		  if($item['type']=="comments") {

		 // begin htmlcommentbox.com -->
		 echo "<div id='p".$i."'></div>";
		 echo "<div class='w3-padding-64 w3-content w3-black' id='HCB_comment_box'>";
	?>   <a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
		 <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
		 <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
		 <!-- end htmlcommentbox.com --><?php
		  }
		  if($item['type']=="form") {

		 echo "<div class='w3-padding-64 w3-content' id='p".$i."'>";
		 echo trim($item->contents);
	?>   <div class="w3-row-padding">
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
		   <button class="w3-button w3-light-grey w3-margin-bottom" type="submit" id="alert">
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
	?>
		 </div>
		 </div>
		 </div><?php
		 }
	   }
   }
?>  
    <!-- Footer -->
  <footer class="w3-content w3-padding-64 w3-text-grey w3-xlarge">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
    <p class="w3-medium">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank" class="w3-hover-text-green">w3.css</a></p>
  <!-- End footer -->
  </footer>

<!-- END PAGE CONTENT -->
</div>

</body>
</html>
