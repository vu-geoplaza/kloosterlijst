<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1"> 
    <LINK rel="stylesheet" href="mp.css" type="text/css">
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
<h1 class="indent">Monasteries</h1>
<h3 class="indent">details</h3>
<hr>
<p>
<?php
    include('safe_params.inc');
	# include("input_cl.php"); # conflicteert met safe_params.inc
    $script_name = safe_str_html($_SERVER['PHP_SELF']);
    $ID = '';

    # $db = include 'db_Kloosterlijst.inc';
    $db = include('db_connect.inc');
    if ($db) {
	if(isset($_GET["ID"])) {
	    $ID = (string) $_GET["ID"];
	    if(!ctype_alnum($ID)) {
		die('<p>invalid parameter value:<br/>' . safe_str_html($ID) . '</p>');
	    }
	}
	$query_params = new Template_params();
	if ($ID != '') {
	    $ID_conditie = " WHERE Concordantie.ID = '%(ID)s'";
	    $query_params->ID = $ID;
	} else {
	    $ID_conditie = '';
	}
	$query_template = new Sql_template();
	$query_template->template = <<<END_OF_QUERY
	select Concordantie.ID, KloosterlijstEng.TI, KloosterlijstEng.PA, KloosterlijstEng.CO, KloosterlijstEng.PT, KloosterlijstEng.AL, KloosterlijstEng.DI, KloosterlijstEng.PV, GE, ST, FI, CK, NS, SV, AR, LI, TE, MB, ENK 
		FROM KloosterlijstEng RIGHT JOIN Concordantie ON KloosterlijstEng.ID = Concordantie.ID  		
		$ID_conditie
		GROUP BY Concordantie.Id
END_OF_QUERY;

	$query = $query_template->interpolate($query_params);

	if (! ($result = mysql_query($query, $db))) {
	    echo 'invalid query.';
	} else {
	    $c_form_recordCount = mysql_num_rows($result);

	    $html_template = new Html_template();

	    if ($c_form_recordCount = 0) {
		echo 'No results.';
	    }
	    if($ID != '') {
		# hier kan een eventuele heading ingevoegd worden ...
		$html_template->template = <<<END_OF_HTML
END_OF_HTML;
		# echo $html_template->interpolate(array('ID' => $ID));
	    }
	    ?>
	    <p>
	    <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent" width="60%">
		<?php
		    while (($row = mysql_fetch_object($result))) {
if ($row->ID =="elim") {
		echo("<tr><td>This monastery has been eliminated. Please see the List of Eliminations.</td></tr>");
	}
if ($row->ID !="elim") {
		echo("<tr><td><h2>$row->TI</td></tr>");
	}
if ($row->ID !="elim") {
		echo("<tr><td>ID: $row->ID</td></tr>");
	}
if ($row->PA !="") {
		echo("<tr><td>Parish: $row->PA</td></tr>");
	}
if ($row->CO !="") {
		echo("<tr><td>Coordinates: $row->PA</td></tr>");
	}
if ($row->PT !="") {
		echo("<tr><td>Patron Saint(s): $row->PT</td></tr>");
	}
if ($row->AL !="") {
		echo("<tr><td>Alias: $row->AL</td></tr>");
	}	
if ($row->DI !="") {
		echo("<tr><td>Diocese: $row->DI</td></tr>");
	}	
if ($row->PV !="") {
		echo("<tr><td>Province: $row->PV</td></tr>");
	}
if ($row->GE !="") {
		echo("<tr><td>Gender: $row->GE</td></tr>");
	}
if ($row->ST !="") {
		echo("<tr><td>Development: $row->ST</td></tr>");
	}
if ($row->FI !="") {
		echo("<tr><td>End of monastic life: $row->FI</td></tr>");
	}
if ($row->CK !="") {
		echo("<tr><td>Narrative Sources (Carasso-Kok): $row->CK</td></tr>");
	}
if ($row->NS !="") {
		echo("<tr><td>Narrative Sources (Narrative Sources): $row->NS</td></tr>");
	}
if ($row->SV !="") {
		echo("<tr><td>Manuscripts (Stooker en Verbeij): $row->SV</td></tr>");
	}
if ($row->AR !="") {
		echo("<tr><td>Archives: $row->AR</td></tr>");
	}
if ($row->LI !="") {
		echo("<tr><td>Literature: $row->LI</td></tr>");
	}
if ($row->TE !="") {
		echo("<tr><td>Third Order: $row->TE</td></tr>");
	}
if ($row->MB !="") {
		echo("<tr><td>Entry in <em>Monasticon Batavum</em>: $row->MB</td></tr>");
	}

if ($row->ENK !="") {
		echo("<tr><td>ENK code: $row->ENK</td></tr>");
	}
			}
		?></table> 
	    <?php
	    }
	    ?>
	<?php
	}
?>
</p>
<p class="indent"><a href="javascript:history.back()"><strong>[back]</strong></a></p>
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
