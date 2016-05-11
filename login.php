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
			<a class="navbar-brand" href="home.php">Tweeter</a>
			<a class="btn btn-primary-outline pull-xs-right" id="register-btn" href="register.php">Register</a>
            <a class="btn btn-primary-outline pull-xs-right" href="home.php">Home</a>
		</nav>

        <div class="container-fluid">
            <div class="card">
                <h3 class="card-header bg-info text-xs-center">Login</h3>
                <form action="login.php" method="post">
                    <div class="card-block">
                        <?php
                            if (isset($_GET['username'])) {
                                echo '<fieldset class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text" name="username" value='.$_GET["username"].'>
                                </fieldset>';
                            } else {
                                echo '<fieldset class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text" name="username" placeholder="ex. John Smith"/>
                                </fieldset>';
                            }

                            if (isset($_GET['failed'])) {
                                echo '<fieldset class="form-group has-danger">
                                    <label>Password</label>
                                    <input class="form-control form-control-danger" type="password" name="password" placeholder="ex. Password"/>
                                    <label class="form-control-label small">You may have entered the wrong password.</label>
                                    </fieldset>';
                            } else {
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
            require("common.php");
            $submitted_username = '';

            if(!empty($_POST)) {
                $query = " SELECT id, username, password, salt, email FROM users WHERE username = :username";
                $query_params = array (':username' => $_POST['username']);

                try {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                } catch(PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }
                $login_ok = false;
                $row = $stmt->fetch();
                if($row) {
                    $check_password = hash('sha256', $_POST['password'] . $row['salt']);
                    for ($round = 0; $round < 65536; $round++) {
                        $check_password = hash('sha256', $check_password . $row['salt']);
                    }
                    if ($check_password === $row['password']) {
                        $login_ok = true;
                    }
                }

                if($login_ok) {
                    unset($row['salt']);
                    unset($row['password']);
                    $_SESSION['user'] = array ($row['email'], $_POST['username'], $_POST['password']);
                    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
                    die();
                } else {
                    echo '<META HTTP-EQUIV="refresh" CONTENT=0;URL=login.php?failed=true&username='.$_POST["username"].'>';
                    die();
                }
            }
        ?>
    </body>
</html>
