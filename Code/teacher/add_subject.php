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
$struct->header("Add Subject - Teacher Panel");

// Main Content Goes Here
// Check if form submitted
if (isset($_POST["subject_name"])) {
    $teacher = new Teacher();
    if (is_bool($teacher->create_subject($_POST["subject_name"])) === true) {
        // On success
        $struct->successBox("Add Subject", "Successfully created subject!", $struct->nakedURL("view_subjects.php"));
    } else {
        // On failure
        $struct->errorBox("Add Subject", "Unable to add subject!");
    }
    $teacher->close_DB();
} else {

  // Form to fill details
    echo "<main role=\"main\" class=\"container mx-auto mt-3\">";
    echo $struct->topHeading("Add Subject");
    echo "    <hr>
          <form method=\"POST\">
            <div class=\"form-group\">
              <label for=\"name\">Subject Name</label>
              <input type=\"text\" name=\"subject_name\" class=\"form-control\" id=\"subject_name\" aria-describedby=\"subject_name\">
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
// Display Footer
$struct->footer();

// delete object
unset($teacher);
unset($struct);
