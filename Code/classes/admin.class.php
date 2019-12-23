<?php
require("database.class.php");

class Admin extends Config
{
    //////////////// STUDENT CRUD (creat, read, update, delete) ///////////////
    // CREATE a new student
    public function create_student(array $input)
    {
        // check if items to insert exists in the input array or note
        if (isset($input["student_name"]) && isset($input["student_phone_number"]) && isset($input["email"]) && isset($input["password"]) && strlen($input["password"]) > 5) {
            $insert = $this->db->query("INSERT INTO `student`(`student_name`, `student_phone_number`, `email`, `password`) VALUES (?, ?, ?, ?)", $input["student_name"], $input["student_phone_number"], $input["email"], $input["password"]);

            // if more than 1 row returned then it insertion was successfull
            if ($insert->affectedRows() > 0) {
                return true;
            }
        }

        return false;
    }

    // View all student
    public function view_student($id, $single = false)
    {
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if ($single == true && $id != 0) {
            $insert = $this->db->query("SELECT student.student_id, student.student_name, student.student_phone_number, student.email, student.password FROM student WHERE student.student_id = ?", $id);
        } else {
            $insert = $this->db->query("SELECT DISTINCT level2.student_id, level2.student_name, level2.student_phone_number, level2.email, level2.teacher_name, GROUP_CONCAT(DISTINCT(subject.subject_name) SEPARATOR '<br>') AS subjects FROM (SELECT DISTINCT level.student_id, level.student_name, level.student_phone_number, level.email, level.teacher_name, assigned.subject_id FROM (SELECT DISTINCT student.student_id, student.student_name, student.student_phone_number, student.email, student.teacher_id, teacher.teacher_name FROM student LEFT OUTER JOIN teacher ON student.teacher_id = teacher.teacher_id) level NATURAL LEFT JOIN assigned) level2 NATURAL LEFT JOIN subject GROUP BY level2.student_id ORDER BY level2.student_id ASC");
        }

        if ($insert->numRows() > 0) {
            if ($single == true && $id != 0) {
                $success = $insert->fetchArray();
            } else {
                $success = $insert->fetchAll();
            }
            return $success;
        }

        return $success;
    }

    // UPDATE student
    public function update_student(array $input)
    {
        // check if items to insert exists in the input array or note
        if (isset($input["student_id"]) && isset($input["student_name"]) && isset($input["student_phone_number"]) && isset($input["email"]) && isset($input["password"])) {
            $update = $this->db->query("UPDATE `student` SET `student_name`= ? , `student_phone_number`= ? , `email` = ? , `password` = ? WHERE `student_id` = ? ", $input["student_name"], $input["student_phone_number"], $input["email"], $input["password"], $input["student_id"]);

            // if more than 1 row returned then it insertion was successfull
            return ($update->affectedRows() > 0);
        }

        return false;
    }

    // DELETE student
    public function delete_student($input)
    {
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if (isset($input["student_id"])) {
            $insert = $this->db->query("DELETE FROM `student` WHERE `student_id`=?", $input["student_id"]);

            // if more than 1 row returned then it insertion was successfull
            if ($insert->numRows() > 0) {
                $success = true;
            }
        }

        return $success;
    }

    // Return all students with no teachers for assignment
    public function student_with_no_teacher()
    {
        $success = array(); // variable to return if insertion success or failed

        // check for students with no teachers
        $insert = $this->db->query("SELECT student.student_id, student.student_name FROM student WHERE student.teacher_id = 0 ORDER BY student.student_id ASC");

        if ($insert->numRows() > 0) {
            $success = $insert->fetchAll();
            return $success;
        } else {
            return array();
        }

        return $success;
    }

    public function assign_teacher($teacher_id, $student_id)
    {
        if ($this->teacher_exists($teacher_id) === true) {
            $assign = $this->db->query("UPDATE student SET student.teacher_id = ? WHERE student_id = ?", $teacher_id, $student_id);
            return ($assign->affectedRows() > 0);
        }

        return false;
    }

    //////////////// TEACHER CRUD (creat, read, update, delete) ///////////////
    // CREATE a new teacher
    public function create_teacher($input)
    {
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if (isset($input["teacher_name"]) && isset($input["teacher_phone_number"]) && isset($input["email"]) && isset($input["password"]) && strlen($input["password"]) > 5) {
            $insert = $this->db->query("INSERT INTO `teacher`(`teacher_name`, `teacher_phone_number`, `email`, `password`) VALUES (?, ?, ?, ?)", $input["teacher_name"], $input["teacher_phone_number"], $input["email"], $input["password"]);

            // if more than 1 row returned then it insertion was successfull
            if ($insert->numRows() > 0) {
                $success = true;
            }
        }

        return $success;
    }

    // View teachers
    public function view_teacher($id, $single = false)
    {
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if ($single == true && $id != 0) {
            $view = $this->db->query("SELECT teacher.teacher_id, teacher.teacher_name, teacher.teacher_phone_number, teacher.email, teacher.password FROM teacher WHERE teacher.teacher_id = ?", $id);
        } else {
            /* if no specific teacher given */
            $view = $this->db->query("SELECT level1.*, GROUP_CONCAT(DISTINCT student.student_name SEPARATOR '<br>') AS students FROM (SELECT DISTINCT teacher.teacher_id, teacher.teacher_phone_number, teacher.teacher_name, teacher.email, GROUP_CONCAT(DISTINCT subject.subject_name SEPARATOR ', ') AS subjects FROM teacher LEFT OUTER JOIN subject ON teacher.teacher_id = subject.teacher_id GROUP BY teacher.teacher_id) level1 LEFT OUTER JOIN student ON level1.teacher_id = student.teacher_id GROUP BY level1.teacher_id");
        }

        if ($view->numRows() > 0) {
            if ($single == true && $id != 0) {
                $success = $view->fetchArray();
            } else {
                $success = $view->fetchAll();
            }
            return $success;
        }

        return $success;
    }

    // UPDATE teacher
    public function update_teacher($input)
    {
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if (isset($input["teacher_id"]) && isset($input["teacher_name"]) && isset($input["teacher_phone_number"]) && isset($input["email"]) && isset($input["password"])) {
            $insert = $this->db->query("UPDATE `teacher` SET `teacher_name`=?, `teacher_phone_number`=?, `email`=?, `password`=? WHERE `teacher_id`=?", $input["teacher_name"], $input["teacher_phone_number"], $input["email"], $input["password"], $input["teacher_id"]);

            // if more than 1 row returned then it insertion was successfull
            return ($insert->affectedRows() > 0);
        }

        return $success;
    }

    // DELETE teacher
    public function delete_teacher($input)
    {
        $success = false; // variable to return if insertion success or failed

        // check if items to insert exists in the input array or note
        if (isset($input["teacher_id"])) {
            $insert = $this->db->query("DELETE FROM `teacher` WHERE `teacher_id`=?", $input["teacher_id"]);

            // if more than 1 row returned then it insertion was successfull
            if ($insert->numRows() > 0) {
                $success = true;
            }
        }

        return $success;
    }

    public function teacher_exists($teacher_id)
    {
        // check if input is a correct integer or not
        if (isset($teacher_id) && !empty($teacher_id) && (is_numeric($teacher_id) ? true:false) == true) {
            // check if teacher exists
            $check = $this->db->query("SELECT teacher.teacher_id FROM teacher WHERE teacher.teacher_id = ?", $teacher_id);
            return ($check->numRows() > 0);
        } else {
            return false;
        }
    }

    // Other DB functions
    public function close_DB()
    {
        $this->db->close();
    }
}
