<?php
// Import main class
require "../classes/admin.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Add Student - Admin");

// Main Content Goes Here
// Check if form submitted
if (Structure::if_all_inputs_exists(array("student_name", "student_phone_number", "email", "password"), "POST") == true) {
    $admin = new Admin();
    if (is_bool($admin->create_student(
        filter_input(INPUT_POST, "student_name", FILTER_DEFAULT),
        filter_input(INPUT_POST, "student_phone_number", FILTER_DEFAULT),
        filter_input(INPUT_POST, "email", FILTER_DEFAULT),
        filter_input(INPUT_POST, "password", FILTER_DEFAULT)
    )) === true) {
        // On success
        Structure::successBox("Add Student", "Successfully added student!", Structure::nakedURL("view_students.php"));
    } else {
        // On failure
        Structure::errorBox("Add Student", "Unable to add a student!");
    }
    $admin->close_DB();
} else {

  // Form to fill details
    echo('<main role="main" class="container mx-auto mt-3">');
    Structure::topHeading("Add Student");
    echo('<hr>
          <form method="POST">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="student_name" class="form-control" id="student_name" aria-describedby="student_name">
            </div>
            <div class="form-group">
              <label for="student_phone_number">Phone Number</label>
              <input type="number" name="student_phone_number" class="form-control" id="student_phone_number" aria-describedby="student_phone_number">
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
                  <a class="btn btn-primary btn-small" href="'.Structure::nakedURL("view_students.php").'" role="button">Go back!</a>
               </div>
            </div>
          </form>
      </main>');
}
// Display Footer
Structure::footer();

// delete object
unset($admin);
