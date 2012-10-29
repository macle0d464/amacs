<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Θεραπείων Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<FORM action="<? echo $_GET['type'] ?>.php" method="GET">
<p>Δώστε τον αριθμό των θεραπείων που θέλετε να εισάγετε: &nbsp; 
<input name="therapies"/></p>
<input type="submit" value="Αποστολή">
</FORM>

</BODY></HTML>