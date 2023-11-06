<?php
Global $db;
$db = mysqli_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PW'), getenv('DB_NAME'));
mysqli_set_charset($db, 'utf8');
return $db;

?>