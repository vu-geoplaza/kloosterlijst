<html>
<head>
    <meta http-equiv="content-type" content="text/html">
    <link rel="stylesheet" type="text/css" href="mp.css"/>
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
    <h3 class="indent">Searching for correspondences</h3>
    <hr>
    <p>
    <p class="indent">Search for correspondences between <em>Monasticon Batavum</em> and the Census. Give in a place
        name; the search will yield one or more entries of the <em>Monasticon Batavum</em> according to Volume and Page,
        which are linked to records in the list of Monasteries.</p>
    <form action="conc.php" method="post" class="indent">
        <table bgcolor="#FFFFFF" cellpadding="2" cellspacing="5" border="2" bordercolor="#B94A85" class="indent">
            <tr>
                <td>
                    <strong>Place:</strong><br/>
                    <input type="text" name="cplaats" size="50">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="knop" value="search" class="button"> <input type="reset" value="clear"
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

