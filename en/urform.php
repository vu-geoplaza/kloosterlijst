<?php
$db = include('db_connect.inc');
if(! $db) {
	die("Kan niet verbinden: ".mysql_error());
}
?>

<?php
function qdbconn() {
mysql_close($db);
}
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="mp.css" />
<title>Monasteries in the Netherlands until 1800</title>
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
<h1 class="indent">Monasteries in the Netherlands until 1800</h1>
<h3 class="indent">Searching for granges and urban refuges</h3>
<hr>
<p class="indent">Search for granges and urban refuges starting from the monastery to which they belong. If you make no choice, a survey of all granges and urban refuges will be shown.
<form action="urres.php" method="post" class="indent">
<table  bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
  <tr>
    <td><strong>Search for granges and urban refuges<br /> starting from the monastery to which they belong:</strong><br /> 
<?php 
include("input_cl.php");
    if(! ($result = mysql_query("SELECT DISTINCT Monastery FROM UithovenEng ORDER BY Monastery", $db))){
	echo 'invalid query<br>';
    }
?>
<select name="optionti" class="size1">
<option value="" SELECTED>- select -</option> 
<?php 
while ($row = mysql_fetch_array($result)) { 
	echo "<option value=\"$row[Monastery]\">$row[Monastery]</option>\n"; 
} 
?>  
</select>
  <tr>
    <td align="center"><input type="submit" name="knop" value="search"class="button" /> <input type="reset" value="clear"class="button" /></td>
  </tr>
</table>
</form>
</p>

<p class="indent">Search for granges and urban refuges according to their location and/or their name.
<form action="urplres.php" method="post" class="indent">
<table  bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
  <tr>
    <td><strong>Select a place and/or name:</strong><br /> 
    Place:<br>
<?php 
include("input_cl.php");
    if(! ($result = mysql_query("SELECT DISTINCT Place FROM UithovenEng ORDER BY Place", $db))){
	echo 'invalid query<br>';
    }
?>
<select name="optionurpl" class="size1">
<option value="" SELECTED>- select -</option> 
<?php 
while ($row = mysql_fetch_array($result)) { 
	echo "<option value=\"$row[Place]\">$row[Place]</option>\n"; 
} 
?>  
</select><br />
Name:<br />
<?php 
include("input_cl.php");
    if(! ($result = mysql_query("SELECT DISTINCT Name FROM UithovenEng ORDER BY Name", $db))){
	echo 'invalid query<br>';
    }
?>
<select name="optionurn" class="size1">
<option value="" SELECTED>- select -</option> 
<?php 
while ($row = mysql_fetch_array($result)) { 
	echo "<option value=\"$row[Name]\">$row[Name]</option>\n"; 
} 
?>  
</select>
  <tr>
    <td align="center"><input type="submit" name="knop" value="search"class="button" /> <input type="reset" value="clear"class="button" /></td>
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
