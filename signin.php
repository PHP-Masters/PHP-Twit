<html>
	<head>
		<link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
		<script src="Resources/JS/jquery.js"/></script>
		<script src="Resources/JS/bootstrap.js"/></script>
		<script src="Resources/JS/style.js"/></script>
	</head>

    <body>
        <nav class="navbar navbar-light bg-faded" id="navbar-main">
            <a class="navbar-brand" href="index.php">Twitter</a>
			<a class="btn btn-primary-outline pull-xs-right" href="index.php">Main Page</a>
		</nav>

        <div class="container-fluid">
            <div class="card-deck-wrapper"><div class="card-deck">
                <?php include_once("login.php"); ?>
                <?php include_once("register.php"); ?>
            </div></div>
        </div>
    </body>
</html>
