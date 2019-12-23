<?php
Session::init();

// Import main class
require "classes/structure.class.php";

Session::session_unset();
Session::session_destroy();


Structure::checkLogin();
