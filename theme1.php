<?php
   ini_set('display_errors', 'On');
   error_reporting(E_ALL);

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";

   if(isset($_GET['w'])) $w = $_GET['w'];
      else $w="1";

   require 'dspmenu.php';
   require 'dspcnt.php';

   $xml=simplexml_load_file("data/website".$b.".xml") or die("Error: Cannot create object");
   $xml2=simplexml_load_file("data/website2.xml") or die("Error: Cannot create object");
   $xpath="/website/page[position()=".$p."]";
   if ($w=="2") $page = $xml2->xpath($xpath); else $page = $xml->xpath($xpath);

   $lang = $page[0]['language'];
   if ($lang == "") $lang="en";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title><?php echo strip_tags($xml->title) ?></title>
<style>
t1 { white-space: pre-wrap;}
<?php 
   echo $xml->style;
   echo "</style>\n";
   echo "</head>\n";
   echo "<body";
   if ($w=="1") echo " class='page".$p."'";
   echo " id='demo'>\n";
?>
<nav class="navbar navbar-default navbar-fixed-top hidden-sm hidden-md hidden-lg">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="<?php echo "?u=".ltrim($b,"_") ?>"><?php echo $xml->title ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <?php
         $pn=$xml->xpath("/website/page/name[string-length()!=0]");
		 displayMenu_x($pn);
		?>
      </ul>
    </div>
  </div>
</nav>
   <div class="container">
      <div class="row">
         <div class="hidden-sm hidden-md hidden-lg" style="padding-top: 50px;"></div>
         <div class="col-sm-3" style="padding: 20px">
         <b><h2><?php echo $xml->title ?></h2></b>
         </div>
         <div class="col-sm-9">
            <?php
               if(strlen($page[0]->image)>4)
                  echo "<img class='img-responsive' src='".$page[0]->image."'>\n";
            ?>
            <br>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-3 hidden-xs">
                  <br>
                  <div class="btn-group-vertical btn-group-lg">
                     <?php
					 $i=1;
                     foreach ($pn as $item) {
                       if($i==$p && $w=="1" && $name=="") $bs="active"; else $bs="";
                       echo "<a href='?u=".ltrim($b,"_")."&p=".$i++."' class='btn btn-primary "
                       .$bs."'>" . ic_html($item) . "</a>";
                     }
                     ?>
                     <ul class="dropdown-menu" role="menu">
                     <?php
						$pn2=$xml2->xpath("/website/page/name[string-length()!=0]");
					    displayMenu_x($pn2,2);						
					 ?>
                     </ul>
                     <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                     <?php echo strip_tags($xml2->title) ?> <span class="caret"></span></button>
                  </div>
                  <br>
                  <br>
         </div>
         <div class="col-sm-9">
           <div class="panel panel-primary">
               <div class="panel-body">
                     <?php
                        if($name=="") dispContents($p,ltrim($b,"_"),$w);
                        else if(sendDb($name,$phone,$email,$message))
                                echo "<b>Contact information submitted.  We will contact you as soon as possible.</b>";
                             else echo "<b>Missing Name or Contact Info.</b>";
                        echo "\n";
                        if($page[0]['type']=="form" && $name=="") {
                     ?>
                           <form class="form-horizontal" role="form" method="post">
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
                                    <input type="submit" class="btn btn-info" value="Submit">
                                 </div>
                              </div>
                           </form><?php
                        }
                        if($page[0]['type']=="comments" && $w=="1" && $name=="") {
                     ?>
                           <!-- begin htmlcommentbox.com -->
                           <div id="HCB_comment_box"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
                           <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
                           <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
                           <!-- end htmlcommentbox.com --><?php
                        }
                     ?>
               </div>          
           </div>
         </div>
      </div>
	  <center>This website was created using <a href="https://www.gem-editor.com">GEM</a>.</center>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
