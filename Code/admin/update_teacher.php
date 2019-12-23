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
$struct->header("Update Teacher - Admin");

// Main Content Goes Here
// Check if form submitted
if (isset($_POST["teacher_id"]) && isset($_POST["teacher_name"]) && isset($_POST["teacher_phone_number"]) && ($_POST["email"]) && isset($_POST["password"])) {

    $admin = new Admin();

    if (is_bool($admin->update_teacher($_POST)) === true) {
      // On success
      $struct->successBox("Update Teacher","Successfully updated teacher!", $struct->nakedURL("view_teachers.php"));
    } else {
      // On failure
      $struct->errorBox("Update Teacher","Unable to update teacher!");
    }

    //$admin->close_DB();
} elseif(isset($_GET["teacher_id"]) && !empty($_GET["teacher_id"])) {
  $admin    = new Admin();
  $teacher  = $admin->view_teacher($_GET["teacher_id"], true);

  if(!isset($teacher["teacher_id"]))
  {
    $struct->errorBox("Update Teacher","Select a valid teacher!");
  } else {
    // Form to fill details
    echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
    echo $struct->topHeading("Update Teacher");
    echo "    <hr>
          <form method=\"POST\">
            <input type=\"hidden\" name=\"teacher_id\" value=\"".$teacher["teacher_id"]."\">
            <div class=\"form-group\">
              <label for=\"name\">Name</label>
              <input type=\"text\" name=\"teacher_name\" class=\"form-control\" id=\"teacher_name\" aria-describedby=\"teacher_name\" value=\"{$teacher["teacher_name"]}\">
            </div>
            <div class=\"form-group\">
              <label for=\"teacher_phone_number\">Phone Number</label>
              <input type=\"number\" name=\"teacher_phone_number\" class=\"form-control\" id=\"teacher_phone_number\" aria-describedby=\"teacher_phone_number\" value=\"{$teacher["teacher_phone_number"]}\">
            </div>
            <div class=\"form-group\">
              <label for=\"email\">Email address</label>
              <input type=\"email\" name=\"email\" class=\"form-control\" id=\"email\" aria-describedby=\"email\" value=\"{$teacher["email"]}\">
            </div>
            <div class=\"form-group\">
              <label for=\"password\">Password</label>
              <input type=\"password\" name=\"password\" id=\"password\" class=\"form-control\" id=\"password\" value=\"{$teacher["password"]}\">
            </div>

            <div class=\"row\">
              <div class=\"col-sm-12\">
                  <button type=\"submit\" class=\"btn btn-success btn-small\">Submit</button>
                  <a class=\"btn btn-primary btn-small\" href=\"".$struct->nakedURL("view_teachers.php")."\" role=\"button\">Go back!</a>
               </div>
            </div>
          </form>
      </main>";
  }

  $admin->close_DB();
} else {
  $struct->errorBox("Update Teacher","No teacher selected!");
}
// Display Footer
$struct->footer();

// delete object
unset($admin);
unset($struct);
