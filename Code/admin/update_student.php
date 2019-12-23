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
$struct->header("Update Student - Admin");

// Main Content Goes Here
// Check if form submitted
if (isset($_POST["student_id"]) && isset($_POST["student_name"]) && isset($_POST["student_phone_number"]) && ($_POST["email"]) && isset($_POST["password"])) {

    $admin = new Admin();

    if (is_bool($admin->update_student($_POST)) === true) {
      // On success
      $struct->successBox("Update Student","Successfully updated student!", $struct->nakedURL("view_students.php"));
    } else {
      // On failure
      $struct->errorBox("Update Student","Unable to update student!");
    }

    //$admin->close_DB();
} elseif(isset($_GET["student_id"]) && !empty($_GET["student_id"])) {
  $admin    = new Admin();
  $student = $admin->view_student($_GET["student_id"], true);

  if(!isset($student["student_id"]))
  {
    $struct->errorBox("Update Student","Select a valid student!");
  } else {
    // Form to fill details
    echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
    echo $struct->topHeading("Update Student");
    echo "<hr>
          <form method=\"POST\">
            <input type=\"hidden\" name=\"student_id\" value=\"{$student['student_id']}\">
            <div class=\"form-group\">
              <label for=\"name\">Name</label>
              <input type=\"text\" name=\"student_name\" class=\"form-control\" id=\"student_name\" aria-describedby=\"student_name\" value=\"{$student["student_name"]}\">
            </div>
            <div class=\"form-group\">
              <label for=\"student_phone_number\">Phone Number</label>
              <input type=\"number\" name=\"student_phone_number\" class=\"form-control\" id=\"student_phone_number\" aria-describedby=\"student_phone_number\" value=\"{$student["student_phone_number"]}\">
            </div>
            <div class=\"form-group\">
              <label for=\"email\">Email address</label>
              <input type=\"email\" name=\"email\" class=\"form-control\" id=\"email\" aria-describedby=\"email\" value=\"{$student["email"]}\">
            </div>
            <div class=\"form-group\">
              <label for=\"password\">Password</label>
              <input type=\"password\" name=\"password\" id=\"password\" class=\"form-control\" id=\"password\" value=\"{$student["password"]}\">
            </div>

            <div class=\"row\">
              <div class=\"col-sm-12\">
                  <button type=\"submit\" class=\"btn btn-success btn-small\">Submit</button>
                  <a class=\"btn btn-primary btn-small\" href=\"".$struct->nakedURL("view_students.php")."\" role=\"button\">Go back!</a>
               </div>
            </div>
          </form>
      </main>";
  }

  $admin->close_DB();
} else {
  $struct->errorBox("Update Student","No student selected!");
}
// Display Footer
$struct->footer();

// delete object
unset($admin);
unset($struct);
