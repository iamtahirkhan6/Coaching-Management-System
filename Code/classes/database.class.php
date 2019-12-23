<?php
class DB
{
    // DB class file (Used from - https://codeshack.io/super-fast-php-mysql-database-class/)
    protected $connection;
    protected $query;
    public $query_count = 0;

    public function __construct($dbhost = 'localhost', $dbuser = 'root', $dbpass = '', $dbname = '', $charset = 'utf8')
    {
        $this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($this->connection->connect_error) {
            $struct = new Structure();
            echo($struct->errorPage('Failed to connect to MySQL - ' . $this->connection->connect_error));
            unset($struct);
            die();
        }
        $this->connection->set_charset($charset);
    }

    public function query($query)
    {
        if ($this->query = $this->connection->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
                $types = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        foreach ($args[$k] as $j => &$a) {
                            $types .= $this->_gettype($args[$k][$j]);
                            $args_ref[] = &$a;
                        }
                    } else {
                        $types .= $this->_gettype($args[$k]);
                        $args_ref[] = &$arg;
                    }
                }
                array_unshift($args_ref, $types);
                call_user_func_array(array($this->query, 'bind_param'), $args_ref);
            }
            $this->query->execute();
            if ($this->query->errno) {
                $struct = new Structure();
                echo($struct->errorPage('Unable to process MySQL query (check your params) - ' . $this->query->error));
                unset($struct);
                die();
            }
            $this->query_count++;
        } else {
            echo('Unable to prepare statement (check your syntax) - ' . $this->connection->error);
        }
        return $this;
    }

    public function fetchAll()
    {
        $params = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            $r = array();
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }
            $result[] = $r;
        }
        $this->query->close();
        return $result;
    }

    public function fetchArray()
    {
        $params = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            foreach ($row as $key => $val) {
                $result[$key] = $val;
            }
        }
        $this->query->close();
        return $result;
    }

    public function numRows()
    {
        $this->query->store_result();
        return $this->query->num_rows;
    }

    public function close()
    {
        return $this->connection->close();
    }

    public function affectedRows()
    {
        return $this->query->affected_rows;
    }

    private function _gettype($var)
    {
        if (is_string($var)) {
            return 's';
        }
        if (is_float($var)) {
            return 'd';
        }
        if (is_int($var)) {
            return 'i';
        }
        return 'b';
    }
}

class Config
{
    protected $dbhost       = "localhost";
    protected $dbuser       = "root";
    protected $dbpass       = "";
    protected $dbname       = "myrl";

    protected $admin_email    = "admin@gmail.com";
    protected $admin_password = "123x123x";

    protected $db;
    public function __construct()
    {
        $this->db = new DB($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
    }
}

class Activity extends Config
{
    public function login($userType, $email, $password)
    {
        $response = false;
        if ((isset($userType)) && (isset($email)) && (isset($password))) {
            if ($userType == "teacher" || $userType == "student") {
                $primary_key = "";
                switch ($userType) {
          case "teacher":
            $primary_key = "teacher_id";
            break;

          case "student":
            $primary_key = "student_id";
            break;
        }

                $account = $this->db->query("SELECT ".$primary_key." FROM ".$userType." WHERE `email` = ? AND `password` = ?", $email, $password);

                if ($account->numRows() > 0) {
                    $return                        = $account->fetchArray();
                    $_SESSION["user_logged_type"]  = $userType;
                    $_SESSION["id"]                = $return[$primary_key];
                    $response                      = true;
                }
            } elseif ($userType == "admin") {
                if ($email == $this->admin_email && $password == $this->admin_password) {
                    $_SESSION["user_logged_type"] = "admin";
                    $response                     = true;
                }
            }
        }
        return $response;
    }
}
