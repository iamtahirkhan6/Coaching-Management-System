<?php
// Import main class
require "../classes/admin.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Add Teacher - Admin");

// Main Content Goes Here
// Check if form submitted
if (Structure::if_all_inputs_exists(array("teacher_name", "teacher_phone_number", "email", "password"), "POST") == true) {
    $admin = new Admin();
    if (is_bool($admin->create_teacher(
        filter_input(INPUT_POST, "teacher_name", FILTER_DEFAULT),
        filter_input(INPUT_POST, "teacher_phone_number", FILTER_DEFAULT),
        filter_input(INPUT_POST, "email", FILTER_DEFAULT),
        filter_input(INPUT_POST, "password", FILTER_DEFAULT)
    )) === true) {
        // On success
        Structure::successBox("Add teacher", "Successfully added teacher!", $struct->nakedURL("view_teachers.php"));
    } else {
        // On failure
        Structure::errorBox("Add teacher", "Unable to add a teacher!");
    }
    $admin->close_DB();
} else {

  // Form to fill details
    echo('<main role="main" class="container mt-3 mx-auto">');
    Structure::topHeading("Add Teacher");
    echo('<hr>
          <form method="POST">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="teacher_name" class="form-control" id="teacher_name" aria-describedby="teacher_name">
            </div>
            <div class="form-group">
              <label for="teacher_phone_number">Phone Number</label>
              <input type="number" name="teacher_phone_number" class="form-control" id="teacher_phone_number" aria-describedby="teacher_phone_number">
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" name="email" class="form-control" id="email" aria-describedby="email">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" id="password">
            </div>

            <div class="row">
              <div class="col-sm-12">
                  <button type="submit" class="btn btn-success btn-small">Submit</button>
                  <a class="btn btn-primary btn-small" href="'.Structure::nakedURL("").'" role="button">Go back!</a>
               </div>
            </div>
          </form>
      </main>');
}
// Display Footer
Structure::footer();

// delete object
unset($admin);
