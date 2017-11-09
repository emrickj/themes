<?php

function ic_html($pname) {
  if (strpos(" ".$pname,chr(0xef))==1) $rt = '<i class="fa">'.substr($pname,0,3).'</i> '.substr($pname,4);
     else $rt = $pname;
  return $rt;
}

function displayMenu($pn,$as="active",$wn=1,$ws=1) {
   $x = $GLOBALS['xml'];
   $x2 = $GLOBALS['xml2'];
   $u = $GLOBALS['b'];
   $n = $GLOBALS['name'];
   if($u!="") $us="u=".ltrim($u,"_")."&"; else $us="";
   for($i=1;$i<=6;$i++) {
      if($i==$pn && intval($wn)==1 && $n=="") $bs=" class='".$as."'"; else $bs="";
      if($i==$pn && intval($wn)==2 && $n=="") $bs2=" class='".$as."'"; else $bs2="";
      if(intval($ws)==1 && strlen($x->page[$i-1]->name)>2) 
         echo "<li".$bs."><a href='?".$us."p=".$i."'>"
            . str_replace('"fa','"fa fa-fw',ic_html($x->page[$i-1]->name)) . "</a></li>\n";
      if(intval($ws)==2 && strlen($x2->page[$i-1]->name)>2) 
         echo "<li".$bs2."><a href='?".$us."w=2&p=".$i."'>" 
            . str_replace('"fa','"fa fa-fw',ic_html($x2->page[$i-1]->name)) . "</a></li>\n";
   }
}

// function below is used for Bootstrap 4.0 Dropdowns

function displayMenu_dd($pn,$wn=1,$ws=1) {
   $x = $GLOBALS['xml'];
   $x2 = $GLOBALS['xml2'];
   $u = $GLOBALS['b'];
   $n = $GLOBALS['name'];
   if($u!="") $us="u=".ltrim($u,"_")."&"; else $us="";
   for($i=1;$i<=6;$i++) {
      if($i==$pn && intval($wn)==1 && $n=="") $bs=" active"; else $bs="";
      if($i==$pn && intval($wn)==2 && $n=="") $bs2=" active"; else $bs2="";
      if(intval($ws)==1 && strlen($x->page[$i-1]->name)>2) 
         echo "<li><a class='dropdown-item".$bs."' href='?".$us."p=".$i."'>"
            . str_replace('"fa','"fa fa-fw',ic_html($x->page[$i-1]->name)) . "</a></li>\n";
      if(intval($ws)==2 && strlen($x2->page[$i-1]->name)>2) 
         echo "<li><a class='dropdown-item".$bs2."' href='?".$us."w=2&p=".$i."'>" 
            . str_replace('"fa','"fa fa-fw',ic_html($x2->page[$i-1]->name)) . "</a></li>\n";
   }
}

// function below is used for Bootstrap 4.0 Navigation Bars

function displayMenu_nb($pn,$wn=1,$ws=1) {
   $x = $GLOBALS['xml'];
   $x2 = $GLOBALS['xml2'];
   $u = $GLOBALS['b'];
   $n = $GLOBALS['name'];
   if($u!="") $us="u=".ltrim($u,"_")."&"; else $us="";
   for($i=1;$i<=6;$i++) {
      if($i==$pn && intval($wn)==1 && $n=="") $bs=" active"; else $bs="";
      if($i==$pn && intval($wn)==2 && $n=="") $bs2=" active"; else $bs2="";
      if(intval($ws)==1 && strlen($x->page[$i-1]->name)>2) 
         echo "<li class='nav-item'><a class='nav-link".$bs."' href='?".$us."p=".$i."'>"
            . str_replace('"fa','"fa fa-fw',ic_html($x->page[$i-1]->name)) . "</a></li>\n";
      if(intval($ws)==2 && strlen($x2->page[$i-1]->name)>2) 
         echo "<li class='nav-item'><a class='nav-link".$bs2."' href='?".$us."w=2&p=".$i."'>" 
            . str_replace('"fa','"fa fa-fw',ic_html($x2->page[$i-1]->name)) . "</a></li>\n";
   }
}

function displayMenu_a() {
   $x = $GLOBALS['xml'];
   for($i=1;$i<=6;$i++) {
      if(strlen($x->page[$i-1]->name)>2) {
         echo "<li><a href='#p".$i."'>" . str_replace('"fa','"fa fa-fw',ic_html($x->page[$i-1]->name))
               . "</a></li>\n";
      }
   }   
}

?>