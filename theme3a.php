<?php
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   $p = $_GET['p'] ?? '1';
   $w = $_GET['w'] ?? '1';

   require 'dspcnt.php';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   $page = $xml->xpath('/website/page');
   
   function ic_html($pname) {
      if (strpos(" ".$pname,chr(0xef))==1) $rt = '<i class="fa">'.substr($pname,0,3).'</i> '.substr($pname,4);
         else $rt = $pname;
      return $rt;
   }

   //if($_SERVER['HTTPS']) $mps="https://"; else $mps="http://";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title><?php echo strip_tags($xml->title) ?></title>
  <style>
  body {
      position: relative; 
  }
  .affix {
      top:0;
      width: 100%;
      z-index: 9999 !important;
  }
  .navbar {
      margin-bottom: 0px;
  }

  .affix ~ .container-fluid {
     position: relative;
     top: 50px;
  }
  
  .bgimg {
     background-image: url("<?php echo $page[0]->image ?>");
     background-color: #C0C0C0;
     background-attachment: fixed;
     background-position: center top;
     background-size: auto 400px;
     min-height: 400px;
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
<div class="bgimg"></div>
<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="400">
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
         <?php
         for($i=1;$i<=6;$i++) {
           if(strlen($page[$i-1]->name)>2) 
              echo "<li><a href='#p".$i."'>" . ic_html($page[$i-1]->name) . "</a></li>";
         }
         ?>  
        </ul>
      </div>
    </div>
  </div>
</nav>

<?php
   for($i=1;$i<=6;$i++) {
      if(strlen($page[$i-1]->name)>2) {
         echo "<div id='p".$i."' class='container-fluid'>";
         if($i>1)
            if(strlen($page[$i-1]->image)>4)
               echo "<img class='img-responsive' style='display: block;margin: auto;' src='".$page[$i-1]->image."'>\n";
         echo trim($page[$i-1]->contents);
         if($page[$i-1]['type']=="comments") {

         // begin htmlcommentbox.com -->
         echo "<div id='HCB_comment_box' style='color: inherit; background-color: inherit;'>";
    ?>   <a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
         <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
         <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
         <!-- end htmlcommentbox.com --><?php
          }
          if($page[$i-1]['type']=="form") {
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
   }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
