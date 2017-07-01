<?php

function ic_html($pname) {
  if (strpos(" ".$pname,chr(0xef))==1) $rt = '<i class="fa">'.substr($pname,0,3).'</i> '.substr($pname,4);
     else $rt = $pname;
  return $rt;
}

function displayMenu($pn) {
   $x = $GLOBALS['xml'];
   $u = $GLOBALS['b'];
   $n = $GLOBALS['name'];
   for($i=1;$i<=6;$i++) {
      if($i==$pn && $n=="") $bs=" class='active'"; else $bs="";
      if(strlen($x->page[$i-1]->name)>2) 
         echo "<li".$bs."><a href='?u=".ltrim($u,"_")."&p=".$i."'>" 
              . ic_html($x->page[$i-1]->name) . "</a></li>";
   }
}

?>
