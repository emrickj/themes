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