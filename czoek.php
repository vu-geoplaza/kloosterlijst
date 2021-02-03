<html>
<head>
    <meta http-equiv="content-type" content="text/html">
    <link rel="stylesheet" type="text/css" href="mp.css"/>
    <title>Kloosterlijst</title>
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
        <img src="images/vu.gif" width="195" height="24">
    </p>
</div>
</body>
</html>

