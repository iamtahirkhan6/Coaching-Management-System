<?php
// Start session
session_start();

// Import main class
require_once "../classes/teacher.class.php";
require_once "../classes/structure.class.php";

// Initialize HTML structure
$struct = new Structure();

// Check if logged in otherwise redirect to login page
$struct->checkLogin();

// Load Header
$struct->header("Edit Subject - Admin");

// Main Content Goes Here
// Check if form submitted
if (isset($_POST["subject_name"])) {
    $teacher = new Teacher();

    if (is_bool($teacher->update_subject($_POST["subject_name"], $_GET["subject_id"])) === true) {
        // On success
        $struct->successBox("Update Subject", "Successfully updated subject!", $struct->nakedURL("view_subjects.php"));
    } else {
        // On failure
        $struct->errorBox("Update Subject", "Unable to update subject!");
    }

    //$admin->close_DB();
} elseif (isset($_GET["subject_id"])) {
    $teacher = new Teacher();
    $subject = $teacher->view_subject_info($_GET["subject_id"], true);

    if (count($subject) <= 0) {
        $struct->errorBox("Update Subject", "Select a valid subject!");
    } else {
        // Form to fill details
        echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
        echo $struct->topHeading("Update Subject");
        echo "<hr>
          <form method=\"POST\">
            <div class=\"form-group\">
              <label for=\"name\">Subject Name</label>
              <input type=\"text\" name=\"subject_name\" class=\"form-control\" id=\"subject_name\" aria-describedby=\"subject_name\" value=\"{$subject["subject_name"]}\">
            </div>

            <div class=\"row\">
              <div class=\"col-sm-12\">
                  <button type=\"submit\" class=\"btn btn-success btn-small\">Submit</button>
                  <a class=\"btn btn-primary btn-small\" href=\"".$struct->nakedURL("view_subjects.php")."\" role=\"button\">Go back!</a>
               </div>
            </div>
          </form>
      </main>";
    }

    $teacher->close_DB();
} else {
    $struct->errorBox("Update Subject", "No subject selected!");
}
// Display Footer
$struct->footer();

// delete object
unset($teacher);
unset($struct);
