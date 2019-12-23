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
$struct->header("View Teachers - Admin");

// Main Content Goes Here
$admin    = new Admin();
$teachers = $admin->view_teacher(0, false);
echo "<main role=\"main\" class=\"container mt-3  mx-auto\">";
echo $struct->topHeading("View Teachers");
echo "  <hr>
        <table class=\"table table-striped table-hover text-secondary\">
        <caption><a href=\"".$struct->nakedURL("")."\" style=\"text-decoration: none;\">Go back!</a></caption>
        <thead class=\"bg-dark text-white\">
          <tr>
            <th scope=\"col\">#</th>
            <th scope=\"col\">Name</th>
            <th scope=\"col\">Email</th>
            <th scope=\"col\">Phone Number</th>
            <th scope=\"col\">Subjects</th>
            <th scope=\"col\">Students</th>
            <th scope=\"col\">Actions</th>
          </tr>
        </thead>
        <tbody>";

$counter = 0;
foreach ($teachers as $teacher) {
    $counter++;

    if ($teacher["students"] == "") {
        $teacher["students"] = "<span class=\"text-danger\">None</span>";
    } else {
        $teacher["students"] = str_replace(", ", "<br/>", $teacher["students"]);
    }
    echo   "<tr>
        <th scope=\"row\">{$counter}</th>
        <td>{$teacher['teacher_name']}</td>
        <td>{$teacher['email']}</td>
        <td>{$teacher['teacher_phone_number']}</td>
        <td>{$teacher['subjects']}</td>
        <td>{$teacher['students']}</td>
        <td>
        <div class=\"container\">
            <div class=\"row\">
              <div class=\"col\"><a href=\"update_teacher.php?teacher_id={$teacher["teacher_id"]}\" alt=\"Edit\"><img src=\"../src/icons/edit-24px.svg\" alt=\"Edit\"></a></div>
              <div class=\"col\"><a href=\"assign_teacher.php?teacher_id={$teacher["teacher_id"]}&teacher_name={$teacher['teacher_name']}\" alt=\"ASssign Teacher\"><img src=\"../src/icons/assignment_ind-24px.svg\" alt=\"Assign Teachers\"></a></div>
              <div class=\"col\"><a href=\"delete_teacher.php?teacher_id={$teacher["teacher_id"]}\"  alt=\"Delete\"><img src=\"../src/icons/delete-24px.svg\" alt=\"Delete\"></a></div>
            </div>
          </div>
        </td>
      </tr>";
}
echo "  </tbody>
        </table>
        </main>";
$admin->close_DB();

// Display Footer
$struct->footer();

// delete object
unset($admin);
unset($struct);
