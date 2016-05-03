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
		?>

        <div class="container-fluid">
            <div class="card-deck-wrapper"><div class="card-deck">
                <div class="card">
                    <h3 class="card-header bg-info text-xs-center">Login</h3>
					<form action="signin.php" method="post">
	                    <div class="card-block">
	                        <fieldset class="form-group">
	                            <label for="team-name">Team Name</label>
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
                    <div class="card-block">
                        <fieldset class="form-group">
                            <label for="email">Email Address</label>
                            <input class="form-control" id="email" placeholder="ex. john.smith@gmail.com">
                            <small class="text-muted">We'll never share your email with anyone else.</small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="Team Name">Team Name</label>
                            <input class="form-control" id="team-name" placeholder="ex. John Smith">
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" id="team-name" placeholder="ex. Password">
                        </fieldset>
                    </div>
                    <div class="card-footer bg-faded text-xs-center">
                        <a class="btn btn-info">Register</a>
                    </div>
                </div>
            </div></div>
        </div>
    </body>
</html>
