<html>
<head>
    <LINK rel="stylesheet" href="../resources/mp.css" type="text/css">
    <meta http-equiv="content-type" content="text/html">
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
    <h3 class="indent">Zoeken in de concordantie</h3>
    <hr>
    <p>
    <form action="conc.php" method="post" class="indent">
        <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
            <tr>
                <td>
                    <strong>Plaatsnaam:</strong><br/>
                    <input type="text" name="cplaats" size="50">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="knop" value="zoeken" class="button"> <input type="reset" value="wissen"
                                                                                           class="button">
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

