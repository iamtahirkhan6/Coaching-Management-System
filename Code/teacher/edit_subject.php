<?php
// Import main class
require "../classes/teacher.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Edit Subject - Admin");

// Main Content Goes Here
// Check if form submitted
if (isset(filter_input(INPUT_POST, "subject_name", FILTER_DEFAULT))) {
    $teacher = new Teacher();

    if (is_bool($teacher->update_subject(filter_input(INPUT_POST, "subject_name", FILTER_DEFAULT), filter_input(INPUT_GET, "subject_id", FILTER_DEFAULT))) === true) {
        // On success
        Structure::successBox("Update Subject", "Successfully updated subject!", Structure::nakedURL("view_subjects.php"));
    } else {
        // On failure
        Structure::errorBox("Update Subject", "Unable to update subject!");
    }

    //$admin->close_DB();
} elseif (isset(filter_input(INPUT_GET, "subject_id", FILTER_DEFAULT))) {
    $teacher = new Teacher();
    $subject = $teacher->view_subject_info(filter_input(INPUT_GET, "subject_id", FILTER_DEFAULT), true);

    if (count($subject) <= 0) {
        Structure::errorBox("Update Subject", "Select a valid subject!");
    } else {
        // Form to fill details
        echo('<main role="main" class="container mt-3  mx-auto">');
        Structure::topHeading("Update Subject");
        echo('<hr>
          <form method="POST">
            <div class="form-group">
              <label for="name">Subject Name</label>
              <input type="text" name="subject_name" class="form-control" id="subject_name" aria-describedby="subject_name" value="'._esc($subject["subject_name"]).'">
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

    $teacher->close_DB();
} else {
    Structure::errorBox("Update Subject", "No subject selected!");
}
// Display Footer
Structure::footer();

// delete object
unset($teacher);
