<?php
// Start session
session_start();

// Import main class
require_once "../classes/admin.class.php";
require_once "../classes/structure.class.php";

// Initialize HTML structure
$struct = new Structure();

// Check if logged in otherwise redirect to login page
$struct->checkLogin();

// Load Header
$struct->header("View Students - Admin");

// Main Content Goes Here
$admin    = new Admin();
$students = $admin->view_student(0, false);
echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
echo $struct->topHeading("View Students");
echo "    <hr>
        <table class=\"table table-striped table-hover text-secondary\">
        <caption><a href=\"".$struct->nakedURL("")."\" style=\"text-decoration: none;\">Go back!</a></caption>
        <thead class=\"bg-dark text-white\">
          <tr>
            <th scope=\"col\">#</th>
            <th scope=\"col\">Name</th>
            <th scope=\"col\">Email</th>
            <th scope=\"col\">Phone Number</th>
            <th scope=\"col\">Teacher</th>
            <th scope=\"col\">Subjects</th>
            <th scope=\"col\">Actions</th>
          </tr>
        </thead>
        <tbody>";

$counter = 0;
foreach ($students as $student) {
    $counter++;
    if ($student["subjects"] == "") {
        $student["subjects"] = "<span class=\"text-danger\">None</span>";
    }
    if ($student['teacher_name'] == "") {
        $student['teacher_name'] = "<span class=\"text-danger\">None</span>";
    }

    echo  "<tr>
        <th scope=\"row\">{$counter}</th>
        <td>{$student['student_name']}</td>
        <td>{$student['email']}</td>
        <td>{$student['student_phone_number']}</td>
        <td>{$student['teacher_name']}</td>
        <td>{$student['subjects']}</td>
        <td>
        <div class=\"container\">
            <div class=\"row\">
              <div class=\"col\"><a href=\"update_student.php?student_id={$student["student_id"]}\" alt=\"Edit\"><img src=\"../src/icons/edit-24px.svg\" alt=\"Edit\"></a></div>
              <div class=\"col\"><a href=\"delete_student.php?student_id={$student["student_id"]}\"  alt=\"Delete\"><img src=\"../src/icons/delete-24px.svg\" alt=\"Delete\"></a></div>
            </div>
          </div>
        </td>
      </tr>";
}
echo "</tbody></table></main>";

$admin->close_DB();

// Display Footer
$struct->footer();

// delete object
unset($admin);
unset($struct);
