<html>
	<head>
		<link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
		<script src="Resources/JS/jquery.js"/></script>
		<script src="Resources/JS/bootstrap.js"/></script>
	</head>

    <body>
        <nav class="navbar navbar-light bg-faded" id="navbar-main">
            <a class="navbar-brand" href="index.php">Twitter</a>
			<a class="btn btn-primary-outline pull-xs-right" href="index.php">Main Page</a>
		</nav>

        <div class="container-fluid">
            <div class="card-deck-wrapper"><div class="card-deck">
                <div class="card">
                    <h3 class="card-header bg-info text-xs-center">Login</h3>
					<form action="signin.php" method="post">
	                    <div class="card-block">
	                        <fieldset class="form-group">
	                            <label for="team-name">User Name</label>
	                            <input class="form-control" name="username" placeholder="ex. John Smith" value="<?php echo $submitted_username; ?>">
	                        </fieldset>

	                        <fieldset class="form-group">
	                            <label for="password">Password</label>
	                            <input class="form-control" name="password" placeholder="ex. Password" value="">
	                        </fieldset>
	                    </div>
	                    <div class="card-footer bg-faded text-xs-center" id="login-btn">
	                        <input class="btn btn-info" type="submit" value="Login"/>
	                    </div>
					</form>
                </div>

                <div class="card">
                    <h3 class="card-header bg-info text-xs-center">Register</h3>
					<form action="signin.php" method="post">
	                    <div class="card-block">
	                        <fieldset class="form-group">
	                            <label for="email">Email Address</label>
	                            <input class="form-control" name="email" placeholder="ex. john.smith@gmail.com">
	                            <small class="text-muted">We'll never share your email with anyone else.</small>
	                        </fieldset>

	                        <fieldset class="form-group">
	                            <label for="Team Name">User Name</label>
	                            <input class="form-control" name="username" placeholder="ex. John Smith">
	                        </fieldset>

	                        <fieldset class="form-group">
	                            <label for="password">Password</label>
	                            <input class="form-control" name="password" placeholder="ex. Password">
	                        </fieldset>
	                    </div>
	                    <div class="card-footer bg-faded text-xs-center">
	                        <input class="btn btn-info" type="submit" value="Register"/>
	                    </div>
					</form>
                </div>
            </div></div>
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
					$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
				}
			}

			/////////
			// register
			////////

			// First we execute our common code to connection to the database and start the session
		    require("common.php");

		    // This if statement checks to determine whether the registration form has been submitted
		    // If it has, then the registration code is run, otherwise the form is displayed
		    if(!empty($_POST))
		    {
		        // Ensure that the user has entered a non-empty username
		        if(empty($_POST['username']))
		        {
		            // Note that die() is generally a terrible way of handling user errors
		            // like this.  It is much better to display the error with the form
		            // and allow the user to correct their mistake.  However, that is an
		            // exercise for you to implement yourself.
		            die("Please enter a username.");
		        }

		        // Ensure that the user has entered a non-empty password
		        if(empty($_POST['password']))
		        {
		            die("Please enter a password.");
		        }

		        // Make sure the user entered a valid E-Mail address
		        // filter_var is a useful PHP function for validating form input, see:
		        // http://us.php.net/manual/en/function.filter-var.php
		        // http://us.php.net/manual/en/filter.filters.php
		        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		            die("Invalid E-Mail Address");
		        }

		        $query = "
		            SELECT
		                1
		            FROM users
		            WHERE
		                username = :username
		        ";

		        $query_params = array(
		            ':username' => $_POST['username']
		        );

		        try {
		            // These two statements run the query against your database table.
		            $stmt = $db->prepare($query);
		            $result = $stmt->execute($query_params);
		        } catch(PDOException $ex) {
		            // Note: On a production website, you should not output $ex->getMessage().
		            // It may provide an attacker with helpful information about your code.
		            die("Failed to run query: " . $ex->getMessage());
		        }
		        $row = $stmt->fetch();
    			if($row) {
		            die("This username is already in use");
		        }
		        $query = "
		            SELECT
		                1
		            FROM users
		            WHERE
		                email = :email
		        ";
		        $query_params = array(
		            ':email' => $_POST['email']
		        );
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
		        $query = "
		            INSERT INTO users (
		                username,
		                password,
		                salt,
		                email
		            ) VALUES (
		                :username,
		                :password,
		                :salt,
		                :email
		            )
		        ";

		        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
		        $password = hash('sha256', $_POST['password'] . $salt);
		        for($round = 0; $round < 65536; $round++) {
		            $password = hash('sha256', $password . $salt);
		        }
				$query_params = array (
		            ':username' => $_POST['username'],
		            ':password' => $password,
		            ':salt' => $salt,
		            ':email' => $_POST['email']
		        );
		        try {
		            // Execute the query to create the user
		            $stmt = $db->prepare($query);
		            $result = $stmt->execute($query_params);
		        } catch(PDOException $ex) {
		            die("Failed to run query: " . $ex->getMessage());
		        }
		        header("Location: signin.php");
		    }
		?>
    </body>
</html>
