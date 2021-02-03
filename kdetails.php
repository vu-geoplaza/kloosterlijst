<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
    <!-- <LINK rel="stylesheet" href="mp.css" type="text/css"> -->
    <title>details klooster</title>
</head>
<body>
<div id="links">
    <?php
    include("menu.inc");
    ?>
</div>

<div id="content">
    <table width="100%">
        <tr>
            <td align="left"><a href="http://www.fgw.vu.nl"><img class="fgwlogo" src="images/fgw_logo.svg" border="0"></a></td>
            <td align="right"><a href="http://www.vu.nl"><img src="images/grif.gif" width="312" height="104" border="0"></a>
            </td>
        </tr>
    </table>
    <h1 class="indent">Kloosterlijst</h1>
    <h3 class="indent">details</h3>
    <hr>
    <p>
        <?php
        include('safe_params.inc');
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
            $ID_conditie = " AND ID = '%(ID)s'";
            $query_params->ID = $ID;
        } else {
            $ID_conditie = '';
        }
        $query_template = new Sql_template();
        $query_template->template = <<<END_OF_QUERY
	select  ID, TI, PA, CO, PT, AL, DI, PV, HG, GE, ST, FT, FI, CK, NS, SV, AR, LI, TE, MB, foto, MM, EV, LV, FO, VD, RM, AM, AA, AP, AST, DI2, PV2, ENK_code
	FROM  	Kloosterlijst
	WHERE   Kloosterlijst.ID = Kloosterlijst.ID				
		$ID_conditie
END_OF_QUERY;

        $query = $query_template->interpolate($query_params);

        if (!($result = mysqli_query($db, $query))) {
            echo 'invalid query.';
        } else {
        $k_form_recordCount = mysqli_num_rows($result);

        $html_template = new Html_template();
        $html_template->template = <<<END_OF_HTML
END_OF_HTML;

        echo $html_template->interpolate(array('ID' => $ID));
        if ($k_form_recordCount = 0) {
            echo 'Geen resultaten gevonden.';
        }
        ?>
    <p>
    <table bgcolor="#FFFFFF" cellpadding="3" cellspacing="2" border="2" bordercolor="#B94A85" class="indent"
           width="70%">
        <?php
        $r = 0;
        while (($row = mysqli_fetch_object($result)) && $r++ <= $DisplayCount) {
            echo <<<END_OF_ENTRY
			<tr><td valign="top"colspan="2" align="middle"><strong>$row->TI</strong></td></tr>
			<tr><td valign="top" align="middle" width="40%"><IMG SRC="foto/$row->foto" title="$row->FO"></td> <td valign="top"><iframe src="https://geoplaza.vu.nl/projects/kloosters/locatie.html?id=$row->ID" style="width:100%;height:350px;border:none;"></iframe></td></tr><br>
			<tr><td valign="top" width="40%"><em>$row->FO</em></td> <td valign="top"><a href="http://geoplaza.vu.nl/projects/kloosters/" target="_blank">Volledige Kloosterkaart</a> op Geoplaza.</td></tr>
			<tr><td valign="top" width="40%"><strong>IDNR:</strong></td> <td valign="top">$row->ID</td></tr>
			<tr><td valign="top" width="40%"><strong>Parochie:</strong></td> <td valign="top">$row->PA</td></tr>
			<tr><td valign="top" width="40%"><strong>Huidige gemeente:</strong></td> <td valign="top">$row->HG</td></tr>
			<tr><td valign="top" width="40%"><strong>Patroonheilige:</strong></td> <td valign="top">$row->PT</td></tr>
			<tr><td valign="top" width="40%"><strong>Alias:</strong></td> <td valign="top">$row->AL</td></tr>
			<tr><td valign="top" width="40%"><strong>Diocees:</strong></td> <td valign="top">$row->DI</td></tr>
			<tr><td valign="top" width="40%"><strong>Diocees II:</strong></td> <td valign="top">$row->DI2</td></tr>
			<tr><td valign="top" width="40%"><strong>Provincie:</strong></td> <td valign="top">$row->PV</td></tr>
			<tr><td valign="top" width="40%"><strong>Provincie II:</strong></td> <td valign="top">$row->PV2</td></tr>
			<tr><td valign="top" width="40%"><strong>Gender:</strong></td> <td valign="top">$row->GE</td></tr>
			<tr><td valign="top" width="40%"><strong>Stadia:</strong></td> <td valign="top">$row->ST</td></tr>
			<tr><td valign="top" width="40%"><strong>Filiatie:</strong></td> <td valign="top">$row->FT</td></tr>
			<tr><td valign="top" width="40%"><strong>Einde kloosterleven:</strong></td> <td valign="top">$row->FI</td></tr>
			<tr><td valign="top" width="40%"><strong>Verhalende bronnen (CK):</strong></td> <td valign="top">$row->CK</td></tr>
			<tr><td valign="top" width="40%"><strong>Verhalende bronnen (NS):</strong></td> <td valign="top">$row->NS</td></tr>
			<tr><td valign="top" width="40%"><strong>Handschriften (SV):</strong> <td valign="top">$row->SV</td></tr>
			<tr><td valign="top" width="40%"><strong>Archivalia:</strong></td> <td valign="top">$row->AR</td></tr>
			<tr><td valign="top" width="40%"><strong>Literatuur:</strong></td> <td valign="top">$row->LI</td></tr>
			<tr><td valign="top" width="40%"><strong>Derde Orde:</strong></td> <td valign="top">$row->TE</td></tr>
			<tr><td valign="top" width="40%"><strong>Monasticon Batavum:</strong></td> <td valign="top">$row->MB</td></tr>
			<tr><td valign="top" width="40%"><strong>MeMO:</strong</td> <td valign="top">$row->MM</td></tr>
			<tr><td valign="top" width="40%"><strong>Van Deventer:</strong</td> <td valign="top">$row->VD</td></tr>
			<tr><td valign="top" width="40%"><strong>Rijksmonument:</strong</td> <td valign="top">$row->RM</td></tr>
			<tr><td valign="top" width="40%"><strong>Co&ouml;rdinaten:</strong></td> <td valign="top">$row->CO</td></tr>
			<tr><td valign="top" width="40%"><strong>Archeologisch monument:</strong</td> <td valign="top">$row->AM</td></tr>
			<tr><td valign="top" width="40%"><strong>Archeologische status:</strong</td> <td valign="top">$row->AST</td></tr>
			<tr><td valign="top" width="40%"><strong>Archeologische activiteit:</strong</td> <td valign="top">$row->AA</td></tr>
			<tr><td valign="top" width="40%"><strong>Archeologische publicatie:</strong</td> <td valign="top">$row->AP</td></tr>
			<tr><td valign="top" width="40%"><strong>Eerste vermelding:</strong></td> <td valign="top">$row->EV</td></tr>
			<tr><td valign="top" width="40%"><strong>Laatste vermelding:</strong></td> <td valign="top">$row->LV</td></tr>
			<tr><td valign="top" width="40%"><strong>ENK:</strong></td> <td valign="top">$row->ENK_code</td></tr>

	
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
    <p class="indent"><a href="javascript:history.back()"><strong>[terug naar resultatenset]</strong></a></p>
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
