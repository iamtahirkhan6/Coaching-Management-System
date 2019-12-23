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
$struct->header("Add Student - Admin");

// Main Content Goes Here
// Check if form submitted
if (isset($_POST["student_name"]) && isset($_POST["student_phone_number"]) && ($_POST["email"]) && isset($_POST["password"])) {
    $admin = new Admin();
    if (is_bool($admin->create_student($_POST)) === true) {
        // On success
        $struct->successBox("Add Student", "Successfully added student!", $struct->nakedURL("view_students.php"));
    } else {
        // On failure
        $struct->errorBox("Add Student", "Unable to add a student!");
    }
    $admin->close_DB();
} else {

  // Form to fill details
    echo "<main role=\"main\" class=\"container mx-auto mt-3\">";
    echo $struct->topHeading("Add Student");
    echo "    <hr>
          <form method=\"POST\">
            <div class=\"form-group\">
              <label for=\"name\">Name</label>
              <input type=\"text\" name=\"student_name\" class=\"form-control\" id=\"student_name\" aria-describedby=\"student_name\">
            </div>
            <div class=\"form-group\">
              <label for=\"student_phone_number\">Phone Number</label>
              <input type=\"number\" name=\"student_phone_number\" class=\"form-control\" id=\"student_phone_number\" aria-describedby=\"student_phone_number\">
            </div>
            <div class=\"form-group\">
              <label for=\"email\">Email address</label>
              <input type=\"email\" name=\"email\" class=\"form-control\" id=\"email\" aria-describedby=\"email\">
            </div>
            <div class=\"form-group\">
              <label for=\"password\">Password</label>
              <input type=\"password\" name=\"password\" id=\"password\" class=\"form-control\" id=\"password\">
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
// Display Footer
$struct->footer();

// delete object
unset($admin);
unset($struct);
