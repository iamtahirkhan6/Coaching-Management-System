<?php
// Import main class
require "../classes/admin.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Update Student - Admin");

// Main Content Goes Here
// Check if form submitted
if (Structure::if_all_inputs_exists(array("student_id","student_name","student_phone_number","email","password"), "POST") == true) {
    $admin = new Admin();

    if (is_bool($admin->update_student(
        filer_input(INPUT_POST, "student_id", FILTER_DEFAULT),
        filer_input(INPUT_POST, "student_name", FILTER_DEFAULT),
        filer_input(INPUT_POST, "student_phone_number", FILTER_DEFAULT),
        filer_input(INPUT_POST, "email", FILTER_DEFAULT),
        filer_input(INPUT_POST, "password", FILTER_DEFAULT)
    )) === true) {
        // On success
        Structure::successBox("Update Student", "Successfully updated student!", Structure::nakedURL("view_students.php"));
    } else {
        // On failure
        Structure::errorBox("Update Student", "Unable to update student!");
    }

    //$admin->close_DB();
} elseif (isset(filer_input(INPUT_GET, "student_id", FILTER_DEFAULT)) && !empty(filer_input(INPUT_GET, "student_id", FILTER_DEFAULT))) {
    $admin    = new Admin();
    $student = $admin->view_student(filer_input(INPUT_GET, "student_id", FILTER_DEFAULT), true);

    if (!isset($student["student_id"])) {
        Structure::errorBox("Update Student", "Select a valid student!");
    } else {
        // Form to fill details
        echo('<main role="main" class="container mt-3  mx-auto">');
        Structure::topHeading("Update Student");
        echo('<hr>
          <form method="POST">
            <input type="hidden" name="student_id" value="'._esc($student['student_id']).'">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="student_name" class="form-control" id="student_name" aria-describedby="student_name" value="'._esc($student["student_name"]).'">
            </div>
            <div class="form-group">
              <label for="student_phone_number">Phone Number</label>
              <input type="number" name="student_phone_number" class="form-control" id="student_phone_number" aria-describedby="student_phone_number" value="'._esc($student["student_phone_number"]).'">
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" name="email" class="form-control" id="email" aria-describedby="email" value="'._esc($student["email"]).'">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" id="password" value="'._esc($student["password"]).'">
            </div>

            <div class="row">
              <div class="col-sm-12">
                  <button type="submit" class="btn btn-success btn-small">Submit</button>
                  <a class="btn btn-primary btn-small" href="'.Structure::nakedURL("view_students.php").'" role="button">Go back!</a>
               </div>
            </div>
          </form>
      </main>');
    }

    $admin->close_DB();
} else {
    Structure::errorBox("Update Student", "No student selected!");
}
// Display Footer
Structure::footer();

// delete object
unset($admin);
unset($struct);
