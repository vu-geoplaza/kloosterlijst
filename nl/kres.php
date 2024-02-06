<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
    <title>kloosterlijst resultaten</title>
</head>
<body>
<div id="links">
    <?php
    include("menu.inc.php");
    include('db_connect.inc');
    if (!$db) {
        die("Kan niet verbinden: " . mysqli_error());
    }
    ?>
</div>

<div id="content">
<?php include("header.inc"); ?>
    <h3>resultatenoverzicht kloosters</h3>
    <hr>
    <p>
        <?php
        include('../resources/safe_params.inc');
        $script_name = safe_str_html($_SERVER['PHP_SELF']);
        $optionti = '';
        $optiondi = '';
        $optionpv = '';
        $optionge = '';
        $al = '';
        $pt = '';
        $pa = '';
        $st = '';
        $ev = '';
        $lv = '';
        $id = '';

        # $db = include 'db_kloosterlijst.inc';
        $db = include('db_connect.inc');
        if ($db) {
        $optionti = $_POST['optionti'];
        $optiondi = $_POST['optiondi'];
        $optionpv = $_POST['optionpv'];
        $optionge = $_POST["optionge"];
        $al = $_POST["al"];
        $pt = $_POST["pt"];
        $pa = $_POST["pa"];
        $st = $_POST["st"];
        $ev = $_POST["ev"];
        $lv = $_POST["lv"];
        $id = $_POST["id"];
        $query_params = new Template_params();
        if ($optionti != '') {
            $optionti_conditie = " AND TI = '%(optionti)s'";
            $query_params->optionti = $optionti;
        } else {
            $optionti_conditie = '';
        }
        if ($optiondi != '') {
            $optiondi_conditie = " AND DI = '%(optiondi)s'";
            $query_params->optiondi = $optiondi;
        } else {
            $optiondi_conditie = '';
        }
        if ($optionpv != '') {
            $optionpv_conditie = " AND PV = '%(optionpv)s'";
            $query_params->optionpv = $optionpv;
        } else {
            $optionpv_conditie = '';
        }
        if ($al != '') {
            $al_conditie = " AND AL LIKE '%%%(al)s%%'";
            $query_params->al = $al;
        } else {
            $al_conditie = '';
        }
        if ($optionge != '') {
            $optionge_conditie = " AND GE = '%(optionge)s'";
            $query_params->optionge = $optionge;
        } else {
            $optionge_conditie = '';
        }
        if ($pt != '') {
            $pt_conditie = " AND PT LIKE '%%%(pt)s%%'";
            $query_params->pt = $pt;
        } else {
            $pt_conditie = '';
        }
        if ($pa != '') {
            $pa_conditie = " AND PA LIKE '%%%(pa)s%%'";
            $query_params->pa = $pa;
        } else {
            $pa_conditie = '';
        }
        if ($st != '') {
            $st_conditie = " AND ST LIKE '%%%(st)s%%'";
            $query_params->st = $st;
        } else {
            $st_conditie = '';
        }
        if ($ev != '') {
            $ev_conditie = " AND EV >= %(ev)d";
            $query_params->ev = $ev;
        } else {
            $ev_conditie = '';
        }
        if ($lv != '') {
            $lv_conditie = " AND LV <= %(lv)d";
            $query_params->lv = $lv;
        } else {
            $lv_conditie = '';
        }
        if ($id != '') {
            $id_conditie = " AND ID = '%(id)s'";
            $query_params->id = $id;
        } else {
            $id_conditie = '';
        }
        $query_template = new Sql_template();
        $query_template->template = <<<END_OF_QUERY
	select  ID, TI, DI, PV, AL, GE, PT, PA, ST, EV, LV
	FROM  	Kloosterlijst
	WHERE   Kloosterlijst.ID = Kloosterlijst.ID
	$optionti_conditie
	$optiondi_conditie
    $optionpv_conditie
	$optionge_conditie
	$al_conditie
	$pt_conditie
	$pa_conditie
	$st_conditie
	$ev_conditie
	$lv_conditie
	$id_conditie
	ORDER by ID
END_OF_QUERY;

        $query = $query_template->interpolate($query_params);

        if (!($result = mysqli_query($db, $query))) {
            echo 'invalid query.';
        } else {
        $k_form_recordCount = mysqli_num_rows($result);

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

        $html_template = new Html_template();
        $html_template->template = <<<END_OF_HTML
		
		Uw zoekopdracht: <strong>%(optionti)s %(id)s  %(optiondi)s  %(optionpv)s  %(al)s  %(optionge)s %(pt)s %(pa)s %(st)s %(ev)d %(lv)d</strong>
END_OF_HTML;
        # echo $html_template->interpolate(array('optionti' => $optionti, 'optiondi' => $optiondi, 'optionpv' => $optionpv, 'optionge' => $optionge, 'al' => $al, 'pt' => $pt, 'pa' => $pa, 'st' => $st, 'ev' => $ev, 'lv' => $lv 'id' => $id));
        echo $html_template->interpolate($query_params);
        ?>


    <table border="0" cellpadding="4" cellspacing="2">
        <th align="left">ID</th>
        <th align="left">Titel</th>
        <th align="left">Diocees</th>
        <th align="left">Provincie, gewest, land</th>
        <th align="left">Alias</th>
        <th align="left">Gender</th>
        <th align="left">Patroonheilige</th>
        <th align="left">Parochie</th>
        <th align="left">Stadia</th>
        <th align="left">Eerste vermelding</th>
        <th align="left">Laatste vermelding</th>
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
			<td valign="top"><a href="kdetails.php?ID=$row->ID" target="_self">$row->ID</a></td><td valign="top">$row->TI</td><td valign="top">$row->DI</td><td valign="top">$row->PV</td><td valign="top">$row->AL</td><td valign="top">$row->GE</td><td valign="top">$row->PT</td><td valign="top">$row->PA</td>
			<td valign="top">$row->ST</td><td valign="top">$row->EV</td><td valign="top">$row->LV</td> 
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
