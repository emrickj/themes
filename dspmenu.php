<?php

function ic_html($pname) {
  if (strpos(" ".$pname,chr(0xef))==1) $rt = '<i class="fa">'.substr($pname,0,3).'</i> '.substr($pname,4);
     else $rt = $pname;
  return $rt;
}

function displayMenu_x($pname,$ws=1,$as="active") {
	$pn = $GLOBALS['p'];
	$wn = isset($_GET['w']) ? $_GET['w'] : "1";
	$u = $GLOBALS['b'];
	if($u!="") $us="u=".ltrim($u,"_")."&"; else $us="";
	if($ws>1) $wp="w=".$ws."&"; else $wp="";
	$i=1;
    foreach ($pname as $item) {
	   if($i==$pn && $ws==$wn) $bs=" class='".$as."'"; else $bs="";
	   echo "<li".$bs."><a href='?".$us.$wp."p=".$i++."'>"
            . str_replace('"fa','"fa fa-fw',ic_html($item)) . "</a></li>\n";
	}
}

// function below is used for Bootstrap 4.0 Dropdowns

function displayMenu_xd($pname,$ws=1) {
	$pn = $GLOBALS['p'];
	$wn = isset($_GET['w']) ? $_GET['w'] : "1";
	$u = $GLOBALS['b'];
	if($u!="") $us="u=".ltrim($u,"_")."&"; else $us="";
	if($ws>1) $wp="w=".$ws."&"; else $wp="";
	$i=1;
    foreach ($pname as $item) {
	   if($i==$pn && $ws==$wn) $bs=" active"; else $bs="";
	   echo "<li><a class='dropdown-item".$bs."' href='?".$us.$wp."p=".$i++."'>"
            . str_replace('"fa','"fa fa-fw',ic_html($item)) . "</a></li>\n";
	}
}

// function below is used for Bootstrap 4.0 Navigation Bars

function displayMenu_xn($pname,$ws=1) {
	$pn = $GLOBALS['p'];
	$wn = isset($_GET['w']) ? $_GET['w'] : "1";
	$u = $GLOBALS['b'];
	if($u!="") $us="u=".ltrim($u,"_")."&"; else $us="";
	if($ws>1) $wp="w=".$ws."&"; else $wp="";
	$i=1;
    foreach ($pname as $item) {
	   if($i==$pn && $ws==$wn) $bs=" active"; else $bs="";
	   echo "<li class='nav-item'><a class='nav-link".$bs."' href='?".$us.$wp."p=".$i++."'>"
            . str_replace('"fa','"fa fa-fw',ic_html($item)) . "</a></li>\n";
	}
}

function displayMenu_a() {
   $pn = $GLOBALS['page'];
   $i=1;
   foreach ($pn as $item) {
      echo "<li><a href='#p".$i++."'>" . ic_html($item->name) . "</a></li>\n";
   }
}

// function below is used for Bootstrap 4.0 Navigation

function displayMenu_na() {
   $pn = $GLOBALS['page'];
   $i=1;
   foreach ($pn as $item) {
	  echo "<li class='nav-item'><a class='nav-link' href='#p".$i++."'>" . ic_html($item->name) . "</a></li>\n";
   }	   
}
