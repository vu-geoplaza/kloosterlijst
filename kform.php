<?php

include('db_connect.inc');
if(! $db) {
	die("Kan niet verbinden: ".mysqli_error());
}
?>

<?php
function qdbconn() {
    mysqli_close($db);
}
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="mp.css" />
<title>Kloosterlijst</title>
</head>
<body>

<div id="links">
<?php
include("menu.inc");
?>
</div>
<div id="content">
<table width="100%">
<tr><td align="left"><a href="http://www.fgw.vu.nl"><img src="images/logo_fgw.gif" border="0"></a></td><td align="right"><a href="http://www.vu.nl"><img src="images/grif.gif" width="312" height="104" border="0"></a></td>
</tr></table>
<h1 class="indent">Kloosterlijst</h1>
<h3 class="indent">Zoeken in de kloosterlijst</h3>
<hr>
<p class="indent">
Indien het gezochte klooster in de Titellijst niet wordt gevonden, zijn er twee mogelijkheden:<br /> 
a.	Het komt in het bestand voor onder een andere plaatsnaam. Raadpleeg eerst de <strong>Topografische verwijslijst</strong> via het linkermenu en ga dan terug naar de Titellijst.<br /> 
b.	Het komt niet in het bestand voor, omdat het is ge&euml;limineerd. Ga via het linkermenu naar de <strong>Eliminatielijst</strong>.
</p>
<p>

<form action="kres.php" method="post" class="indent">
<table  bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
  <tr>
    <td><strong>Titel:</strong><br /> 
<?php 
include("input_cl.php");
    if(! ($result = mysqli_query($db,"SELECT DISTINCT TI FROM Kloosterlijst"))){
	echo 'invalid query<br>';
    }
?>
<select name="optionti" class="size1">
<option value="" SELECTED>- selecteer -</option>
<?php 
while ($row = mysqli_fetch_array($result)) {
	echo "<option value=\"$row[TI]\">$row[TI]</option>\n"; 
} 
?>  
</select></td>
    <td><strong>Identificatienummer:</strong> <br />
<input type="text" name="id" class="size2"></td>
  </tr>
  <tr>
    <td><strong>Diocees:</strong><br />
<?php $result = mysqli_query($db,"SELECT DISTINCT DI FROM Kloosterlijst ORDER BY DI");
?>
<select name="optiondi" class="size2">
<option value="" SELECTED>- selecteer -</option> 
<?php  
while ($row = mysqli_fetch_array($result)) {
echo "<option value=\"$row[DI]\">$row[DI]</option>\n"; 
} 
?>  
</select></td>
    <td><strong>Patroonheilige:</strong> <br />
<input type="text" name="pt" class="size2"></td>
  </tr>
  <tr>
    <td><strong>Provincie, gewest, land:</strong><br />
<?php $result = mysqli_query($db,"SELECT DISTINCT PV FROM Kloosterlijst ORDER BY PV");
?>
<select name="optionpv" class="size2"> 
<option value="" SELECTED>- selecteer -</option>
<?php  
while ($row = mysqli_fetch_array($result)) {
echo "<option value=\"$row[PV]\">$row[PV]</option>\n"; 
} 
?>  
</select></td>
    <td><strong>Alias:</strong> <br />
<input type="text" name="al" class="size2"></td>
  </tr>
  <tr>
    <td><strong>Gender:</strong> <br />
<?php $result = mysqli_query($db,"SELECT DISTINCT GE FROM Kloosterlijst ORDER BY GE");
?>
<select name="optionge" class="size2"> 
<option value="" SELECTED>- selecteer -</option>
<?php  
while ($row = mysqli_fetch_array($result)) {
echo "<option value=\"$row[GE]\">$row[GE]</option>\n"; 
} 
?>  
</select></td>
    <td><strong>Parochie:</strong> <br />
<input type="text" name="pa" class="size2"></td>
  </tr>
  <tr>
    <td align="center"></td>
    <td><strong>Stadia: [<a href="thesaurusST.pdf" title="thesaurus stadia" target="_blank">thesaurus</a>]</strong> <br />
<input type="text" name="st" class="size2"></td>
  </tr>
    <tr>
    <td align="center"></td>
    <td><strong>Eerste vermelding [vanaf jaar]:</strong> <br />
<input type="number" name="ev" class="size2"></td>
  </tr>
      <tr>
    <td align="center"><input type="submit" name="knop" value="zoeken"class="button" /> <input type="reset" value="wissen"class="button" /></td>
    <td><strong>Laatste vermelding [tot jaar]:</strong> <br />
<input type="number" name="lv" class="size2"></td>
  </tr>
</table>

</form>
</p>
</div>
<div id="rechts">
</div>
<div id="onder">
<p class="vu">
<img src="images/vu.gif" width="195" height="24">
</p>
</div>
</body>
</html>
