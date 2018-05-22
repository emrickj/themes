<?php
   //ini_set('display_errors', 'On');
   //error_reporting(E_ALL);

   if(isset($_GET['p'])) $p = $_GET['p'];
      else $p="1";

   $si=(include 'dspmenu.php') or die("<br><br>Error: Unable to access 'dspmenu.php'.  Make sure this file is in the directory where the theme file is.");
   $si=(include 'dspcnt.php') or die("<br><br>Error: Unable to access 'dspcnt.php'.  Make sure this file is in the directory where the theme file is.");
   
   $xml=simplexml_load_file("data/website".$b.".xml") or die("<br><br>Error: Cannot create object, please make sure that 'website".$b.".xml' is in the 'data' directory.");
   $page=$xml->xpath("/website/page[".$p."]");
   changeLinks($page);

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
   echo "<body class='page".$p."' id='demo'>\n";
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#"><?php echo $xml->title ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <?php
         $pn=$xml->xpath("/website/page/name[.!='']");
		 displayMenu_x($pn);
		?>
      </ul>
    </div>
  </div>
</nav>
   <div class="container">
      <div class="row">
         <div class="col-sm-2">
         </div>
         <div class="col-sm-8">
            <?php
            if(strlen($page[0]->image)>4)
               echo "<img class='img-responsive' src='".$page[0]->image."'>\n";
            ?>
            <br>
         </div>
         <div class="col-sm-2">
         </div>
      </div>
      <div class="row">
         <div class="col-sm-2">
         </div>
         <div class="col-sm-8">
                     <?php
                        if($name=="") echo $page[0]->contents;
                           else if(sendEmail($name,$email,$subject,$message))
                              echo "Contact Information Submitted.  Thank you.";
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
                                 <label class="control-label col-sm-3" for="email">Email Address:</label>
                                 <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label col-sm-3" for="subject">Subject:</label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="subject">
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
                           </form><?php
                        }
                        if($page[0]['type']=="comments" && $name=="") {
                     ?>
                           <!-- begin htmlcommentbox.com -->
                           <div id="HCB_comment_box" style="background-color: transparent;"><a href="https://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
                           <link rel="stylesheet" type="text/css" href="https://www.htmlcommentbox.com/static/skins/default/skin.css" />
                           <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "https://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
                           <!-- end htmlcommentbox.com --><?php
                        }
                     ?>          
         </div>
         <div class="col-sm-2">
         </div>
      </div>
   </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
