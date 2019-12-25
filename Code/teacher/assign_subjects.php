<?php
// Import main class
require "../classes/teacher.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Assign Teacher To Students - Admin");

$students_arr = filter_input(INPUT_POST, "students", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if (isset($students_arr)) {
    if ($students_arr[0] == "EMPTY") {
        if (count($students_arr) > 0) {
            $teacher = new Teacher();
            $teacher->assign_teacher(filter_input(INPUT_POST, "students", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), filter_input(INPUT_POST, "subject_id", FILTER_DEFAULT));
            Structure::successBox("Assign Students", "Succesfully assigned the following student(s) to ".filter_input(INPUT_GET, "subject_name", FILTER_DEFAULT)."!<br>", "view_subjects.php");
            unset($teacher);
        } else {
            Structure::errorBox("Assign Students", "No students available!");
        }
    } else {
        Structure::errorBox("Assign Students", "No students available!");
    }
} elseif (Structure::is_int_present(filter_input(INPUT_GET, "subject_id", FILTER_DEFAULT)) == true) {
    $teacher = new Teacher();
    if ($teacher->subject_exists(filter_input(INPUT_GET, "subject_id", FILTER_DEFAULT)) === true) {
        $students = $teacher->subject_sort(filter_input(INPUT_GET, "subject_id", FILTER_DEFAULT));

        if (count($students) > 0) {
            echo('<main role="main" class="container mt-3  mx-auto">');
            Structure::topHeading("Assign Students");
            echo('<hr>
            <form method="post">
            <input type="hidden" name="students[]" value="EMPTY">
              <div class="row">
                <div class="col">
                    <fieldset>
                    <table class="table table-striped table-bordered table-hover">
                    <caption class="text-info">Assign student to <i>{$_GET['subject_name']}</i></caption>
                      <thead class="bg-dark text-white">
                        <tr>
                          <th scope="col" style=" width: 10%; ">#</th>
                          <th scope="col">Student Name</th>
                        </tr>
                      </thead>
                      <tbody>');
            foreach ($students as $student) {
                $checked = "";
                if ($student["assigned"] == "true") {
                    $checked = "checked";
                }
                echo('<tr>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="students[]" value="{$student['student_id']}" {$checked}>
                    </div>
                  </td>
                  <td>'.$student['student_name'].'</a></td>
                </tr>');
            }
            echo('</tbody>
                  </table>
                </fieldset>
              </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-success btn-small">Submit</button>
                <a class="btn btn-primary btn-small" href="'.Structure::nakedURL("view_subjects.php").'" role="button">Go back!</a>
             </div>
          </div>
      </form>
      </main>');
        } else {
            Structure::errorBox("Assign Students", "No students available!");
        }
    } else {
        Structure::errorBox("Assign Students", "Not a valid teacher!");
    }

    $teacher->close_DB();
} else {
    Structure::errorBox("Assign Students", "No students selected!");
}

Structure::footer();
