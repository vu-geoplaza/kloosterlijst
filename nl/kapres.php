<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
    <title>kloosterlijst resultaten</title>
</head>
<body>
<div id="links">
    <?php
    include("menu.inc");
    ?>
</div>

<div id="content">
<?php include("header.inc"); ?>
    <h3 class="indent">resultatenoverzicht kapittels</h3>
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
            $optionkappl_conditie = " AND Plaats = '%(optionkappl)s'";
            $query_params->optionkappl = $optionkappl;
        } else {
            $optionkappl_conditie = '';
        }

        $query_template = new Sql_template();
        $query_template->template = <<<END_OF_QUERY
	SELECT  Idnr, Plaats, Bisdom, Patroonheilige, Locatie, lat, lon, Stichting, Opheffing, Prebenden, Stichter, MeMo, Literatuur, ENK
	FROM  	Kapittels
	WHERE   Idnr = Idnr
	$optionkappl_conditie

	ORDER by Plaats
END_OF_QUERY;

        $query = $query_template->interpolate($query_params);

        if (!($result = mysqli_query($db, $query))) {
            echo 'invalid query.';
        } else {
        $k_form_recordCount = mysqli_num_rows($result);

        $html_template = new Html_template();

        if ($k_form_recordCount == 0) {
            echo 'Geen resultaten gevonden.';
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
	
		<tr><td colspan=5><strong>Uw zoekactie <em>%(optionkappl)s</em> heeft de volgende resultaten opgeleverd</strong>
END_OF_HTML;

        echo $html_template->interpolate(array('optionkappl' => $optionkappl));
        ?>


    <table border="0" cellpadding="4" cellspacing="2">
        <th>Idnr</th>
        <th>Plaats</th>
        <th>Bisdom</th>
        <th>Patroonheilige</th>
        <th>Locatie</th>
        <th>Breedte dec</th>
        <th>Lengte dec</th>
        <th>Sticht</th>
        <th>Opheffing</th>
        <th>Aantal prebenden</th>
        <th>Stichter</th>
        <th>MeMo</th>
        <th>Literatuur</th>
        <th>ENK</th>
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
			<td valign="top">$row->Idnr</td><td valign="top">$row->Plaats</td><td valign="top">$row->Bisdom</td><td valign="top">$row->Patroonheilige</td><td valign="top">$row->Locatie</td><td valign="top">$row->lat</td><td valign="top">$row->lon</td>
			<td valign="top">$row->Sticht</td><td valign="top">$row->Opheffing</td><td valign="top">$row->Prebenden</td><td valign="top">$row->Stichter</td><td valign="top">$row->MeMo</td><td valign="top">$row->Literatuur</td><td valign="top">$row->ENK</td>
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
