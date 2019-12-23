<?php
// Start session
session_start();

// Import main class
require_once "classes/admin.class.php";
require_once "classes/structure.class.php";

// Initialize HTML structure
$struct = new Structure();

// Check if any type of user is logged in
if (!isset($_SESSION["user_logged_type"])) {
    if (isset($_POST["user_type"]) && isset($_POST["email"]) && isset($_POST["password"])) {
        $activity = new Activity();
        $is_login = $activity->login($_POST["user_type"], $_POST["email"], $_POST["password"]);
        $struct->redirect($_SESSION["user_logged_type"]."/");
    } else {
        $struct->header("Login");

        echo "
        <main role=\"main\" class=\"container mt-3\">
            <div class=\"row justify-content-md-center\">
              <img class=\"mb-4\" src=\"src/img/login.png\" width=\"72\" height=\"72\">
            </div>
            <div class=\"row\">
                    <form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" class=\"form-signin\">

                    <h1 class=\"h3 mb-3 font-weight-normal\">Please sign in</h1>
                    <div class=\"form-group\">
                      <select class=\"form-control\" name=\"user_type\" id=\"user_type\" style=\"height: calc(2.5rem + 2px);\">
                        <option value=\"admin\">Admin</option>
                        <option value=\"student\">Student</option>
                        <option value=\"teacher\">Teacher</option>
                      </select>
                    </div>
                    <label for=\"inputEmail\" class=\"sr-only\">Email address</label>
                    <input type=\"email\" id=\"email\" name=\"email\" class=\"form-control\" placeholder=\"Email address\" required autofocus>
                    <br>
                    <label for=\"inputPassword\" class=\"sr-only\">Password</label>
                    <input type=\"password\" id=\"password\" name=\"password\" class=\"form-control\" placeholder=\"Password\" required>

                    <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Sign in</button>
                  </form>
            </div>
        </main>";
        $struct->footer();
    }
} else {
    $struct->redirect($_SESSION["user_logged_type"]."/");
}
