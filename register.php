<?php
    /*
    authors: julian.samek, isaac.ng, alex.kazakov, simon.osak
    date: 2016-05-16
    version: 1.0.0
    register.php: allows you to register - takes an email, username, and password
    Provides useful advice in cases of failed registration and a secure system using salts
    */
?>

<html>
    <head>
        <!-- this imports all of our CSS -->
        <link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
        <!-- this imports all of our CSS -->
		<script src="Resources/JS/jquery.js"/></script>
		<script src="Resources/JS/bootstrap.js"/></script>
        <script src="Resources/JS/script.js"/></script>
    </head>

    <body background="Resources/Images/background.jpg" bgproperties="fixed">
        <nav class="navbar navbar-light bg-faded" id="navbar-main">
			<a class="navbar-brand" href="home.php">Tweetter</a>
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="help.php">Help</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="developers.php">Developers</a>
                </li>
            </ul>
            <a class="btn btn-primary-outline pull-xs-right" id="register-btn" href="login.php">Login</a>
		</nav>

        <div class="container-fluid">
            <div class="card">
                <h3 class="card-header bg-info text-xs-center">Register</h3>
                <form action="register.php" method="post">
                    <div class="card-block">
                        <?php
                            // if the login has not failed, then just return the forms as normal - email, username, and password
                            if (!isset($_GET['failed'])) {
                                echo '<fieldset class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="text" name="email" placeholder="ex. john.smith@gmail.com"/>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label>Username</label>
                                        <input class="form-control" type="text" name="username" id="username" placeholder="ex. John Smith"/>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" type="password" name="password" placeholder="ex. Password"/>
                                    </fieldset>';
                            // if it has failed, customize the forms
                            } else {
                                // create a list of the reasons it failed
                                $failedList = explode('-', $_GET['failed']);
                                // if they entered a fake email, then echo the email form with the danger class and a nice message
                                if (in_array("email_fake", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Email</label>
                                            <input class="form-control form-control-danger" type="text" name="email" placeholder="ex. john.smith@gmail.com"/>
                                            <label class="form-control-label small">That is not a valid email address. Please choose a different one.</label>
                                        </fieldset>';
                                // if the email is already in use, once again add the danger form and tell the user their email is already in use
                                } else if (in_array("email_used", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Email</label>
                                            <input class="form-control form-control-danger" type="text" name="email" placeholder="ex. john.smith@gmail.com"/>
                                            <label class="form-control-label small">That email address is already in use. Please choose a different one.</label>
                                        </fieldset>';
                                // otherwise, echo the normal email form, using the value they entered last time for the new value
                                } else {
                                    echo '<fieldset class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" name="email" value='.$_GET["email"].'>
                                        </fieldset>';
                                }

                                // if the username was left empty, make the form red and tell the user below
                                if (in_array("username_empty", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Username</label>
                                            <input class="form-control form-control-danger" type="text" name="username" placeholder="ex. John Smith"/>
                                            <label class="form-control-label small">Please enter a username.</label>
                                        </fieldset>';
                                // if the username is already in use, make the form red and tell the user below
                                } else if (in_array("username_used", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Username</label>
                                            <input class="form-control form-control-danger" type="text" name="username" placeholder="ex. John Smith"/>
                                            <label class="form-control-label small">That username address is already in use. Please choose a different one.</label>
                                        </fieldset>';
                                // otherwise, return the form as normal with the pre-entered username value as the current value
                                } else {
                                    echo '<fieldset class="form-group">
                                            <label>Username</label>
                                            <input class="form-control" type="text" name="username" value='.$_GET["username"].'>
                                        </fieldset>';
                                }

                                // if the password was left empty, add the danger class and tell the user to enter a password
                                if (in_array("password_empty", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Password</label>
                                            <input class="form-control form-control-danger" type="password" name="password" placeholder="ex. Password"/>
                                            <label class="form-control-label small">Please enter a password.</label>
                                        </fieldset>';
                                // otherwise echo the form in normal colours without a message, bu make them retype the password for security reasons
                                } else {
                                    echo '<fieldset class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" type="password" name="password" placeholder="ex. Password"/>
                                        </fieldset>';
                                }
                            }
                        ?>
                    </div>

                    <div class="card-footer bg-faded text-xs-center" id="login-btn">
                        <input class="btn btn-info" type="submit" value="Register"/>
                    </div>
                </form>
            </div>
        </div>

        <?php
            // pass in some data such as the database
            require("common.php");

            // if they have enterd anything at all in the forms
            if(!empty($_POST)) {
                // set a string including the reasons the registration has failed
                $failed = "";
                // if they didn't enter a username, add that to the reasons for failing
                if(empty($_POST['username'])) {
                    $failed = $failed."username_empty-";
                }
                // if they didn't enter a passowrd, add that to the reasons for failing
                if(empty($_POST['password'])) {
                    $failed = $failed."password_empty-";
                }
                // if they didn't enter a valid email address, add that to the reasons for failing
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $failed = $failed."email_fake-";
                }

                // SQL code to select from the table users where the username is the entered username
                $query = "SELECT 1 FROM users WHERE username = :username";
                $query_params = array(':username' => $_POST['username']);

                // try to run the sql query with its parameters
                try {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                } catch(PDOException $ex) {
                    die ("Failed to run query: " . $ex->getMessage());
                }

                // if $row is true, then the username is already used
                $row = $stmt->fetch();
                if($row) {
                    $failed = $failed."username_used-";
                }

                // do the same thing as above, but this time with the email address
                // return a rwo where the email is the entered email
                $query = "SELECT 1 FROM users WHERE email = :email";
                $query_params = array(':email' => $_POST['email']);

                // try to run the query
                try {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                } catch(PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }

                $row = $stmt->fetch();
                // if $row is true, the email address is already in use, so add that to the reasons for failing
                if($row) {
                    $failed = $failed."email_used-";
                }

                // if the list of reasons for failing is not blank, then registration failed
                if ($failed != "") {
                    // reload the page with new $_GET values
                    // add the reasons for failing, the old username, and the old password
                    echo '<META HTTP-EQUIV="refresh" CONTENT=0;URL=register.php?failed='.$failed.'&email='.$_POST["email"].'&username='.$_POST["username"].'>';
                    die();
                } else {
                    // otherwise, the registration was a success
                    // write an SQL query to add the user's row into the table called users
                    $query = "INSERT INTO users (username, password, salt, email) VALUES (:username, :password, :salt, :email)";
                    $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
                    // hash the password using the salt
                    $password = hash('sha256', $_POST['password'] . $salt);
                    for($round = 0; $round < 65536; $round++) {
                        $password = hash('sha256', $password . $salt);
                    }
                    $query_params = array(':username' => $_POST['username'], ':password' => $password, ':salt' => $salt, ':email' => $_POST['email']);

                    // run the SQL query using a try/catch statement
                    try {
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    } catch(PDOException $ex) {
                        die("Failed to run query: " . $ex->getMessage());
                    }

                    // set the values for the current user so that you do not have to re-login
                    $_SESSION['user'] = array ($_POST['email'], $_POST['username'], $_POST['password']);
                    // go to index.php
                    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
                    die();
                }
            }
        ?>
    </body>
</html>
