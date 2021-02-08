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
<h3 class="indent">Survey of correspondences</h3>
<hr>
<p>
<?php
    include('safe_params.inc');
	# include("input_cl.php"); # conflicteert met safe_params.inc
    $script_name = safe_str_html($_SERVER['PHP_SELF']);
    $cplaats = '';
 
    # $db = include 'db_kloosterlijst.inc';
    $db = include('db_connect.inc');
    if ($db) {
	if(isset($_POST['cplaats'])) {
	    $cplaats = $_POST["cplaats"];
	}
	$query_params = new Template_params();
	if ($cplaats != '') {
	    $cplaats_conditie = " WHERE Plaats = '%(cplaats)s'";
	    $query_params->cplaats = $cplaats;
	} else {
	    $cplaats_conditie = '';
	}

	$query_template = new Sql_template();
	$query_template->template = <<<END_OF_QUERY
	SELECT ID, Plaats, Deel, Blz, Nr
	FROM  	Concordantie
	$cplaats_conditie
END_OF_QUERY;

	$query = $query_template->interpolate($query_params);

	if (! ($result = mysql_query($query, $db))) {
	    echo 'invalid query.';
	} else {
	    $c_form_recordCount = mysql_num_rows($result);

	    $html_template = new Html_template();

	    if ($c_form_recordCount == 0) {
		$html_template->template = <<<END_OF_HTML
		De plaats %(cplaats)s komt niet voor in de concordantie.
END_OF_HTML;
		echo $html_template->interpolate($query_params);
	    } else {
		$DisplayCount = 1000;		
		if(! isset($FromRec)) {
		    $FromRec = 1;
		}
		$ToRec = $FromRec+($DisplayCount-1);
		if ($ToRec > $c_form_recordCount) {
		    $ToRec = $c_form_recordCount;
		}
		$html_template->template = <<<END_OF_HTML
		
      
		Your query <strong>%(cplaats)s</strong><br />(Place, volume, Page, Nr refer to the <em>Monasticon Batavum</em>):
END_OF_HTML;
		echo $html_template->interpolate($query_params);
	    ?>
        

		<table border="0" cellpadding="4" cellspacing="2"><th align="left">Place</th><th align="left">Volume</th><th align="left">Page</th><th align="left">Nr</th>
		<?php
		    $r = 0;
		    while (($row = mysql_fetch_object($result)) && $r++ <= $DisplayCount) {
			if ($r % 2 == 0) {
			    $bgcolor = '#CCCCCC';
			} else {
			    $bgcolor = '#E8E8E8';
			} # safe_str_url?;
			echo <<<END_OF_ENTRY
			<tr bgcolor="$bgcolor">
			<td valign="top"><a href="cshow.php?ID=$row->ID" target="_self">$row->Plaats</a></td><td valign="top">$row->Deel</td><td valign="top">$row->Blz</td><td valign="top">$row->Nr</td>
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
