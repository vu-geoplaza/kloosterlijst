<?php
$db = include('db_connect.inc');
if(! $db) {
	die("Kan niet verbinden: ".mysqli_error());
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
<?php include("header.inc"); ?>
<h3 class="indent">Searching for collegiate churches</h3>
<hr>

<p class="indent">Search for collegiate churches according to location (parish).
<form action="kapres.php" method="post" class="indent">
<table  bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
  <tr>
    <td><strong>Select a place:</strong><br /> 
<?php 
include("input_cl.php");
    if(! ($result = mysqli_query($db, "SELECT DISTINCT Place FROM KapittelsEng ORDER BY Place"))){
	echo 'invalid query<br>';
    }
?>
<select name="optionkappl" class="size1">
<option value="" SELECTED>- select -</option> 
<?php 
while ($row = mysqli_fetch_array($result)) {
	echo "<option value=\"$row[Place]\">$row[Place]</option>\n"; 
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
<img src="../images/vu.gif" width="195" height="24">
</p>
</div>
</body>
</html>
