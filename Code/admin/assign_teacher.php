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
$struct->header("Assign Teacher To Student - Admin");

if (isset($_POST["teacher_id"])) {
    if (count($_POST["students"]) > 0) {
        foreach ($_POST["students"] as $student_id) {
            $admin = new Admin();
            $admin->assign_teacher($_POST["teacher_id"], $student_id);
            unset($admin);
        }
        $struct->successBox("Assign Students", "Succesfully assigned the following student(s) to {$_GET["teacher_name"]}!<br>");
    }
} elseif ($struct->is_int_present($_GET["teacher_id"]) == true) {
    $teacher = new Admin();
    if ($teacher->teacher_exists($_GET["teacher_id"]) === true) {
        $students = $teacher->student_with_no_teacher();
        if (count($students) > 0) {
            echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
            echo $struct->topHeading("Assign Teacher");
            echo "
      <hr>
      <form method=\"post\">
        <input type=\"hidden\" name=\"teacher_id\" value=\"{$_GET['teacher_id']}\">

        <div class=\"row\">
          <div class=\"col\">
              <fieldset>
              <table class=\"table table-striped table-bordered table-hover\">
              <caption class=\"text-info\">Assign student to <i>{$_GET['teacher_name']}</i></caption>
                <thead class=\"bg-dark text-white\">
                  <tr>
                    <th scope=\"col\" style=\" width: 10%; \">#</th>
                    <th scope=\"col\">Student Name</th>
                  </tr>
                </thead>
                <tbody>";
            foreach ($students as $student) {
                echo "
                  <tr>
                    <td>
                      <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"checkbox\" name=\"students[]\" value=\"{$student['student_id']}\">
                      </div>
                    </td>
                    <td>{$student['student_name']}</a></td>
                  </tr>";
            }
            echo "    </tbody>
                  </table>
                </fieldset>
              </div>
          </div>

          <div class=\"row\">
            <div class=\"col-sm-12\">
                <button type=\"submit\" class=\"btn btn-success btn-small\">Submit</button>
                <a class=\"btn btn-primary btn-small\" href=\"".$struct->nakedURL("view_teachers.php")."\" role=\"button\">Go back!</a>
             </div>
          </div>
      </form>
      </main>";
        } else {
            $struct->errorBox("Assign Students", "No students available!");
        }
    } else {
        $struct->errorBox("Assign Students", "Not a valid teacher!");
    }

    $teacher->close_DB();
} else {
    $struct->errorBox("Assign Students", "No teacher selected!");
}

$struct->footer();
