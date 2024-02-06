<html>
<head>
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
    <title>details concordantie</title>
</head>
<body>
<div id="links">
    <?php
    include("menu.inc.php");
    ?>
</div>

<div id="content">
<?php include("header.inc"); ?>
    <h3>details</h3>
    <hr>
    <p>
        <?php
        include('../resources/safe_params.inc');
        # include("input_cl.php"); # conflicteert met safe_params.inc
        $script_name = safe_str_html($_SERVER['PHP_SELF']);
        $ID = '';

        # $db = include 'db_kloosterlijst.inc';
        $db = include('db_connect.inc');
        if ($db) {
        if (isset($_GET["ID"])) {
            $ID = (string)$_GET["ID"];
            if (!ctype_alnum($ID)) {
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
	select Concordantie.ID, Kloosterlijst.TI, Kloosterlijst.PA, Kloosterlijst.CO, Kloosterlijst.PT, Kloosterlijst.AL, Kloosterlijst.DI, Kloosterlijst.PV, GE, ST, FI, CK, NS, SV, AR, LI, TE, MB, ENK_code 
		FROM Kloosterlijst RIGHT JOIN Concordantie ON Kloosterlijst.ID = Concordantie.ID  		
		$ID_conditie
		GROUP BY Concordantie.ID, Kloosterlijst.TI, Kloosterlijst.PA, Kloosterlijst.CO, Kloosterlijst.PT, Kloosterlijst.AL, Kloosterlijst.DI, Kloosterlijst.PV, GE, ST, FI, CK, NS, SV, AR, LI, TE, MB, ENK_code
END_OF_QUERY;

        $query = $query_template->interpolate($query_params);

        if (!($result = mysqli_query($db, $query))) {
            echo 'invalid query.';
        } else {
        $c_form_recordCount = mysqli_num_rows($result);

        $html_template = new Html_template();

        if ($c_form_recordCount = 0) {
            echo 'Geen resultaten gevonden.';
        }
        if ($ID != '') {
            # hier kan een eventuele heading ingevoegd worden ...
            $html_template->template = <<<END_OF_HTML
END_OF_HTML;
            # echo $html_template->interpolate(array('ID' => $ID));
        }
        ?>
    <p>
    <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" width="60%">
        <?php
        while (($row = mysqli_fetch_object($result))) {
            if ($row->ID == "elim") {
                echo("<tr><td>Dit klooster is ge&euml;limineerd. Zie voor meer informatie de eliminatielijst.</td></tr>");
            }
            if ($row->ID != "elim") {
                echo("<tr><td><h2>$row->TI</td></tr>");
            }
            if ($row->ID != "elim") {
                echo("<tr><td>ID: $row->ID</td></tr>");
            }
            if ($row->PA != "") {
                echo("<tr><td>Parochie: $row->PA</td></tr>");
            }
            if ($row->CO != "") {
                echo("<tr><td>Co&ouml;rdinaten: $row->PA</td></tr>");
            }
            if ($row->PT != "") {
                echo("<tr><td>Patroonheilige(n): $row->PT</td></tr>");
            }
            if ($row->AL != "") {
                echo("<tr><td>Alias: $row->AL</td></tr>");
            }
            if ($row->DI != "") {
                echo("<tr><td>Diocees: $row->DI</td></tr>");
            }
            if ($row->PV != "") {
                echo("<tr><td>Provincie: $row->PV</td></tr>");
            }
            if ($row->GE != "") {
                echo("<tr><td>Gender: $row->GE</td></tr>");
            }
            if ($row->ST != "") {
                echo("<tr><td>Stadia: $row->ST</td></tr>");
            }
            if ($row->FI != "") {
                echo("<tr><td>Be&euml;indiging kloosterleven: $row->FI</td></tr>");
            }
            if ($row->CK != "") {
                echo("<tr><td>Verhalende bronnen (Carasso-Kok): $row->CK</td></tr>");
            }
            if ($row->NS != "") {
                echo("<tr><td>Verhalende bronnen (Narrative Sources): $row->NS</td></tr>");
            }
            if ($row->SV != "") {
                echo("<tr><td>Handschriften (Stooker en Verbeij): $row->SV</td></tr>");
            }
            if ($row->AR != "") {
                echo("<tr><td>Archivalia: $row->AR</td></tr>");
            }
            if ($row->LI != "") {
                echo("<tr><td>Literatuur: $row->LI</td></tr>");
            }
            if ($row->TE != "") {
                echo("<tr><td>Concordantie met lijst derde-orde-conventen: $row->TE</td></tr>");
            }
            if ($row->MB != "") {
                echo("<tr><td>Lemmata in Monasticon Batavum: $row->MB</td></tr>");
            }
            if ($row->ENK_code != "") {
                echo("<tr><td>ENK: $row->ENK_code</td></tr>");
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
    <p class="indent"><a href="javascript:history.back()"><strong>[terug naar resultatenset]</strong></a></p>
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
