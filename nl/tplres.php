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
    <h3>resultatenoverzicht termijnhuizen</h3>
    <hr>
    <p>
        <?php
        include('../resources/safe_params.inc');
        $script_name = safe_str_html($_SERVER['PHP_SELF']);
        $optiontpl = '';

        # $db = include 'db_kloosterlijst.inc';
        $db = include('db_connect.inc');
        if ($db) {
        if (isset($_POST["optiontpl"])) {
            $optiontpl = (string)$_POST["optiontpl"];
            # validity check ?
            # if(!is_valid_name($optiontpl)) {
            # die('<p>invalid parameter value:<br/>' . safe_str_html($optiontpl) . '</p>');
            # }
        }
        $query_params = new Template_params();
        if ($optiontpl != '') {
            $optiontpl_conditie = " AND Plaats = '%(optiontpl)s'";
            $query_params->optiontpl = $optiontpl;
        } else {
            $optiontpl_conditie = '';
        }

        $query_template = new Sql_template();
        $query_template->template = <<<END_OF_QUERY
	select  Klooster, idnr_klooster, Plaats, Provincie, Opmerkingen, Literatuur, ENK_code
	FROM  	Termijnhuizen 
	WHERE   idnr_klooster = idnr_klooster
	$optiontpl_conditie

	ORDER by Klooster
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

		<tr><td colspan=5>Uw zoekactie <em>%(optiontpl)s</em> heeft de volgende resultaten opgeleverd
END_OF_HTML;

        echo $html_template->interpolate(array('optiontpl' => $optiontpl));
        ?>


    <table border="0" cellpadding="4" cellspacing="2">
        <th>Klooster</th>
        <th>Plaats termijnhuis</th>
        <th>Provincie</th>
        <th>Opmerkingen</th>
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
			<td valign="top">$row->Klooster</td><td valign="top">$row->Plaats</td><td valign="top">$row->Provincie</td><td valign="top">$row->Opmerkingen</td><td valign="top">$row->Literatuur</td><td valign="top">$row->ENK_code</td>
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
