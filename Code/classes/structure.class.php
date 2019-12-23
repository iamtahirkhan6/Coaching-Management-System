<?php

class Session{

    public static function put( $key , $value ){
        $_SESSION[$key] = $value;
    }

    public static function get( $key ){
        return ( isset( $_SESSION[$key] ) ? $_SESSION[$key] : null );
    }

    public static function forget( $key ){
        unset( $_SESSION[$key] );
    }

    public static function isset( $key )
    {
      return ( isset( $_SESSION[$key] ) ) ? TRUE : FALSE;
    }
}

class Structure
{
    // This class contains visual elements which can be initialized for easier access
    // and easier sitewide changes
    public static function checkLogin()
    {
        if ( Session::isset( 'user_logged_type' ) == FALSE ) {
            Structure::redirectHome();
        }
    }

    public static function header( $title )
    {
        $uri   = rtrim( dirname( $_SERVER['PHP_SELF'] ), '/\\' );

        $dot = "";
        if ( Structure::endsWith( $uri, "admin" ) || Structure::endsWith( $uri, "student" ) || Structure::endsWith( $uri, "teacher" ) ) {
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

    public static function footer()
    {
        echo "</body>
        </html>";
    }

    public static function nakedURL( $extra = "" )
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim( dirname( $_SERVER['PHP_SELF'] ), '/\\' );
        return "http://$host$uri/$extra";
    }

    public static function redirect( $extra = "" )
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim( dirname( $_SERVER['PHP_SELF'] ), '/\\' );
        header( "Location: http://$host$uri/$extra" );
    }

    public static function redirectHome()
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim( dirname( $_SERVER['PHP_SELF'] ), '/\\' );

        header( "Location: http://$host".str_replace( array( "admin", "student", "teacher" ), "", $uri ));
    }

    public static function currentURL()
    {
        if ( isset( $_SERVER['HTTPS'] ) &&
            $_SERVER['HTTPS'] === 'on' ) {
            $link = "https";
        } else {
            $link = "http";
        }
        $link .= "://";
        $link .= $_SERVER['HTTP_HOST'];
        $link .= $_SERVER['PHP_SELF'];
        return $link;
    }

    public static function endsWith( $string, $endString )
    {
        $len = strlen( $endString );
        if ( $len == 0 ) {
            return true;
        }
        return ( substr( $string, -$len ) === $endString );
    }

    public static function errorPage( $error )
    {
        Structure::header( "Error - Project" );
        echo "<main role=\"main\" class=\"container mt-3\">
            <h1 class=\"display-4 text\">Error</h1>
            <hr>
            <div class=\"alert alert-danger\" role=\"alert\">";
        echo $error;
        echo "</div>
        </main>";
        Structure::footer();
    }

    public static function errorBox( $title, $error )
    {
        echo "<main role=\"main\" class=\"container mt-3\">
          <h1 class=\"display-4 text\">{$title}</h1>
          <hr>
          <div class=\"alert alert-danger\" role=\"alert\">{$error}</div>
      </main>";
    }

    public static function successBox( $title, $message, $link="" )
    {
        echo "<main role=\"main\" class=\"container mt-3\">
          <h1 class=\"display-4 text\">{$title}</h1>
          <hr>
          <div class=\"alert alert-success\" role=\"alert\">{$message}</div>
          <a class=\"btn btn-primary btn-small\" href=\"{$link}\" role=\"button\">Go back!</a>
      </main>";
    }

    public static function topHeading( $heading )
    {
        $home = str_replace( basename( $_SERVER['PHP_SELF'] ), "", Structure::currentURL() );
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

    public static function is_int_present( $int )
    {
      return ( isset( $int ) && !empty( $int ) && ( is_numeric( $int ) ? true:false ) == true );
    }

    public static function if_input_exists( $key , $type )
    {
      if( $type == "POST" || $type == "post" )
      {
        $key = $_POST[$key];
      } elseif( $type == "GET" || $type == "get" ){
        $key = $_GET[$key];
      } else {
        $key = $_REQUEST[$key];
      }

      return (isset( $key ) && empty( $key )) ? TRUE : FALSE;

    }

    public static function if_all_inputs_exists( array $keys , $type )
    {
      $array = "";
      if( $type == "POST" || $type == "post")
      {
        $array = $_POST;
      } elseif( $type == "GET" || $type == "get"){
        $array = $_GET;
      } else {
        $array = $_REQUEST;
      }

      $count = 0;
      foreach( $keys as $key)
      {
        if ( isset( $array[$key] ) || array_key_exists( $key, $array ) )
        {
          $count ++;
        }
      }

      return count( $keys ) === $count;
    }

    public static function get_input_var( $key, $input_type)
    {
      return filter_input( $input_type, $key, FILTER_DEFAULT);
    }
}
