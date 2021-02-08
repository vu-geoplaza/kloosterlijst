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
<h1 class="indent">Monasteries in the Netherlands until 1800</h1>
<h3 class="indent">results granges and urban refuges</h3>
<hr>
<p>
<?php
    include('safe_params.inc');
    $script_name = safe_str_html($_SERVER['PHP_SELF']);
    $optionurpl = '';
    $optionurn = '';
    # $db = include 'db_kloosterlijst.inc';
    $db = include('db_connect.inc');
    if ($db) {
	if(isset($_POST["optionurpl"])) {
	    $optionurpl = (string) $_POST["optionurpl"];
	    # validity check ?
	    # if(!is_valid_plaats($optionurpl)) {
		# die('<p>invalid parameter value:<br/>' . safe_str_html($optionurpl) . '</p>');
	    # }
	}
	if(isset($_POST["optionurn"])) {
	    $optionurn = (string) $_POST["optionurn"];
	    # validity check ?
	    # if(!is_valid_name($optionurn)) {
		# die('<p>invalid parameter value:<br/>' . safe_str_html($optionurn) . '</p>');
	    # }
	}
	$query_params = new Template_params();
	if ($optionurpl != '') {
	    $optionurpl_conditie = " AND  Place = '%(optionurpl)s'";
	    $query_params->optionurpl = $optionurpl;
	} else {
	    $optionurpl_conditie = '';
	}
	if ($optionurn != '') {
	    $optionurn_conditie = " AND  Name = '%(optionurn)s'";
	    $query_params->optionurn = $optionurn;
	} else {
	    $optionurn_conditie = '';
	}
	$query_template = new Sql_template();
	$query_template->template = <<<END_OF_QUERY
	select  idnr_Monastery, Monastery, Category, Place, Name, id_ur
	FROM  	UithovenEng 
	WHERE   idnr_Monastery = idnr_Monastery
	$optionurpl_conditie
	$optionurn_conditie
	ORDER by Monastery
END_OF_QUERY;

	$query = $query_template->interpolate($query_params);

	if (! ($result = mysql_query($query, $db))) {
	    echo 'invalid query.';
	} else {
	    $k_form_recordCount = mysql_num_rows($result);

	    $html_template = new Html_template();

	    if ($k_form_recordCount == 0) {
		echo 'Geen resultaten gevonden.';
	    } else {
		$DisplayCount = 1000;		
		if(! isset($FromRec)) {
		    $FromRec = 1;
		}
		$ToRec = $FromRec+($DisplayCount-1);
		if ($ToRec > $k_form_recordCount) {
		    $ToRec = $k_form_recordCount;
		}
      
		$html_template->template = <<<END_OF_HTML

		Your query
		[place: <em>%(optionurpl)s</em> ]
		[name: <em>%(optionurn)s</em> ]:
END_OF_HTML;
		echo $html_template->interpolate($query_params);
	    ?>
        

		<table border="0" cellpadding="4" cellspacing="2">
		<tr>
		<th>Idnr</th><th>Monastery</th><th>Category</th><th>Place</th><th>Name grange or urban refuge</th>
		<th>More info</th></tr>
		<?php
		    $r = 0;
		    while (($row = mysql_fetch_object($result)) && $r++ <= $DisplayCount) {
			if ($r % 2 == 0) {
			    $bgcolor = '#CCCCCC';
			} else {
			    $bgcolor = '#E8E8E8';
			}
			echo <<<END_OF_ENTRY
			<tr bgcolor="$bgcolor">
			<td valign="top">$row->idnr_Monastery</td><td valign="top">$row->Monastery</td><td valign="top">$row->Category</td><td valign="top">$row->Place</td>
			<td valign="top">$row->Name</td><td valign="top"><a href="urshow.php?id_ur=$row->id_ur" target="_self">&</a></td>
			</tr>
END_OF_ENTRY;
		    }
		?>
		</table>
	    <?php
	    }
	    ?>
	<?php
	}
    }
?>
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
