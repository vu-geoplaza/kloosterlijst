<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
    <LINK rel="stylesheet" href="mp.css" type="text/css">
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
            <td align="left"><a href="http://www.fgw.vu.nl"><img src="images/logo_fgw.gif" border="0"></a></td>
            <td align="right"><a href="http://www.vu.nl"><img src="images/grif.gif" width="312" height="104" border="0"></a>
            </td>
        </tr>
    </table>
    <h1 class="indent">Kloosterlijst</h1>
    <h3 class="indent">volledig record uithof/refugium</h3>
    <hr>
    <p>
        <?php
        include('safe_params.inc');
        $script_name = safe_str_html($_SERVER['PHP_SELF']);
        $id_ur = '';

        # $db = include 'db_kloosterlijst.inc';
        $db = include('db_connect.inc');
        if ($db) {
        if (isset($_GET["id_ur"])) {
            $id_ur = (string)$_GET["id_ur"];
            if (!ctype_alnum($id_ur)) {
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
	select  idnr_klooster, Klooster, Categorie, Plaats, Naam, Prov, Kadaster, Opmerkingen, Literatuur, id_ur, Breedte_dec, Lengte_dec, ENK_code, AMK, status, activit, lit
	FROM  	Uithoven
	$id_ur_conditie	
END_OF_QUERY;

        $query = $query_template->interpolate($query_params);

        if (!($result = mysqli_query($db, $query))) {
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
    <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent"
           width="60%">
        <?php
        while (($row = mysqli_fetch_object($result))) {
            echo <<<END_OF_ENTRY
			<tr><td valign="top"><strong>Naam:</strong></td> <td valign="top">$row->Naam</td></tr>
			<tr><td valign="top"><strong>Id Klooster:</strong></td> <td valign="top">$row->idnr_klooster</td></tr>
			<tr><td valign="top"><strong>Klooster:</strong></td> <td valign="top">$row->Klooster</td></tr>
			<tr><td valign="top"><strong>Categorie:</strong></td> <td valign="top">$row->Categorie</td></tr>
			<tr><td valign="top"><strong>Plaats:</strong></td> <td valign="top">$row->Plaats</td></tr>
			<tr><td valign="top"><strong>Provincie:</strong></td> <td valign="top">$row->Prov</td></tr>
			<tr><td valign="top"><strong>Kadaster:</strong></td> <td valign="top">$row->Kadaster</td></tr>
			<tr><td valign="top"><strong>Opmerkingen:</strong></td> <td valign="top">$row->Opmerkingen</td></tr>
			<tr><td valign="top"><strong>Literatuur:</strong></td> <td valign="top">$row->Literatuur</td></tr>
			<tr><td valign="top"><strong>Breedte:</strong></td> <td valign="top">$row->Breedte_dec</td></tr>
			<tr><td valign="top"><strong>Lengte:</strong></td> <td valign="top">$row->Lengte_dec</td></tr>
			<tr><td valign="top"><strong>ENK:</strong></td> <td valign="top">$row->ENK_code</td></tr>
			<tr><td valign="top"><strong>AMK:</strong></td> <td valign="top">$row->AMK</td></tr>
			<tr><td valign="top"><strong>Archeologische status:</strong></td> <td valign="top">$row->status</td></tr>
			<tr><td valign="top"><strong>Archeologische activiteiten:</strong></td> <td valign="top">$row->activit</td></tr>
			<tr><td valign="top"><strong>Archeologische publicaties:</strong></td> <td valign="top">$row->lit</td></tr>
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
