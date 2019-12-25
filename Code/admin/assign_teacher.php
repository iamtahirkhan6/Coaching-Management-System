<?php
// Import main class
require "../classes/admin.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Assign Teacher To Student - Admin");

if (Structure::if_all_inputs_exists(array("teacher_id"), "POST") == true) {
    if (count(filter_input(INPUT_POST, "students", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY)) > 0) {
        foreach (filter_input(INPUT_POST, "students", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) as $student_id) {
            $admin = new Admin();
            $admin->assign_teacher(filter_input(INPUT_POST, "teacher_id", FILTER_DEFAULT), $student_id);
            unset($admin);
        }
        Structure::successBox("Assign Students", "Succesfully assigned the following student(s) to ".filter_input(INPUT_GET, "teacher_name", FILTER_DEFAULT)."!<br>");
    }
} elseif (Structure::is_int_present(filter_input(INPUT_GET, "teacher_id", FILTER_DEFAULT)) == true) {
    $teacher = new Admin();
    if ($teacher->teacher_exists(filter_input(INPUT_GET, "teacher_id", FILTER_DEFAULT)) === true) {
        $students = $teacher->student_with_no_teacher();
        if (count($students) > 0) {
            echo('<main role="main" class="container mt-3  mx-auto">');
            Structure::topHeading("Assign Teacher");
            echo('<hr>
            <form method="post">
              <input type="hidden" name="teacher_id" value="'.filter_input(INPUT_GET, "teacher_id", FILTER_DEFAULT).'">

              <div class="row">
                <div class="col">
                    <fieldset>
                    <table class="table table-striped table-bordered table-hover">
                    <caption class="text-info">Assign student to <i>'.filter_input(INPUT_GET, "teacher_name", FILTER_DEFAULT).'</i></caption>
                      <thead class="bg-dark text-white">
                        <tr>
                          <th scope="col" style=" width: 10%; ">#</th>
                          <th scope="col">Student Name</th>
                        </tr>
                      </thead>
                      <tbody>');
            foreach ($students as $student) {
                echo('<tr>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="students[]" value="'._esc($student['student_id']).'">
                    </div>
                  </td>
                  <td>'._esc($student['student_name']).'</a></td>
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
                <a class="btn btn-primary btn-small" href="'.Structure::nakedURL("view_teachers.php").'" role="button">Go back!</a>
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
    unset($teacher);
} else {
    Structure::errorBox("Assign Students", "No teacher selected!");
}

Structure::footer();
