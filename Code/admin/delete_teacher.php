<?php
// Start session
session_start();

// Import main class
require_once "../classes/admin.class.php";
require_once "../classes/structure.class.php";

// Initialize HTML structure
$struct = new Structure();

// Check if logged in otherwise redirect to login page
$struct->checkLogin();

// Load Header
$struct->header("Delete Teacher - Admin");

// Main Content Goes Here
// Check if form submitted
if (isset($_POST["teacher_id"]) && isset($_POST["delete_confirm"]) && $_POST["delete_confirm"] == "yes") {
    $admin = new Admin();

    if (is_bool($admin->delete_teacher($_POST)) === true) {
        // On success
        $struct->successBox("Delete Teacher", "Successfully deleted teacher!", $struct->nakedURL("view_teachers.php"));
    } else {
        // On failure
        $struct->errorBox("Delete Teacher", "Unable to delete teacher!");
    }

    //$admin->close_DB();
} elseif (isset($_GET["teacher_id"]) && !empty($_GET["teacher_id"])) {
    $admin    = new Admin();
    $teacher = $admin->view_teacher($_GET["teacher_id"], true);

    if (!isset($teacher["teacher_id"])) {
        $struct->errorBox("Delete Teacher", "Select a valid teacher!");
    } else {
        // Form to fill details
        echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
        echo $struct->topHeading("Delete Teacher");
        echo "<hr>
    <div class=\"d-flex justify-content-center pb-4\"> <img src=\"../src/img/delete.png\" style=\"width: 15%;height: 15%;\"></div>
    <div class=\"d-flex justify-content-center\">Are you sure you want to delete&nbsp;<b>{$teacher["teacher_name"]}</b>?</div>
    <br>
    <div class=\"row justify-content-center\">
    <form method=\"POST\">
      <div class=\"\">
          <input type=\"hidden\" name=\"teacher_id\" value=\"{$teacher["teacher_id"]}\">
          <input type=\"hidden\" name=\"delete_confirm\" value=\"yes\">
          <button type=\"submit\" class=\"btn btn-danger btn-small\">Yes</button>
          <a class=\"btn btn-success btn-small\" href=\"{$struct->nakedURL("view_teachers.php")}\">No</a>
       </div>
    </form>
    </div>
    </main>";
    }

    $admin->close_DB();
} else {
    $struct->errorBox("Update Teacher", "No teacher selected!");
}
// Display Footer
$struct->footer();

// delete object
unset($admin);
unset($struct);
