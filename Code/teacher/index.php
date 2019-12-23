<?php
// Start session
session_start();

// Import main class
require_once "../classes/structure.class.php";

// Initialize HTML structure
$struct = new Structure();

// Check if logged in otherwise redirect to login page
$struct->checkLogin();

// Load Header
$struct->header("Teacher Panel - Project");

// Main Content Goes Here
echo "<main role=\"main\" class=\"container mx-auto mt-3\">";
$struct->topHeading("Teacher Panel");
echo "<hr>
        <div class=\"row\">
            <div class=\"col col-sm-12 col-md-12 \">
                <table class=\"table table-striped table-bordered table-hover\">
                  <thead class=\"bg-info text-white\">
                    <tr>
                      <th scope=\"col\">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href=\"view_students.php\" class=\"text-secondary text-decoration-none\">View Students</a></td>
                    </tr>
                    <tr>
                      <td><a href=\"view_subjects.php\" class=\"text-secondary text-decoration-none\">View Subjects</a></td>
                    </tr>
                    <tr>
                      <td><a href=\"add_subject.php\" class=\"text-secondary text-decoration-none\">Add a new subject</a></td>
                    </tr>
                  </tbody>
                </table>
            </div>

          </div>
        </main>";

// Display Footer
$struct->footer();
