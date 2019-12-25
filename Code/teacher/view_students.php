<?php
// Import main class
require "../classes/teacher.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("Home - Teacher Panel");

// Main Content Goes Here
$teacher    = new Teacher();
$students = $teacher->view_students();

echo('<main role="main" class="container mx-auto mt-3">');
Structure::topHeading("My Students");
echo('<hr>
        <table class="table table-striped">
        <caption><a href="'.Structure::nakedURL("").'" style="text-decoration: none;">Go back!</a></caption>
        <thead class="bg-info text-white">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Student\'s Name</th>
            <th scope="col">Subjects</th>
          </tr>
        </thead>
        <tbody>');

$counter = 0;
foreach ($students as $student) {
    $counter++;
    if ($student["subjects"] == "") {
        $student["subjects"] = "<span class='text-danger'>None</span>";
    }

    echo('<tr>
        <th scope="row">'._esc($counter).'</th>
        <td>'._esc($student["student_name"]).'</td>
        <td>'._esc($student["subjects"]).'</td>
      </tr>');
}
echo "</tbody></table></main>";

$teacher->close_DB();

// Display Footer
Structure::footer();

// delete object
unset($teacher);
