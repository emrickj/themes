<?php
   error_reporting(0);

   $name = $_POST['name'];
   $phone = $_POST['phone']; // Used when submitting to database
   $email = $_POST['email'];
   $subject = $_POST['subject']; // Used when sending email
   $message = $_POST['message'];
   
   error_reporting(E_ALL);
   
   if(isset($_GET['u']) && $_GET['u']!="") $b = "_".$_GET['u'];
      else $b="";
   // echo "--".$b."--";
   
// Use the following optional function to help index content of website on search engines.  Place this function in the head section of document.
   
function paginatePage($pn) {
   $x = $GLOBALS['xml'];
   $ws = $GLOBALS['w'];
   if ($ws=="1") {
	   if ($pn > "1") echo "<link rel='prev' href='?p=".($pn - 1)."'>\n";
	   if (($pn < "6") && strlen($x->page[intval($pn)]->name)>2) echo "<link rel='next' href='?p=".($pn + 1)."'>\n";
   }
}

function dispContents($pn,$u="",$wn=1) {
   $x = $GLOBALS['xml'];
   $x2 = $GLOBALS['xml2'];
   if($u!="") $us="u=".$u."&amp;"; else $us="";
   if (intval($wn)==1) echo str_replace('"?p=','"?'.$us.'p=',trim($x->page[$pn-1]->contents));
   if (intval($wn)==2) echo str_replace('"?p=','"?'.$us.'w=2&amp;p=',trim($x2->page[$pn-1]->contents));
}

function sendEmail($n,$e,$s,$m) {
   mail("emrickj248@comcast.net",$s,$m,"From: ".$n." <".$e.">");
   return true;
}

function sendDb($n,$ph,$e,$m) {
    $username="username";
    $password="password";
    $database="database";

    if ($n=="" || ($ph=="" && $e=="")) {
       return false;
    } else {
       $link = mysqli_connect("sql209.byethost4.com",$username,$password, $database);

       $query = "INSERT INTO idscts (name,phone,email,message) VALUES ('$n','$ph','$e','$m')";
       mysqli_query($link,$query);

       mysqli_close($link);

       return true;
    }
}

?>