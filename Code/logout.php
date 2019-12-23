<?php
// Import main class
require "classes/structure.class.php";

Session::init();
Session::unset();
Session::destroy();
Structure::checkLogin();
