<?php

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
       mysql_connect("sql209.byethost4.com",$username,$password);
       @mysql_select_db($database) or die( "Unable to select database");

       $query = "INSERT INTO idscts (name,phone,email,message) VALUES ('$n','$ph','$e','$m')";
       mysql_query($query);

       mysql_close();

       return true;
    }
}

?>