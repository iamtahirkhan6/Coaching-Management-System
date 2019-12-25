<?php
// Import main class
require "../classes/admin.class.php";
require "../classes/structure.class.php";

// Start session
Session::init();

// Check if logged in otherwise redirect to login page
Structure::checkLogin();

// Load Header
Structure::header("View Students - Admin");

// Main Content Goes Here
$admin    = new Admin();
$students = $admin->view_student(0, false);
echo('<main role="main" class="container mt-3  mx-auto">');
Structure::topHeading("View Students");
echo('<hr>
        <table class="table table-striped table-hover text-secondary">
        <caption><a href="'.Structure::nakedURL("").'" style="text-decoration: none;">Go back!</a></caption>
        <thead class="bg-dark text-white">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Teacher</th>
            <th scope="col">Subjects</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>');

$counter = 0;
foreach ($students as $student) {
    $counter++;
    if ($student["subjects"] == "") {
        $student["subjects"] = "<span class='text-danger'>None</span>";
    }
    if ($student['teacher_name'] == "") {
        $student['teacher_name'] = "<span class='text-danger'>None</span>";
    }

    echo('<tr>
        <th scope="row">'._esc($counter).'</th>
        <td>'._esc($student["student_name"]).'</td>
        <td>'._esc($student["email"]).'</td>
        <td>'._esc($student["student_phone_number"]).'</td>
        <td>'._esc($student["teacher_name"]).'</td>
        <td>'._esc($student["subjects"]).'</td>
        <td>
        <div class="container">
            <div class="row">
              <div class="col"><a href="update_student.php?student_id='._esc($student["student_id"]).'" alt="Edit"><img src="../src/icons/edit-24px.svg" alt="Edit"></a></div>
              <div class="col"><a href="delete_student.php?student_id='._esc($student["student_id"]).'"  alt="Delete"><img src="../src/icons/delete-24px.svg" alt="Delete"></a></div>
            </div>
          </div>
        </td>
      </tr>');
}
echo('</tbody></table></main>');

$admin->close_DB();

// Display Footer
Structure::footer();

// delete object
unset($admin);
