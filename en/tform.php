<?php
$db = include('db_connect.inc');
if (!$db) {
    die("Kan niet verbinden: " . mysqli_error());
}
?>


<html>
<head>
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">

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
    <h3>Searching for houses of terminarii</h3>
    <hr>
    <p class="indent">Search for houses of <em>terminarii</em> starting from the monastery to which they belong. If you
        make no choice, a survey of all houses of <em>terminarii</em> will be shown.
    <form action="tres.php" method="post" class="indent">
        <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
            <tr>
                <td><strong>Select a monastery:</strong><br/>
                    <?php
                    include("input_cl.php");
                    if (!($result = mysqli_query($db, "SELECT DISTINCT Monastery FROM TermijnhuizenEng ORDER BY Monastery"))) {
                        echo 'invalid query<br>';
                    }
                    ?>
                    <select name="optionti" class="size1">
                        <option value="" SELECTED>- select -</option>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value=\"$row[Monastery]\">$row[Monastery]</option>\n";
                        }
                        ?>
                    </select>
            <tr>
                <td align="center"><input type="submit" name="knop" value="search" class="button"/> <input type="reset"
                                                                                                           value="clear"
                                                                                                           class="button"/>
                </td>
            </tr>
        </table>
    </form>
    </p>

    <p class="indent">Search for houses of <em>terminarii</em> according to location.
    <form action="tplres.php" method="post" class="indent">
        <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
            <tr>
                <td><strong>Select a place:</strong><br/>
                    <?php
                    include("input_cl.php");
                    if (!($result = mysqli_query($db, "SELECT DISTINCT Place FROM TermijnhuizenEng ORDER BY Place"))) {
                        echo 'invalid query<br>';
                    }
                    ?>
                    <select name="optiontpl" class="size1">
                        <option value="" SELECTED>- select -</option>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value=\"$row[Place]\">$row[Place]</option>\n";
                        }
                        ?>
                    </select>
            <tr>
                <td align="center"><input type="submit" name="knop" value="search" class="button"/> <input type="reset"
                                                                                                           value="clear"
                                                                                                           class="button"/>
                </td>
            </tr>
        </table>
    </form>
    </p>
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
