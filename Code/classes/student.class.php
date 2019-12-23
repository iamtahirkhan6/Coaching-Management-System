<?php
require("database.class.php");

class Student extends Config
{
    // Function to list all the Teachers of a student & their subjects
    public function view_teachers()
    {
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        $view = $this->db->query("SELECT DISTINCT level2.student_id, level2.student_name, level2.teacher_name, GROUP_CONCAT(DISTINCT subject.subject_name SEPARATOR ', ') AS subjects FROM (SELECT DISTINCT level.student_id, level.student_name, level.student_phone_number, level.email, level.teacher_name, assigned.subject_id FROM (SELECT DISTINCT student.student_id, student.student_name, student.student_phone_number, student.email, student.teacher_id, teacher.teacher_name FROM student LEFT OUTER JOIN teacher ON student.teacher_id = teacher.teacher_id) level NATURAL LEFT JOIN assigned) level2 NATURAL LEFT JOIN subject WHERE level2.student_id = ? GROUP BY level2.student_id ORDER BY level2.student_id", $_SESSION["id"]);

        if ($view->numRows() > 0) {
            $success = $view->fetchAll();
            return $success;
        }
        return $success;
    }

    // Other DB functions
    public function close_DB()
    {
        $this->db->close();
    }
}
