<?php
// Import main class
require "../classes/teacher.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Add Subject - Teacher Panel");

// Main Content Goes Here
// Check if form submitted
if (isset(filter_input(INPUT_POST, "subject_name", FILTER_DEFAULT))) {
    $teacher = new Teacher();
    if (is_bool($teacher->create_subject(filter_input(INPUT_POST, "subject_name", FILTER_DEFAULT)) === true) {
        // On success
        Structure::successBox("Add Subject", "Successfully created subject!", Structure::nakedURL("view_subjects.php"));
    } else {
        // On failure
        Structure::errorBox("Add Subject", "Unable to add subject!");
    }
    $teacher->close_DB();
} else {

  // Form to fill details
    echo('<main role="main" class="container mx-auto mt-3">');
    Structure::topHeading("Add Subject");
    echo('<hr>
          <form method="POST">
            <div class="form-group">
              <label for="name">Subject Name</label>
              <input type="text" name="subject_name" class="form-control" id="subject_name" aria-describedby="subject_name">
            </div>
            <div class="row">
              <div class="col-sm-12">
                  <button type="submit" class="btn btn-success btn-small">Submit</button>
                  <a class="btn btn-primary btn-small" href="'.Structure::nakedURL("view_subjects.php").'" role="button">Go back!</a>
               </div>
            </div>
          </form>
      </main>');
}
// Display Footer
Structure::footer();

// delete object
unset($teacher);
