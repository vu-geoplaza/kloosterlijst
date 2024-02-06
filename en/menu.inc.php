<html>
<head>
    <link rel='stylesheet'
          href='https://fonts.googleapis.com/css?family=Raleway%3A400%2C600&#038;subset=latin&#038;display=swap'
          type='text/css' media='all'/>
</head>
<body>
<hr class="hrmenu">
<ul class="menulist">
    <li><a href="index.php" class="menu">&raquo; Introduction</a></li>
    <li><a href="kform.php" class="menu">&raquo; Monasteries</a></li>
    <li><a href="urform.php" class="menu">&raquo; Granges & Refuges</em></a></li>
    <li><a href="tform.php" class="menu">&raquo; Houses of terminarii</em></a></li>
    <li><a href="kapform.php" class="menu">&raquo; Collegiate churches</em></a></li>
    <li><a href="elim.php" class="menu">&raquo; List of Eliminations</a></li>
    <li><a href="czoek.php" class="menu">&raquo; Concordance</a></li>
    <li><a href="topverw.php" class="menu">&raquo; Topographical Index</a></li>
    <li><a href="lit.php" class="menu">&raquo; Bibliographies</a></li>
    <li><a href="col.php" class="menu">&raquo; Colophon</a></li>
</ul>
<br><br>
<hr class="hrmenu">
<?php
    $parsed = parse_url($_SERVER['REQUEST_URI']);
    $lang_url = '../nl/' . basename($_SERVER['SCRIPT_NAME']);
    if (str_starts_with($parsed['query'], 'ID=')) {
        $lang_url = $lang_url . '?' . 'ID=' . substr($parsed['query'], 3, 8);
    }
?>
<a href=<?=$lang_url ?> class="menu">&raquo; Dutch</a>
<a href=<?=$lang_url ?> class="menu"><img src="../images/dutch.png" border="0"></a>
<hr class="hrmenu">

</body>
</html>

