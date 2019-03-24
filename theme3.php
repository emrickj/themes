<?php
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   $p = $_GET['p'] ?? '1';
   $w = $_GET['w'] ?? '1';

   require 'dspmenu.php';
   require 'dspcnt.php';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   $page = $xml->xpath("/website/page[name!='']");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title><?php echo strip_tags($xml->title) ?></title>
  <style>
  body {
      position: relative; 
  }
  #p1 {padding-top:50px;}
  #p2 {padding-top:50px;color: #fff; background-color: #1E88E5;}
  #p3 {padding-top:50px;color: #fff; background-color: #673ab7;}
  #p4 {padding-top:50px;color: #fff; background-color: #ff9800;}
  #p5 {padding-top:50px;color: #fff; background-color: #00bcd4;}
  #p6 {padding-top:50px;color: #fff; background-color: #009688;}
<?php echo $xml->style ?>
  </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"><?php echo $xml->title ?></a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
         <?php displayMenu_a() ?>
        </ul>
      </div>
    </div>
  </div>
</nav>

<?php
   $i=1;
   foreach ($page as $item) {
	 echo "<div id='p".$i++."' class='container-fluid' lang='".$item['language']."'>";
	 if(strlen($item->image)>4)
		echo "<img class='img-responsive' style='display: block;margin: auto;' src='".$item->image."'>\n";
	 echo trim($item->contents);
	 if($item['type']=="comments") {

	 // begin htmlcommentbox.com -->
	 echo "<div id='HCB_comment_box' style='color: inherit; background-color: inherit;'>";
?>   <a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
	 <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
	 <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
	 <!-- end htmlcommentbox.com --><?php
	  }
	  if($item['type']=="form") {
?>    <form class="form-horizontal" role="form" method="post">
		<div class="form-group">
		   <label class="control-label col-sm-3" for="name">Name:</label>
		   <div class="col-sm-6">
			  <input type="text" class="form-control" name="name">
		   </div>
		</div>
		<div class="form-group">
		   <label class="control-label col-sm-3" for="phone">Contact Phone #:</label>
		   <div class="col-sm-6">
			  <input type="text" class="form-control" name="phone">
		   </div>
		</div>
		<div class="form-group">
		   <label class="control-label col-sm-3" for="email">Email Address:</label>
		   <div class="col-sm-6">
			  <input type="email" class="form-control" name="email">
		   </div>
		</div>
		<div class="form-group">
		   <label class="control-label col-sm-3" for="message">Message:</label>
		   <div class="col-sm-6">
			  <textarea class="form-control" rows="5" name="message"></textarea>
			  <br>
			  <input type="submit" class="btn btn-default" value="Submit">
		   </div>
		</div>
	 </form>
<?php
	  if ($name!="")
		if(sendDb($name,$phone,$email,$message)) {
		   echo "<div class='alert alert-success'>";
		   echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
		   echo "</div>";
		} else {
		   echo "<div class='alert alert-info'>";
		   echo "<b>Missing Name or Contact Info.</b>";
		   echo "</div>";
		}
	 }
	 echo "</div>";
   }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body>
</html>
