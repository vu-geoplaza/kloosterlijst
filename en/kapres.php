<html>
<head>
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">

    <title>Monasteries in the Netherlands until 1800</title>
</head>
<body>
<div id="links">
    <?php
    include("menu.inc.php");
    ?>
</div>

<div id="content">
    <?php include("header.inc"); ?>
    <h3>results for collegiate churches</h3>
    <hr>
    <p>
        <?php
        include('../resources/safe_params.inc');
        $script_name = safe_str_html($_SERVER['PHP_SELF']);
        $optionkappl = '';

        # $db = include 'db_kloosterlijst.inc';
        $db = include('db_connect.inc');
        if ($db) {
        if (isset($_POST["optionkappl"])) {
            $optionkappl = (string)$_POST["optionkappl"];
            # validity check ?
            # if(!is_valid_name($optionkappl)) {
            # die('<p>invalid parameter value:<br/>' . safe_str_html($optionkappl) . '</p>');
            # }
        }
        $query_params = new Template_params();
        if ($optionkappl != '') {
            $optionkappl_conditie = " AND Place = '%(optionkappl)s'";
            $query_params->optionkappl = $optionkappl;
        } else {
            $optionkappl_conditie = '';
        }

        $query_template = new Sql_template();
        $query_template->template = <<<END_OF_QUERY
	SELECT  Idnr, Place, Diocese, Patron, Location, lat, lon, Foundation, Dissolution, Prebends, Founder, MeMo, Literature
	FROM  	KapittelsEng
	WHERE   Idnr = Idnr
	$optionkappl_conditie

	ORDER by Place
END_OF_QUERY;

        $query = $query_template->interpolate($query_params);

        if (!($result = mysqli_query($db, $query))) {
            echo 'invalid query.';
        } else {
        $k_form_recordCount = mysqli_num_rows($result);

        $html_template = new Html_template();

        if ($k_form_recordCount == 0) {
            echo 'No results.';
        } else {
        $DisplayCount = 1000;
        if (!isset($FromRec)) {
            $FromRec = 1;
        }
        $ToRec = $FromRec + ($DisplayCount - 1);
        if ($ToRec > $k_form_recordCount) {
            $ToRec = $k_form_recordCount;
        }

        $html_template->template = <<<END_OF_HTML
	
		<tr><td colspan=5><strong>Your query <em>%(optionkappl)s</em></strong>
END_OF_HTML;

        echo $html_template->interpolate(array('optionkappl' => $optionkappl));
        ?>


    <table border="0" cellpadding="4" cellspacing="2">
        <th>Idnr</th>
        <th>Place</th>
        <th>Diocese</th>
        <th>Patron Saint</th>
        <th>Location</th>
        <th>Latitude_dec</th>
        <th>Longitude_dec</th>
        <th>Foundation</th>
        <th>Dissolution</th>
        <th>Number of prebends</th>
        <th>Founder</th>
        <th>MeMo</th>
        <th>Literature</th>
        <?php
        $r = 0;
        while (($row = mysqli_fetch_object($result)) && $r++ <= $DisplayCount) {
            if ($r % 2 == 0) {
                $bgcolor = '#CCCCCC';
            } else {
                $bgcolor = '#E8E8E8';
            }
            echo <<<END_OF_ENTRY
			<tr bgcolor="$bgcolor">
			<td valign="top">$row->Idnr</td><td valign="top">$row->Place</td><td valign="top">$row->Diocese</td><td valign="top">$row->Patron</td><td valign="top">$row->Location</td><td valign="top">$row->lat</td><td valign="top">$row->lon</td><td valign="top">$row->Foundation</td><td valign="top">$row->Dissolution</td><td valign="top">$row->Prebends</td><td valign="top">$row->Founder</td><td valign="top">$row->MeMo</td><td valign="top">$row->Literature</td>
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
        <img src="../images/vu.gif" width="195" height="24">
    </p>
</div>
</body>
</html>
