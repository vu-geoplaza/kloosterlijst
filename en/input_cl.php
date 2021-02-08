<?php
$input_arr = array();
foreach ($_POST as $key => $input_arr) {
    $_POST[$key] = addslashes($input_arr);
}
?>