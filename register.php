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
            <a class="btn btn-primary-outline pull-xs-right" id="register-btn" href="login.php">Login</a>
		</nav>

        <div class="container-fluid">
            <div class="card">
                <h3 class="card-header bg-info text-xs-center">Register</h3>
                <form action="register.php" method="post">
                    <div class="card-block">
                        <?php
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
                            } else {
                                $failedList = explode('-', $_GET['failed']);
                                if (in_array("email_fake", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Email</label>
                                            <input class="form-control form-control-danger" type="text" name="email" placeholder="ex. john.smith@gmail.com"/>
                                            <label class="form-control-label small">That is not a valid email address. Please choose a different one.</label>
                                        </fieldset>';
                                } else if (in_array("email_used", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Email</label>
                                            <input class="form-control form-control-danger" type="text" name="email" placeholder="ex. john.smith@gmail.com"/>
                                            <label class="form-control-label small">That email address is already in use. Please choose a different one.</label>
                                        </fieldset>';
                                } else {
                                    echo '<fieldset class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" name="email" value='.$_GET["email"].'>
                                        </fieldset>';
                                }

                                if (in_array("username_empty", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Username</label>
                                            <input class="form-control form-control-danger" type="text" name="username" placeholder="ex. John Smith"/>
                                            <label class="form-control-label small">Please enter a username.</label>
                                        </fieldset>';
                                } else if (in_array("username_used", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Username</label>
                                            <input class="form-control form-control-danger" type="text" name="username" placeholder="ex. John Smith"/>
                                            <label class="form-control-label small">That username address is already in use. Please choose a different one.</label>
                                        </fieldset>';
                                } else {
                                    echo '<fieldset class="form-group">
                                            <label>Username</label>
                                            <input class="form-control" type="text" name="username" value='.$_GET["username"].'>
                                        </fieldset>';
                                }

                                if (in_array("password_empty", $failedList)) {
                                    echo '<fieldset class="form-group has-danger">
                                            <label>Password</label>
                                            <input class="form-control form-control-danger" type="password" name="password" placeholder="ex. Password"/>
                                            <label class="form-control-label small">Please enter a password.</label>
                                        </fieldset>';
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
            require("common.php");
            if(!empty($_POST)) {
                $failed = "";
                if(empty($_POST['username'])) {
                    $failed = $failed."username_empty-";
                }
                if(empty($_POST['password'])) {
                    $failed = $failed."password_empty-";
                }
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $failed = $failed."email_fake-";
                }

                $query = "SELECT 1 FROM users WHERE username = :username";
                $query_params = array(':username' => $_POST['username']);

                try {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                } catch(PDOException $ex) {
                    die ("Failed to run query: " . $ex->getMessage());
                }

                $row = $stmt->fetch();
                if($row) {
                    $failed = $failed."username_used-";
                }

                $query = "SELECT 1 FROM users WHERE email = :email";
                $query_params = array(':email' => $_POST['email']);

                try {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                } catch(PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }

                $row = $stmt->fetch();
                if($row) {
                    $failed = $failed."email_used-";
                }

                if ($failed != "") {
                    echo '<META HTTP-EQUIV="refresh" CONTENT=0;URL=register.php?failed='.$failed.'&email='.$_POST["email"].'&username='.$_POST["username"].'>';
                    die();
                } else {
                    $query = "INSERT INTO users (username, password, salt, email) VALUES (:username, :password, :salt, :email)";
                    $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
                    $password = hash('sha256', $_POST['password'] . $salt);
                    for($round = 0; $round < 65536; $round++) {
                        $password = hash('sha256', $password . $salt);
                    }
                    $query_params = array(':username' => $_POST['username'], ':password' => $password, ':salt' => $salt, ':email' => $_POST['email']);

                    try {
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                    } catch(PDOException $ex) {
                        die("Failed to run query: " . $ex->getMessage());
                    }

                    $_SESSION['user'] = array ($_POST['email'], $_POST['username'], $_POST['password']);
                    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
                    die();
                }
            }
        ?>
    </body>
</html>
