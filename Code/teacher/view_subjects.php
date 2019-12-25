<?php
// Import main class
require "../classes/teacher.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("View Subjects - Teacher Panel");

// Main Content Goes Here
$teacher    = new Teacher();
$subjects = $teacher->view_subjects();

echo('<main role="main" class="container mx-auto mt-3">');
Structure::topHeading("My Subjects");
echo('<hr>
        <table class="table table-striped">
        <caption><a href="'.Structure::nakedURL("").'" style="text-decoration: none;">Go back!</a></caption>
        <thead class="bg-info text-white">
          <tr>
            <th scope="col" style="width:10%;">#</th>
            <th scope="col">Subject Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>');

$counter = 0;
foreach ($subjects as $subject) {
    $counter++;
    echo('<tr>
        <th scope="row">'._esc($counter).'</th>
        <td>'._esc($subject['subject_name']).'</td>
        <td>
        <div class="container">
            <div class="row w-25">
              <div class="col w-25"><a href="edit_subject.php?subject_id='._esc($subject["subject_id"]).'" alt="Edit"><img src="../src/icons/edit-24px.svg" alt="Edit"></a></div>
              <div class="col w-25"><a href="assign_subjects.php?subject_id='._esc($subject["subject_id"]).'&subject_name='._esc($subject["subject_name"]).'" alt="Assign Subjects"><img src="../src/icons/assignment_ind-24px.svg" alt="Assign Subjects"></a></div>
            </div>
          </div>
        </td>
      </tr>');
}
echo "</tbody></table></main>";

$teacher->close_DB();

// Display Footer
Structure::footer();

// delete object
unset($teacher);
