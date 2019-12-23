<?php
session_start() ;
// Import main class
require_once "classes/structure.class.php";

session_unset();
session_destroy();


$struct = new Structure();
$struct->checkLogin();
?>
