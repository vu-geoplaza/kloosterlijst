<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1"> 
    <!-- <LINK rel="stylesheet" href="mp.css" type="text/css"> -->
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
<tr><td align="left"><a href="http://www.fgw.vu.nl"><img src="../images/logo_fgw.gif" border="0"></a></td><td align="right"><a href="http://www.vu.nl"><img src="../images/grif.gif" width="312" height="104" border="0"></a></td>
</tr></table>
<h1 class="indent">Monasteries in the Netherlands until 1800</h1>
<h3 class="indent">details</h3>
<hr>
<p>
<?php
    include('../resources/safe_params.inc');
    $script_name = safe_str_html($_SERVER['PHP_SELF']);
    $id_ur = '';

    # $db = include 'db_Kloosterlijst.inc';
    $db = include('db_connect.inc');
    if ($db) {
	if(isset($_GET["id_ur"])) {
	    $id_ur = (string) $_GET["id_ur"];
	    if(!ctype_alnum($id_ur)) {
		die('<p>invalid parameter value:<br/>' . safe_str_html($id_ur) . '</p>');
	    }
	}
	$query_params = new Template_params();
	if ($id_ur != '') {
	    $id_ur_conditie = " WHERE id_ur = '%(id_ur)s'";
	    $query_params->id_ur = $id_ur;
	} else {
	    $id_ur_conditie = '';
	}
	$query_template = new Sql_template();
	$query_template->template = <<<END_OF_QUERY
	select  idnr_Monastery, Monastery, Category, Place, Name, Province, Land_registry, Remarks, Literature, id_ur, Latitude_dec, Longitude_dec, ENK_code, Arch_Monument, Arch_status, Arch_activit, Arch_Publ
	FROM  	UithovenEng
	$id_ur_conditie	
END_OF_QUERY;

	$query = $query_template->interpolate($query_params);

	if (! ($result = mysqli_query($db, $query))) {
	    echo 'invalid query.';
	} else {
	    $k_form_recordCount = mysqli_num_rows($result);

	    $html_template = new Html_template();

	    if ($k_form_recordCount = 0) {
		echo 'Geen resultaten gevonden.';
	    } 
	    if ($id_ur != '') {
		# hier kan eventueel een heading worden ingevoegd
		$html_template->template = <<<END_OF_HTML
END_OF_HTML;
		# echo $html_template->interpolate(array('id_ur' => $id_ur));
	    }
	    ?>
		<p>
		<table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent" width="60%">
		<?php
		    while (($row = mysqli_fetch_object($result))) {
			echo <<<END_OF_ENTRY
			<tr><td valign="top"><strong>Name:</strong></td> <td valign="top">$row->Name</td></tr>
			<tr><td valign="top"><strong>Id Monastery:</strong></td> <td valign="top">$row->idnr_Monastery</td></tr>
			<tr><td valign="top"><strong>Monastery:</strong></td> <td valign="top">$row->Monastery</td></tr>
			<tr><td valign="top"><strong>Category:</strong></td> <td valign="top">$row->Category</td></tr>
			<tr><td valign="top"><strong>Place:</strong></td> <td valign="top">$row->Place</td></tr>
			<tr><td valign="top"><strong>Province:</strong></td> <td valign="top">$row->Province</td></tr>
			<tr><td valign="top"><strong>Land register:</strong></td> <td valign="top">$row->Land_registry</td></tr>
			<tr><td valign="top"><strong>Remarks:</strong></td> <td valign="top">$row->Remarks</td></tr>
			<tr><td valign="top"><strong>Literature:</strong></td> <td valign="top">$row->Literature</td></tr>
			<tr><td valign="top"><strong>Latitude:</strong></td> <td valign="top">$row->Latitude_dec</td></tr>
			<tr><td valign="top"><strong>Longitude:</strong></td> <td valign="top">$row->Longitude_dec</td></tr>
			<tr><td valign="top"><strong>ENK code:</strong></td> <td valign="top">$row->ENK_code</td></tr>
			<tr><td valign="top"><strong>AMK:</strong></td> <td valign="top">$row->Arch_Monument</td></tr>
			<tr><td valign="top"><strong>Archeological status:</strong></td> <td valign="top">$row->Arch_status</td></tr>
			<tr><td valign="top"><strong>Archeological activities:</strong></td> <td valign="top">$row->Arch_activit</td></tr>
			<tr><td valign="top"><strong>Archeological publications:</strong></td> <td valign="top">$row->Arch_Publ</td></tr>
END_OF_ENTRY;
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
<img src="../images/vu.gif" width="195" height="24">
</p>
</div>
</body>
</html>
