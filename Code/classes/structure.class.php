<?php
class Structure
{
    // This class contains visual elements which can be initialized for easier access
    // and easier sitewide changes
    public function checkLogin()
    {
        if (!isset($_SESSION["user_logged_type"])) {
            $this->redirectHome();
        }
    }

    public function header($title)
    {
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        $dot = "";
        if ($this->endsWith($uri, "admin") || $this->endsWith($uri, "student") || $this->endsWith($uri, "teacher")) {
            $dot = "../";
        }

        echo "<html lang=\"en\">
          <head>
          <title>".$title."</title>

          <!-- Bootstrap core CSS -->
          <link href=\"{$dot}src/css/bootstrap.min.css\" rel=\"stylesheet\">
          <meta name=\"theme-color\" content=\"#563d7c\">

          <style>
          .bd-placeholder-img {
          font-size: 1.125rem;
          text-anchor: middle;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          }

          @media (min-width: 768px) {
          .bd-placeholder-img-lg {
          font-size: 3.5rem;
          }
          }
          </style>
          <!-- Custom styles for this template -->
          <link href=\"src/css/signin.css\" rel=\"stylesheet\">
          </head>
          <body class=\"\">";
    }

    public function footer()
    {
        echo "</body>
        </html>";
    }

    public function nakedURL($extra = "")
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        return "http://$host$uri/$extra";
    }

    public function redirect($extra = "")
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$extra");
    }

    public function redirectHome()
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        header("Location: http://$host".str_replace(array("admin", "student", "teacher"), "", $uri));
    }

    public function currentURL()
    {
        if (isset($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] === 'on') {
            $link = "https";
        } else {
            $link = "http";
        }
        $link .= "://";
        $link .= $_SERVER['HTTP_HOST'];
        $link .= $_SERVER['PHP_SELF'];
        return $link;
    }

    public function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }

    public function errorPage($error)
    {
        $this->header("Error - Project");
        echo "<main role=\"main\" class=\"container mt-3\">
            <h1 class=\"display-4 text\">Error</h1>
            <hr>
            <div class=\"alert alert-danger\" role=\"alert\">";
        echo $error;
        echo "</div>
        </main>";
        $this->footer();
    }

    public function errorBox($title, $error)
    {
        echo "<main role=\"main\" class=\"container mt-3\">
          <h1 class=\"display-4 text\">{$title}</h1>
          <hr>
          <div class=\"alert alert-danger\" role=\"alert\">{$error}</div>
      </main>";
    }

    public function successBox($title, $message, $link="")
    {
        echo "<main role=\"main\" class=\"container mt-3\">
          <h1 class=\"display-4 text\">{$title}</h1>
          <hr>
          <div class=\"alert alert-success\" role=\"alert\">{$message}</div>
          <a class=\"btn btn-primary btn-small\" href=\"{$link}\" role=\"button\">Go back!</a>
      </main>";
    }

    public function topHeading($heading)
    {
        $home = str_replace(basename($_SERVER['PHP_SELF']), "", $this->currentURL());
        echo "<div class=\"row\">
        <div class=\"col col-sm-10\">
          <h1 class=\"\">{$heading}</h1>
        </div>
        <div class=\"col col-sm-1 pt-3\">
          <a href=\"{$home}\" class=\"text-primary\"><h6>Home</h6></a>
        </div>
        <div class=\"col col-sm-1 pt-3\">
          <a href=\"../logout.php\" class=\"text-danger\"><h6>Logout</h6></a>
        </div>
      </div>";
    }

    public function is_int_present($int)
    {
      return (isset($int) && !empty($int) && (is_numeric($int) ? true:false) == true);
    }
}
