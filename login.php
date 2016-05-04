<html>
	<head>
		<link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
		<script src="Resources/JS/jquery.js"/></script>
		<script src="Resources/JS/bootstrap.js"/></script>
        <script src="Resources/JS/style.js"/></script>
	</head>

    <body>
        <div class="card">
            <h3 class="card-header bg-info text-xs-center">Login</h3>
            <form action="login.php" method="post">
                <div class="card-block">
                    <fieldset class="form-group">
                        <label for="team-name">User Name</label>
                        <input class="form-control" name="username" placeholder="ex. John Smith" value="<?php echo $submitted_username; ?>">
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="ex. Password" value="">
                    </fieldset>
                </div>
                <div class="card-footer bg-faded text-xs-center" id="login-btn">
                    <input class="btn btn-info" type="submit" value="Login"/>
                </div>
            </form>
        </div>

        <?php
            require("common.php");
            $submitted_username = '';
            if(!empty($_POST)) {
                $query = "
                    SELECT
                        id,
                        username,
                        password,
                        salt,
                        email
                    FROM users
                    WHERE
                        username = :username
                ";
                $query_params = array(
                    ':username' => $_POST['username']
                );
                try {
                    // Execute the query against the database
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                } catch(PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }
                $login_ok = false;
                $row = $stmt->fetch();
                if($row) {
                    $check_password = hash('sha256', $_POST['password'] . $row['salt']);
                    for($round = 0; $round < 65536; $round++) {
                        $check_password = hash('sha256', $check_password . $row['salt']);
                    } if($check_password === $row['password']) {
                        $login_ok = true;
                    }
                }

                if($login_ok) {
                    unset($row['salt']);
                    unset($row['password']);
                    $_SESSION['user'] = $row;
                    // reset the url to remove id $_GET variable
                    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=http://localhost:8888/PHP-Twit/edit.php">';
                    exit;
                } else {
                    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=http://localhost:8888/PHP-Twit/signin.php">';
                    exit;
                }
            }
        ?>

    </body>
</html>
