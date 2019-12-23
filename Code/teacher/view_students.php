<?php
// Start session
session_start();

// Import main class
require_once "../classes/teacher.class.php";
require_once "../classes/structure.class.php";

// Initialize HTML structure
$struct = new Structure();

// Check if logged in otherwise redirect to login page
$struct->checkLogin();

// Load Header
$struct->header("Home - Teacher Panel");

// Main Content Goes Here
$teacher    = new Teacher();
$students = $teacher->view_students();

echo "<main role=\"main\" class=\"container mx-auto mt-3\">";
$struct->topHeading("My Students");
echo "<hr>
        <table class=\"table table-striped\">
        <caption><a href=\"".$struct->nakedURL("")."\" style=\"text-decoration: none;\">Go back!</a></caption>
        <thead class=\"bg-info text-white\">
          <tr>
            <th scope=\"col\">#</th>
            <th scope=\"col\">Student's Name</th>
            <th scope=\"col\">Subjects</th>
          </tr>
        </thead>
        <tbody>";

$counter = 0;
foreach ($students as $student) {
  $counter++;
  if ($student["subjects"] == "") {
      $student["subjects"] = "<span class=\"text-danger\">None</span>";
  }

echo  "<tr>
        <th scope=\"row\">{$counter}</th>
        <td>{$student['student_name']}</td>
        <td>{$student['subjects']}</td>
      </tr>";
}
echo "</tbody></table></main>";

$teacher->close_DB();

// Display Footer
$struct->footer();

// delete object
unset($teacher);
unset($struct);
