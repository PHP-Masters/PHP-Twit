<html>
    <head>
        <link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
		<script src="Resources/JS/jquery.js"/></script>
		<script src="Resources/JS/bootstrap.js"/></script>
        <script src="Resources/JS/style.js"/></script>
    </head>

    <body>
        <nav class="navbar navbar-light bg-faded" id="navbar-main">
			<a class="navbar-brand" href="home.php">Twitter</a>
			<a class="btn btn-primary-outline pull-xs-right" id="register-btn" href="login.php">Login</a>
      <a class="btn btn-primary-outline pull-xs-right" href="home.php">Home</a>
		</nav>

        <div class="container-fluid">
            <div class="card">
                <h3 class="card-header bg-info text-xs-center">Register</h3>
                <form action="register.php" method="post">
                    <div class="card-block">
                        <fieldset class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" name="email" placeholder="ex. john.smith@gmail.com"/>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>User Name</label>
                            <input class="form-control" type="text" name="username" placeholder="ex. John Smith"/>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password" placeholder="ex. Password"/>
                        </fieldset>
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
                if(empty($_POST['username'])) {
                    die("Please enter a username.");
                }
                if(empty($_POST['password'])) {
                    die("Please enter a password.");
                }
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    die("Invalid E-Mail Address");
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
                    die("This username is already in use");
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
                    die("This email address is already registered");
                }

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
                echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=http://localhost:8888/PHP-Twit/edit.php">';
                die("Redirecting to edit.php");
            }
        ?>
    </body>
</html>
