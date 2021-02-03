<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
    <LINK rel="stylesheet" href="mp.css" type="text/css">
    <title>kloosterlijst resultaten</title>
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
    <h3 class="indent">resultatenoverzicht uithoven en refugia</h3>
    <hr>
    <p>
        <?php
        include('safe_params.inc');
        $script_name = safe_str_html($_SERVER['PHP_SELF']);
        $optionti = '';

        # $db = include 'db_kloosterlijst.inc';
        $db = include('db_connect.inc');
        if ($db) {
        if (isset($_POST["optionti"])) {
            $optionti = (string)$_POST["optionti"];
            # validity check ?
            # if(!is_valid_title($optionti)) {
            # die('<p>invalid parameter value:<br/>' . safe_str_html($optionti) . '</p>');
            # }
        }
        $query_params = new Template_params();
        if ($optionti != '') {
            $optionti_conditie = " AND  Klooster = '%(optionti)s'";
            $query_params->optionti = $optionti;
        } else {
            $optionti_conditie = '';
        }

        $query_template = new Sql_template();
        $query_template->template = <<<END_OF_QUERY
	select  idnr_klooster, Klooster, Categorie, Plaats, Naam, id_ur
	FROM  	Uithoven 
	WHERE   idnr_klooster = idnr_klooster
	$optionti_conditie

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
        ?>

        <?php
        $html_template->template = <<<END_OF_HTML
		
		Uw zoekactie <em>%(optionti)s</em> heeft de volgende resultaten opgeleverd";
END_OF_HTML;
        echo $html_template->interpolate(array('optionti' => $optionti));
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
			<td>$row->Naam</td><td><a href="urshow.php?id_ur=$row->id_ur" target="_self">&</a></td>
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
