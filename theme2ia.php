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

.affix {
    top: 0;
    width: 100%;
}

.affix + .container {
    padding-top: 70px;
}

.bgimg {
    background-image: url("<?php echo $page[0]->image ?>");
    background-color: #C0C0C0;
    background-attachment: fixed;
    background-position: center top;
    background-size: auto 400px;
    min-height: 400px;
}

<?php 
   echo $xml->style;
   echo "</style>\n";
   echo "</head>\n";
   echo "<body class='page".$p."' id='demo'>\n";
?>
<div class="bgimg"></div>
<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="400" style="z-index: 5;">
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
