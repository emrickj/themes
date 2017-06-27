<?php

function dispContents($u,$wn,$pn) {
   $x = $GLOBALS['xml'];
   $x2 = $GLOBALS['xml2'];
   $n = $GLOBALS['name'];
   $e = $GLOBALS['email'];
   $s = $GLOBALS['subject'];
   $m = $GLOBALS['message'];      
   if ($n=="") {
       if ($wn=="1") echo str_replace("?p=","?u=".$u."&amp;p=",trim($x->page[$pn-1]->contents));
       if ($wn=="2") echo str_replace("?p=","?u=".$u."&amp;w=2&amp;p=",trim($x2->page[$pn-1]->contents));
   } else {
         mail("emrickj248@comcast.net",$s,$m,"From: ".$n." <".$e.">");
         echo "Contact Information Submitted.  Thank you.";
      }
   echo "\n";
}

?>