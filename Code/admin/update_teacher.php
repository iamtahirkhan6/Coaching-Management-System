<?php
// Import main class
require "../classes/admin.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Update Teacher - Admin");

// Main Content Goes Here
// Check if form submitted
if (Structure::if_all_inputs_exists(array("teacher_id", "teacher_name", "teacher_phone_number", "email", "password"), "POST") == true) {
    $admin = new Admin();

    if (is_bool($admin->update_teacher(
        filer_input(INPUT_POST, "teacher_id", FILTER_DEFAULT),
        filer_input(INPUT_POST, "teacher_name", FILTER_DEFAULT),
        filer_input(INPUT_POST, "teacher_phone_number", FILTER_DEFAULT),
        filer_input(INPUT_POST, "email", FILTER_DEFAULT),
        filer_input(INPUT_POST, "password", FILTER_DEFAULT)
    )) === true) {
        // On success
        Structure::successBox("Update Teacher", "Successfully updated teacher!", Structure::nakedURL("view_teachers.php"));
    } else {
        // On failure
        Structure::errorBox("Update Teacher", "Unable to update teacher!");
    }

    //$admin->close_DB();
} elseif (isset(filer_input(INPUT_GET, "teacher_id", FILTER_DEFAULT)) && !empty(filer_input(INPUT_GET, "teacher_id", FILTER_DEFAULT))) {
    $admin    = new Admin();
    $teacher  = $admin->view_teacher(filer_input(INPUT_GET, "teacher_id", FILTER_DEFAULT), true);

    if (!isset($teacher["teacher_id"])) {
        Structure::errorBox("Update Teacher", "Select a valid teacher!");
    } else {
        // Form to fill details
        echo('<main role="main" class="container mt-3  mx-auto">');
        Structure::topHeading("Update Teacher");
        echo('<hr>
          <form method="POST">
            <input type="hidden" name="teacher_id" value="'._esc($teacher["teacher_id"]).'">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="teacher_name" class="form-control" id="teacher_name" aria-describedby="teacher_name" value="'._esc($teacher["teacher_name"]).'">
            </div>
            <div class="form-group">
              <label for="teacher_phone_number">Phone Number</label>
              <input type="number" name="teacher_phone_number" class="form-control" id="teacher_phone_number" aria-describedby="teacher_phone_number" value="'._esc($teacher["teacher_phone_number"]).'">
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" name="email" class="form-control" id="email" aria-describedby="email" value="'._esc($teacher["email"]).'">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" id="password" value="'._esc($teacher["password"]).'">
            </div>

            <div class="row">
              <div class="col-sm-12">
                  <button type="submit" class="btn btn-success btn-small">Submit</button>
                  <a class="btn btn-primary btn-small" href="'.Structure::nakedURL("view_teachers.php").'" role="button">Go back!</a>
               </div>
            </div>
          </form>
      </main>');
    }

    $admin->close_DB();
} else {
    Structure::errorBox("Update Teacher", "No teacher selected!");
}
// Display Footer
Structure::footer();

// delete object
unset($admin);
