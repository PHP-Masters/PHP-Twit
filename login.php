<html>
    <head>
        <link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
		<script src="Resources/JS/jquery.js"/></script>
		<script src="Resources/JS/bootstrap.js"/></script>
        <script src="Resources/JS/script.js"/></script>
    </head>

    <body>
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
            <a class="btn btn-primary-outline pull-xs-right" id="register-btn" href="register.php">Register</a>
		</nav>

        <div class="container-fluid">
            <div class="card">
                <h3 class="card-header bg-info text-xs-center">Login</h3>
                <form action="login.php" method="post">
                    <div class="card-block">
                        <?php
                            // check if they have entered a username
                            if (isset($_GET['username'])) {
                                // if so, echo the username in the form
                                echo '<fieldset class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text" name="username" value='.$_GET["username"].'>
                                </fieldset>';
                            // otherwise
                            } else {
                                // add the form with ex. John Smith
                                echo '<fieldset class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text" name="username" placeholder="ex. John Smith"/>
                                </fieldset>';
                            }

                            // if the login attempt has failed
                            if (isset($_GET['failed'])) {
                                // add the danger class to the form - makes it look nice
                                // display a message saying the password is incorrect
                                echo '<fieldset class="form-group has-danger">
                                    <label>Password</label>
                                    <input class="form-control form-control-danger" type="password" name="password" placeholder="ex. Password"/>
                                    <label class="form-control-label small">You may have entered the wrong password.</label>
                                    </fieldset>';
                            // otherwise
                            } else {
                                // just echo a normal form
                                echo '<fieldset class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="ex. Password"/>
                                    </fieldset>';
                            }
                        ?>
                    </div>

                    <div class="card-footer bg-faded text-xs-center" id="login-btn">
                        <input class="btn btn-info" type="submit" value="Login"/>
                    </div>
                </form>
            </div>
        </div>

        <?php
            // pass in some data
            require("common.php");
            // set a string variable for the submitted username
            $submitted_username = '';

            // if they have entered anything at all
            if(!empty($_POST)) {
                // set a boolean for the login to see if it failed
                $login_ok = false;

                // create an SQL query that searches for any rows from the users table that hav that username
                $query = " SELECT id, username, password, salt, email FROM users WHERE username = :username";
                $query_params = array (':username' => $_POST['username']);

                // try to run the sql code
                try {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                } catch(PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }

                // hash the password using the salt
                $row = $stmt->fetch();
                if($row) {
                    $check_password = hash('sha256', $_POST['password'] . $row['salt']);
                    for ($round = 0; $round < 65536; $round++) {
                        $check_password = hash('sha256', $check_password . $row['salt']);
                    }
                    // check if the entered password is the correct, unhashed password
                    if ($check_password === $row['password']) {
                        // if so, set login to true
                        $login_ok = true;
                    }
                }

                // if the login workd
                if($login_ok) {
                    // unset the salt and password
                    unset($row['salt']);
                    unset($row['password']);
                    // set the value for the user
                    $_SESSION['user'] = array ($row['email'], $_POST['username'], $_POST['password']);
                    // go to index.php
                    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
                    die();
                } else {
                    // otherwise, reload the page with special get values that tell you the username and that the login failed
                    echo '<META HTTP-EQUIV="refresh" CONTENT=0;URL=login.php?failed=true&username='.$_POST["username"].'>';
                    die();
                }
            }
        ?>
    </body>
</html>
