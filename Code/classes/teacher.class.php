<?php
require("database.class.php");

class Teacher extends Config
{
    // Function to list all the STUDENTS of a teacher & their subjects
    public function view_students()
    {
        $teacher_id = $_SESSION["id"];
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if (isset($teacher_id) && $teacher_id != 0 && (is_numeric($teacher_id) ? true:false) == true) {
            $view = $this->db->query("SELECT student_2.student_id, student_2.student_name, student_2.teacher_id, GROUP_CONCAT(DISTINCT subject.subject_name SEPARATOR ', ') AS subjects FROM (SELECT student.student_id, student.student_name, student.teacher_id, assigned.subject_id FROM student NATURAL LEFT JOIN assigned WHERE student.teacher_id = ?) student_2 LEFT OUTER JOIN subject ON student_2.subject_id = subject.subject_id GROUP BY student_2.student_id", $teacher_id);

            if ($view->numRows() > 0) {
                $success = $view->fetchAll();
                return $success;
            }
        }
        return $success;
    }

    // Function to list all the SUBJECTS by a teacher
    public function view_subjects()
    {
        $teacher_id = $_SESSION["id"];
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if (isset($teacher_id) && $teacher_id != 0 && (is_numeric($teacher_id) ? true:false) == true) {
            $view = $this->db->query("SELECT * FROM subject WHERE subject.teacher_id = ? ORDER BY subject.subject_ID ASC", $teacher_id);

            if ($view->numRows() > 0) {
                $success = $view->fetchAll();
                return $success;
            }
        }
        return $success;
    }

    // Function to get the information of a subject
    public function view_subject_info($subject_id)
    {
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if (isset($subject_id) && $subject_id != 0 && (is_numeric($subject_id) ? true:false) == true) {
            $view = $this->db->query("SELECT subject.subject_id, subject.subject_name FROM subject WHERE subject.subject_id = ? AND subject.teacher_id = ? LIMIT 1", $subject_id, $_SESSION["id"]);

            if ($view->numRows() > 0) {
                $success = $view->fetchArray();
                return $success;
            }
        }
        return $success;
    }

    // Function to create a new subject
    public function create_subject($subject_name)
    {
        // check if subject names to insert exists
        if (isset($subject_name) && !empty($subject_name) && strlen($subject_name) > 1) {
            $insert = $this->db->query("INSERT INTO `subject`(`subject_name`, `teacher_id`) VALUES (?, ?)", $subject_name, $_SESSION["id"]);

            // if more than 1 row returned then it insertion was successfull
            if ($insert->affectedRows() > 0) {
                return true;
            }
        }

        return false;
    }

    //  Function to update subjects
    public function update_subject($subject_name, $subject_id)
    {
        // check if items to insert exists in the input array or note
        if (isset($subject_id) && isset($subject_name)) {
            $update = $this->db->query("UPDATE subject SET subject_name = ? WHERE subject_id = ? AND teacher_id = ?", $subject_name, $subject_id, $_SESSION["id"]);

            // if more than 1 row returned then it insertion was successfull
            return ($update->affectedRows() > 0);
        }

        return false;
    }

    // Function to find out if subject exists
    public function subject_exists($subject_id)
    {
        // check if input is a correct integer or not
        if (isset($subject_id) && !empty($subject_id) && (is_numeric($subject_id) ? true:false) == true) {
            // check if teacher exists
            $check = $this->db->query("SELECT subject.subject_id FROM subject WHERE subject.subject_id = ? AND subject.teacher_id = ?", $subject_id, $_SESSION["id"]);
            return ($check->numRows() > 0);
        } else {
            return false;
        }
    }

    // Function to recieve all the students that are to be assigned
    public function subject_sort($subject_id)
    {
        $all_students = false; // variable to return if insertion success or failed

        $all_students = array();
        $all_students["all"] = array();
        $all_students["already_assigned"] = array();

        // check if items to insert exists in the input array or note
        if (isset($subject_id) && $subject_id != 0 && (is_numeric($subject_id) ? true:false) == true) {
            $view = $this->db->query("SELECT student.student_id, student.student_name FROM student WHERE student.teacher_id = ?", $_SESSION["id"]);
            if ($view->numRows() > 0) {
                $all_students["all"] = $view->fetchAll();
                $already_assigned = $this->db->query("SELECT GROUP_CONCAT(assigned.student_id) AS id FROM assigned WHERE assigned.teacher_id = ? AND assigned.subject_id = ?", $_SESSION["id"], $subject_id);
                if ($already_assigned->numRows() > 0) {
                    $all_students["already_assigned"] = $already_assigned->fetchArray();
                }

                $already_assigned_students = explode(",", $all_students["already_assigned"]["id"]);
                foreach ($all_students["all"] as $key => $value) {
                    if (in_array($value["student_id"], $already_assigned_students)) {
                        $all_students["all"][$key]["assigned"] = "true";
                    } else {
                        $all_students["all"][$key]["assigned"] = "false";
                    }
                }
                $all_students = $all_students["all"];




                return $all_students;
            }
        }
        return $all_students;
    }

    // Function to assign teacher to multiple students
    public function assign_teacher($students, $subject_id)
    {
        // check if items to insert exists in the input array or note
        if (isset($students)) {
            $delete = $this->db->query("DELETE FROM assigned WHERE teacher_id = ? AND subject_id = ?", $_SESSION["id"], $subject_id);
            $delete = $delete->affectedRows();

            if (count($students) > 0) {
                foreach ($students as $key => $student_id) {
                    $update = $this->db->query("INSERT INTO assigned (`student_id`, `subject_id`, `teacher_id`) VALUES (?,?,?)", $student_id, $subject_id, $_SESSION["id"]);
                    $update = $update->affectedRows();
                }
            }
            return true;
        }

        return false;
    }

    // Other DB functions
    public function close_DB()
    {
        $this->db->close();
    }
}
