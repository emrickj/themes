<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
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

   require 'dspcnt.php';
   //if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
?>
	<title><?php echo strip_tags($xml->title) ?></title>
  <style>
  body {
      position: relative; 
  }
  #p1 {padding-top:70px;padding-bottom:70px;}
  #p2 {padding-top:70px;padding-bottom:70px;color: #fff; background-color: #1E88E5;}
  #p3 {padding-top:70px;padding-bottom:70px;color: #fff; background-color: #673ab7;}
  #p4 {padding-top:70px;padding-bottom:70px;color: #fff; background-color: #ff9800;}
  #p5 {padding-top:70px;padding-bottom:70px;color: #fff; background-color: #00bcd4;}
  #p6 {padding-top:70px;padding-bottom:70px;color: #fff; background-color: #009688;}
  @media (min-width: 576px) {
	  form label {text-align: right;}
  }
<?php echo $xml->style ?>
  </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
      <a class="navbar-brand" href="#"><?php echo $xml->title ?></a>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">
		  <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="navbar-nav">
         <?php
         for($i=1;$i<=6;$i++) {
           if(strlen($xml->page[$i-1]->name)>2) 
              echo "<li class='nav-item'><a class='nav-link' href='#p".$i."'>" . ic_html($xml->page[$i-1]->name) . "</a></li>";
         }
         ?>  
        </ul>
      </div>
</nav>

<?php
   for($i=1;$i<=6;$i++) {
      if(strlen($xml->page[$i-1]->name)>2) {
         echo "<div id='p".$i."' class='container-fluid'>";
         if(strlen($xml->page[$i-1]->image)>4)
            echo "<img class='img-fluid' style='display: block;margin: auto;' src='".$xml->page[$i-1]->image."'>\n";
         echo trim($xml->page[$i-1]->contents);
         if($xml->page[$i-1]['type']=="comments") {

         // begin htmlcommentbox.com -->
         echo "<div id='HCB_comment_box' style='color: inherit; background-color: inherit;'>";
    ?>   <a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
         <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
         <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
         <!-- end htmlcommentbox.com --><?php
          }
          if($xml->page[$i-1]['type']=="form") {
    ?>    <form class="form-horizontal" role="form" method="post">
            <div class="form-group row">
               <label class="col-form-label col-sm-4" for="name">Name:</label>
               <div class="col-sm-6">
                  <input type="text" class="form-control" name="name">
               </div>
            </div>
            <div class="form-group row">
               <label class="col-form-label col-sm-4" for="phone">Contact Phone #:</label>
               <div class="col-sm-6">
                  <input type="text" class="form-control" name="phone">
               </div>
            </div>
            <div class="form-group row">
               <label class="col-form-label col-sm-4" for="email">Email Address:</label>
               <div class="col-sm-6">
                  <input type="email" class="form-control" name="email">
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
   }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</body>
</html>