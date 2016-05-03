<html>
	<head>
		<link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
		<script src="Resources/JS/jquery.js"/></script>
		<script src="Resources/JS/bootstrap.js"/></script>
	</head>

    <body>
        <nav class="navbar navbar-light bg-faded" id="navbar-main">
            <a class="navbar-brand" href="index.php">Stats Pro</a>
			<a class="btn btn-primary-outline pull-xs-right" href="index.php">Main Page</a>
		</nav>

        <div class="container-fluid">
            <div class="card-deck-wrapper"><div class="card-deck">
                <div class="card">
                    <h3 class="card-header bg-info text-xs-center">Login</h3>
                    <div class="card-block">
                        <fieldset class="form-group">
                            <label for="team-name">Team Name</label>
                            <input class="form-control" id="team-name" placeholder="ex. John Smith">
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" placeholder="ex. Password">
                        </fieldset>
                    </div>
                    <div class="card-footer bg-faded text-xs-center" id="login-btn">
                        <a class="btn btn-info">Login</a>
                    </div>
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
