<?php
// Start session
session_start();

// Import main class
require_once "../classes/student.class.php";
require_once "../classes/structure.class.php";

// Initialize HTML structure
$struct = new Structure();

// Check if logged in otherwise redirect to login page
$struct->checkLogin();

// Load Header
$struct->header("View Teachers - Student Panel");

// Main Content Goes Here
$student  = new Student();
$teachers = $student->view_teachers();
echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
echo $struct->topHeading("My Teachers");
echo "  <hr>
        <table class=\"table table-striped table-hover text-secondary\">
        <caption><a href=\"".$struct->nakedURL("")."\" style=\"text-decoration: none;\">Go back!</a></caption>
        <thead class=\"bg-dark text-white\">
          <tr>
            <th scope=\"col\">#</th>
            <th scope=\"col\">Name</th>
            <th scope=\"col\">Subjects</th>
          </tr>
        </thead>
        <tbody>";

$counter = 0;
foreach ($teachers as $teacher) {
    $counter++;
    echo   "<tr>
        <th scope=\"row\">{$counter}</th>
        <td>{$teacher['teacher_name']}</td>
        <td>{$teacher['subjects']}</td>
      </tr>";
}
echo "  </tbody>
        </table>
        </main>";
$student->close_DB();

// Display Footer
$struct->footer();

// delete object
unset($student);
unset($struct);
