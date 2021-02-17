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
<h3 class="indent">Searching for monasteries</h3>
<hr>
<p class="indent">
If the monastery looked for is not found in the list of Titles there are two possibilities:<br>
a. It is included in the database under a different toponym. Consult the <strong>Topographical Index</strong> in the Menu at the left and then return to the list of Titles.<br>
b. It has been eliminated. Go to the <strong>List of Eliminations</strong> in the Menu at the left.

</p>
<p>

<form action="kres.php" method="post" class="indent">
<table  bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
  <tr>
    <td><strong>Title:</strong><br /> 
<?php 
include("input_cl.php");
    if(! ($result = mysqli_query($db, "SELECT DISTINCT TI FROM KloosterlijstEng"))){
	echo 'invalid query<br>';
    }
?>
<select name="optionti" class="size1">
<option value="" SELECTED>- select -</option> 
<?php 
while ($row = mysqli_fetch_array($result)) {
	echo "<option value=\"$row[TI]\">$row[TI]</option>\n"; 
} 
?>  
</select></td>
    <td><strong>Unique identity marker (IDNR):</strong> <br />
<input type="text" name="id" class="size2"></td>
  </tr>
  <tr>
    <td><strong>Diocese:</strong><br />
<?php $result = mysqli_query($db, "SELECT DISTINCT DI FROM KloosterlijstEng ORDER BY DI");
?>
<select name="optiondi" class="size2">
<option value="" SELECTED>- select -</option> 
<?php  
while ($row = mysqli_fetch_array($result)) {
echo "<option value=\"$row[DI]\">$row[DI]</option>\n"; 
} 
?>  
</select></td>
    <td><strong>Patron Saint:</strong> <br />
<input type="text" name="pt" class="size2"></td>
  </tr>
  <tr>
    <td><strong>Province:</strong><br />
<?php $result = mysqli_query($db, "SELECT DISTINCT PV FROM KloosterlijstEng ORDER BY PV");
?>
<select name="optionpv" class="size2"> 
<option value="" SELECTED>- select -</option>
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
<?php $result = mysqli_query($db, "SELECT DISTINCT GE FROM KloosterlijstEng ORDER BY GE");
?>
<select name="optionge" class="size2"> 
<option value="" SELECTED>- select -</option>
<?php  
while ($row = mysqli_fetch_array($result)) {
echo "<option value=\"$row[GE]\">$row[GE]</option>\n"; 
} 
?>  
</select></td>
    <td><strong>Parish:</strong> <br />
<input type="text" name="pa" class="size2"></td>
  </tr>
  <tr>
    <td align="center"></td>
    <td><strong>Development: [<a href="thesaurusST.pdf" title="thesaurus stadia" target="_blank">thesaurus</a>]</strong> <br />
<input type="text" name="st" class="size2"></td>
  </tr>
    <tr>
    <td align="center"></td>
    <td><strong>First mention [from]:</strong> <br />
<input type="number" name="ev" class="size2"></td>
  </tr>
      <tr>
    <td align="center"><input type="submit" name="knop" value="search"class="button" /> <input type="reset" value="clear"class="button" /></td>
    <td><strong>Last mention [to]:</strong> <br />
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
<img src="../images/vu.gif" width="195" height="24">
</p>
</div>
</body>
</html>
