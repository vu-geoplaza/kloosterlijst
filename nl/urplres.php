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
    <h3>resultatenoverzicht uithoven</h3>
    <hr>
    <p>
        <?php
        include('../resources/safe_params.inc');
        $script_name = safe_str_html($_SERVER['PHP_SELF']);
        $optionurpl = '';
        $optionurn = '';
        # $db = include 'db_kloosterlijst.inc';
        $db = include('db_connect.inc');
        if ($db) {
        if (isset($_POST["optionurpl"])) {
            $optionurpl = (string)$_POST["optionurpl"];
            # validity check ?
            # if(!is_valid_plaats($optionurpl)) {
            # die('<p>invalid parameter value:<br/>' . safe_str_html($optionurpl) . '</p>');
            # }
        }
        if (isset($_POST["optionurn"])) {
            $optionurn = (string)$_POST["optionurn"];
            # validity check ?
            # if(!is_valid_name($optionurn)) {
            # die('<p>invalid parameter value:<br/>' . safe_str_html($optionurn) . '</p>');
            # }
        }
        $query_params = new Template_params();
        if ($optionurpl != '') {
            $optionurpl_conditie = " AND  Plaats = '%(optionurpl)s'";
            $query_params->optionurpl = $optionurpl;
        } else {
            $optionurpl_conditie = '';
        }
        if ($optionurn != '') {
            $optionurn_conditie = " AND  Naam = '%(optionurn)s'";
            $query_params->optionurn = $optionurn;
        } else {
            $optionurn_conditie = '';
        }
        $query_template = new Sql_template();
        $query_template->template = <<<END_OF_QUERY
	select  idnr_klooster, Klooster, Categorie, Plaats, Naam, id_ur
	FROM  	Uithoven 
	WHERE   idnr_klooster = idnr_klooster
	$optionurpl_conditie
	$optionurn_conditie
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

		Uw zoekactie
		[plaats: <em>%(optionurpl)s</em> ]
		[naam: <em>%(optionurn)s</em> ]
		heeft de volgende resultaten opgeleverd:
END_OF_HTML;
        echo $html_template->interpolate($query_params);
        ?>


    <table border="0" cellpadding="4" cellspacing="2">
        <tr>
            <th>Idnr Klooster</th>
            <th>Klooster</th>
            <th>Categorie</th>
            <th>Plaats</th>
            <th>Naam uithof of refugium</th>
            <th>Meer info</th>
        </tr>
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
			<td valign="top">$row->idnr_klooster</td><td valign="top">$row->Klooster</td><td valign="top">$row->Categorie</td><td valign="top">$row->Plaats</td>
			<td valign="top">$row->Naam</td><td valign="top"><a href="urshow.php?id_ur=$row->id_ur" target="_self">&</a></td>
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
