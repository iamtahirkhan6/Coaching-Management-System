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
$struct->header("Assign Teacher To Students - Admin");

if (isset($_POST["students"])) {
    if ($_POST["students"][0] == "EMPTY") {
      if(count($_POST["students"]) > 0)
      {
        $teacher = new Teacher();
        $teacher->assign_teacher($_POST["students"], $_GET["subject_id"]);
        unset($teacher);
        $struct->successBox("Assign Students", "Succesfully assigned the following student(s) to {$_GET["subject_name"]}!<br>", "view_subjects.php");
      } else {
        $struct->errorBox("Assign Students", "No students available!");
      }

    } else {
      $struct->errorBox("Assign Students", "No students available!");
    }
} elseif ($struct->is_int_present($_GET["subject_id"]) == true) {
    $teacher = new Teacher();
    if ($teacher->subject_exists($_GET["subject_id"]) === true) {
        $students = $teacher->subject_sort($_GET["subject_id"]);

        if (count($students) > 0) {
            echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
            echo $struct->topHeading("Assign Students");
            echo "
      <hr>
      <form method=\"post\">
      <input type=\"hidden\" name=\"students[]\" value=\"EMPTY\">
        <div class=\"row\">
          <div class=\"col\">
              <fieldset>
              <table class=\"table table-striped table-bordered table-hover\">
              <caption class=\"text-info\">Assign student to <i>{$_GET['subject_name']}</i></caption>
                <thead class=\"bg-dark text-white\">
                  <tr>
                    <th scope=\"col\" style=\" width: 10%; \">#</th>
                    <th scope=\"col\">Student Name</th>
                  </tr>
                </thead>
                <tbody>";
            foreach ($students as $student) {
              $checked = "";
              if($student["assigned"] == "true") $checked = "checked";
                echo "
                  <tr>
                    <td>
                      <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"checkbox\" name=\"students[]\" value=\"{$student['student_id']}\" {$checked}>
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
                <a class=\"btn btn-primary btn-small\" href=\"".$struct->nakedURL("view_subjects.php")."\" role=\"button\">Go back!</a>
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
    $struct->errorBox("Assign Students", "No students selected!");
}

$struct->footer();
