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
$struct->header("Delete Student - Admin");

// Main Content Goes Here
// Check if form submitted
if (isset($_POST["student_id"]) && isset($_POST["delete_confirm"]) && $_POST["delete_confirm"] == "yes") {
    $admin = new Admin();

    if (is_bool($admin->delete_student($_POST)) === true) {
        // On success
        $struct->successBox("Delete Student", "Successfully deleted student!", $struct->nakedURL("view_students.php"));
    } else {
        // On failure
        $struct->errorBox("Delete Student", "Unable to delete student!");
    }

    //$admin->close_DB();
} elseif (isset($_GET["student_id"]) && !empty($_GET["student_id"])) {
    $admin    = new Admin();
    $student = $admin->view_student($_GET["student_id"], true);

    if (!isset($student["student_id"])) {
        $struct->errorBox("Delete Student", "Select a valid student!");
    } else {
        // Form to fill details
        echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
        echo $struct->topHeading("Delete Student");
        echo "<hr>
    <div class=\"d-flex justify-content-center pb-4\"> <img src=\"../src/img/delete.png\" style=\"width: 15%;height: 15%;\"></div>
    <div class=\"d-flex justify-content-center\">Are you sure you want to delete&nbsp;<b>{$student["student_name"]}</b>?</div>
    <br>
    <div class=\"row justify-content-center\">
    <form method=\"POST\">
      <div class=\"\">
          <input type=\"hidden\" name=\"student_id\" value=\"{$student["student_id"]}\">
          <input type=\"hidden\" name=\"delete_confirm\" value=\"yes\">
          <button type=\"submit\" class=\"btn btn-danger btn-small\">Yes</button>
          <a class=\"btn btn-success btn-small\" href=\"{$struct->nakedURL("view_students.php")}\">No</a>
       </div>
    </form>
    </div>
    </main>";
    }

    $admin->close_DB();
} else {
    $struct->errorBox("Update Student", "No student selected!");
}
// Display Footer
$struct->footer();

// delete object
unset($admin);
unset($struct);
