<html>
<head>
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">

    <title>Monasteries in the Netherlands until 1800</title>
</head>
<body>
<div id="links">
    <?php
    include("menu.inc");
    ?>
</div>

<div id="content">
    <?php include("header.inc"); ?>
    <h3 class="indent">results for granges and urban refuges</h3>
    <hr>
    <p>
        <?php
        include('../resources/safe_params.inc');
        $script_name = safe_str_html($_SERVER['PHP_SELF']);
        $optionti = '';

        # $db = include 'db_Kloosterlijst.inc';
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
            $optionti_conditie = " AND  Monastery = '%(optionti)s'";
            $query_params->optionti = $optionti;
        } else {
            $optionti_conditie = '';
        }

        $query_template = new Sql_template();
        $query_template->template = <<<END_OF_QUERY
	select  idnr_Monastery, Monastery, Category, Place, Name, id_ur
	FROM  	UithovenEng 
	WHERE   idnr_Monastery = idnr_Monastery
	$optionti_conditie

	ORDER by Monastery
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
        ?>

        <?php
        $html_template->template = <<<END_OF_HTML
		
		Your query <em>%(optionti)s</em> ";
END_OF_HTML;
        echo $html_template->interpolate(array('optionti' => $optionti));
        ?>


    <table border="0" cellpadding="4" cellspacing="2">
        <tr>
            <th>Idnr</th>
            <th>Monastery</th>
            <th>Category</th>
            <th>Place</th>
            <th>Name grange or urban refuge</th>
            <th>More info</th>
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
			<td valign="top">$row->idnr_Monastery</td><td valign="top">$row->Monastery</td><td valign="top">$row->Category</td><td valign="top">$row->Place</td>
			<td>$row->Name</td><td><a href="urshow.php?id_ur=$row->id_ur" target="_self">&</a></td>
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
