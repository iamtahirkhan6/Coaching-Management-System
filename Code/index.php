<?php
// Import main class
require "classes/admin.class.php";
require "classes/structure.class.php";

// Start session
Session::init();

// Check if any type of user is logged in
if (Session::isset('user_logged_type') == false) {
    if (Structure::if_all_inputs_exists(array("user_type", "email", "password"), "POST") == true) {
        $activity = new Activity();
        $is_login = $activity->login(filter_input(INPUT_POST, "user_type", FILTER_DEFAULT), filter_input(INPUT_POST, "email", FILTER_DEFAULT), filter_input(INPUT_POST, "password", FILTER_DEFAULT));
        Structure::redirect(Session::get('user_logged_type')."/");
    } else {
        Structure::header("Login");

        print_r('<main role="main" class="container mt-3">
        <div class="row justify-content-md-center">
              <img class="mb-4" src="src/img/login.png" width="72" height="72">
        </div>
        <div class="row">
          <form action="'.filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL).'" method="post" class="form-signin">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <div class="form-group">
              <select class="form-control" name="user_type" id="user_type" style="height: calc(2.5rem + 2px);">
                <option value="admin">Admin</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
              </select>
            </div>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
            <br>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
          </form>
        </div>
      </main>');
        Structure::footer();
    }
} else {
    Structure::redirect(Session::get('user_logged_type')."/");
}
