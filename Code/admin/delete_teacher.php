<?php
// Import main class
require "../classes/admin.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Delete Teacher - Admin");

// Main Content Goes Here
// Check if form submitted
if (Structure::if_all_inputs_exists(array("teacher_id", "delete_confirm"), "POST") == true && filter_input(INPUT_POST, "delete_confirm", FILTER_DEFAULT) == "yes") {
    $admin = new Admin();

    if (is_bool($admin->delete_teacher(filter_input(INPUT_POST, "teacher_id", FILTER_DEFAULT))) === true) {
        // On success
        Structure::successBox("Delete Teacher", "Successfully deleted teacher!", Structure::nakedURL("view_teachers.php"));
    } else {
        // On failure
        Structure::errorBox("Delete Teacher", "Unable to delete teacher!");
    }

    //$admin->close_DB();
} elseif (isset(filter_input(INPUT_GET, "teacher_id", FILTER_DEFAULT)) && !empty(filter_input(INPUT_GET, "teacher_id", FILTER_DEFAULT))) {
    $admin    = new Admin();
    $teacher = $admin->view_teacher(filter_input(INPUT_GET, "teacher_id", FILTER_DEFAULT), true);

    if (!isset($teacher["teacher_id"])) {
        Structure::errorBox("Delete Teacher", "Select a valid teacher!");
    } else {
        // Form to fill details
        echo('<main role="main" class="container mt-3  mx-auto">');
        Structure::topHeading("Delete Teacher");
        echo('<hr>
        <div class="d-flex justify-content-center pb-4"> <img src="../src/img/delete.png" style="width: 15%;height: 15%;"></div>
        <div class="d-flex justify-content-center">Are you sure you want to delete&nbsp;<b>'._esc($teacher["teacher_name"]).'</b>?</div>
        <br>
        <div class="row justify-content-center">
        <form method="POST">
          <div class="">
              <input type="hidden" name="teacher_id" value="'._esc($teacher["teacher_id"]).'">
              <input type="hidden" name="delete_confirm" value="yes">
              <button type="submit" class="btn btn-danger btn-small">Yes</button>
              <a class="btn btn-success btn-small" href="'.Structure::nakedURL("view_teachers.php").'">No</a>
           </div>
        </form>
        </div>
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
