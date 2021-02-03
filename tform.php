<?php
$db = include('db_connect.inc');
if (!$db) {
    die("Kan niet verbinden: " . mysqli_error());
}
?>

<?php
function qdbconn()
{
    mysqli_close($db);
}

?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <!-- <LINK rel="stylesheet" href="mp.css" type="text/css"> -->
    <title>Kloosterlijst</title>
</head>
<body>

<div id="links">
    <?php
    include("menu.inc");
    ?>
</div>
<div id="content">
<?php include("header.inc"); ?>
    <h3 class="indent">Zoeken naar termijnhuizen</h3>
    <hr>
    <p class="indent">Zoeken naar termijnhuizen, uitgaande van de kloosters waaraan ze zijn verbonden.<br>
        Indien u geen keuze maakt uit de lijst, krijgt u een overzicht van alle termijnhuizen.
    <form action="tres.php" method="post" class="indent">
        <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
            <tr>
                <td><strong>Termijnhuizen bij klooster:</strong><br/>
                    <?php
                    include("input_cl.php");
                    if (!($result = mysqli_query($db, "SELECT DISTINCT Klooster FROM Termijnhuizen ORDER BY Klooster"))) {
                        echo 'invalid query<br>';
                    }
                    ?>
                    <select name="optionti" class="size1">
                        <option value="" SELECTED>- selecteer -</option>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value=\"$row[Klooster]\">$row[Klooster]</option>\n";
                        }
                        ?>
                    </select>
            <tr>
                <td align="center"><input type="submit" name="knop" value="zoeken" class="button"/> <input type="reset"
                                                                                                           value="wissen"
                                                                                                           class="button"/>
                </td>
            </tr>
        </table>
    </form>
    </p>

    <p class="indent">Zoeken naar termijnhuizen, uitgaande van hun plaats van vestiging.
    <form action="tplres.php" method="post" class="indent">
        <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
            <tr>
                <td><strong>Selecteer een plaats:</strong><br/>
                    <?php
                    include("input_cl.php");
                    if (!($result = mysqli_query($db, "SELECT DISTINCT Plaats FROM Termijnhuizen ORDER BY Plaats"))) {
                        echo 'invalid query<br>';
                    }
                    ?>
                    <select name="optiontpl" class="size1">
                        <option value="" SELECTED>- selecteer -</option>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value=\"$row[Plaats]\">$row[Plaats]</option>\n";
                        }
                        ?>
                    </select>
            <tr>
                <td align="center"><input type="submit" name="knop" value="zoeken" class="button"/> <input type="reset"
                                                                                                           value="wissen"
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
        <img src="images/vu.gif" width="195" height="24">
    </p>
</div>
</body>
</html>
