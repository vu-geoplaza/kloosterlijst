<?php
$db = include('db_connect.inc');
if (!$db) {
    die("Kan niet verbinden: " . mysqli_error());
}
?>



<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
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
    <h3 class="indent">Zoeken naar uithoven en refugia</h3>
    <hr>
    <p class="indent">Zoeken naar uithoven en refugia, uitgaande van de kloosters waaraan ze zijn verbonden.<br>
        Indien u geen keuze maakt uit de lijst, krijgt u een overzicht van alle uithoven en refugia.
    <form action="urres.php" method="post" class="indent">
        <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
            <tr>
                <td><strong>Zoeken naar uithoven en refugia bij klooster:</strong><br/>
                    <?php
                    include("input_cl.php");
                    if (!($result = mysqli_query($db, "SELECT DISTINCT Klooster FROM Uithoven ORDER BY Klooster"))) {
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

    <p class="indent">Zoeken naar uithoven en refugia, uitgaande van hun plaats van vestiging en/of hun naam.
    <form action="urplres.php" method="post" class="indent">
        <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
            <tr>
                <td><strong>Selecteer een plaats en/of naam:</strong><br/>
                    Plaats:<br>
                    <?php
                    include("input_cl.php");
                    if (!($result = mysqli_query($db, "SELECT DISTINCT Plaats FROM Uithoven ORDER BY Plaats"))) {
                        echo 'invalid query<br>';
                    }
                    ?>
                    <select name="optionurpl" class="size1">
                        <option value="" SELECTED>- selecteer -</option>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value=\"$row[Plaats]\">$row[Plaats]</option>\n";
                        }
                        ?>
                    </select><br/>
                    Naam:<br/>
                    <?php
                    include("input_cl.php");
                    if (!($result = mysqli_query($db, "SELECT DISTINCT Naam FROM Uithoven ORDER BY Naam"))) {
                        echo 'invalid query<br>';
                    }
                    ?>
                    <select name="optionurn" class="size1">
                        <option value="" SELECTED>- selecteer -</option>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value=\"$row[Naam]\">$row[Naam]</option>\n";
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
        <img src="../images/vu.gif" width="195" height="24">
    </p>
</div>
</body>
</html>
