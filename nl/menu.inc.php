<html>
<head>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Raleway%3A400%2C600&#038;subset=latin&#038;display=swap' type='text/css' media='all' />
</head>
<body>
<hr class="hrmenu">
<ul class="menulist">
    <li><a href="index.php" class="menu">&raquo; Inleiding</a></li>
    <li><a href="kform.php" class="menu">&raquo; Kloosters</a></li>
    <li><a href="urform.php" class="menu">&raquo; Uithoven & Refugia</a></li>
    <li><a href="tform.php" class="menu">&raquo; Termijnhuizen</a></li>
    <li><a href="kapform.php" class="menu">&raquo; Kapittels</a></li>
    <li><a href="elim.php" class="menu">&raquo; Eliminatielijst</a></li>
    <li><a href="czoek.php" class="menu">&raquo; Concordantie</a></li>
    <li><a href="topverw.php" class="menu">&raquo; Topografische index</a></li>
    <li><a href="lit.php" class="menu">&raquo; Bibliografie&euml;n</a></li>
    <li><a href="voorenna.php" class="menu">&raquo; Voor en na 1800</a></li>
    <li><a href="col.php" class="menu">&raquo; Colofon</a></li>
</ul>
<br/><br/>
<hr class="hrmenu">
<?php
    $parsed = parse_url($_SERVER['REQUEST_URI']);
    $lang_url = '../en/' . basename($_SERVER['SCRIPT_NAME']);
    if (str_starts_with($parsed['query'], 'ID=')) {
        $lang_url = $lang_url . '?' . 'ID=' . substr($parsed['query'], 3, 8);
    }
?>
<a href="<?=$lang_url ?>" class="menu">&raquo; Dutch</a>
<a href="<?=$lang_url ?>" class="menu"><img src="../images/english.png" border="0"></a>
<hr class="hrmenu">
</body>
</html>

