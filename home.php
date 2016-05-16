<html>
    <head>
        <!-- this imports all of our CSS -->
        <link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
        <!-- this adds all of our javascript code -->
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
			<a class="btn btn-primary-outline pull-xs-right" id="register-btn" href="login.php">Login</a>
		</nav>

        <div class="container-fluid">
            <div class="jumbotron bg-faded" style="padding-top: 20px; padding-bottom: 20px;">
                <h1>Welcome to Tweetter</h1>
                <p style="font-size: 20px">Tweetter is a nonprofit social media that allows you to make posts,view and like others', and write a personal bio.</p>
            </div>

            <a href="about.php">
                <div class="col-xs-4 container-fluid">
                    <div class="jumbotron bg-warning">
                        <h3 class="text-xs-center">About</h3>
                        <hr class="m-y-2">
                        <p>Did you mean to open Twitter but made a typo and found Tweetter. Well, that's a stroke of luck.
                        Tweetter just so happens to be the next big social media, and you found it in it's early days. To
                        more about this awesome site, click on this box.</p>
                    </div>
                </div>
            </a>

            <a href="help.php">
                <div class="col-xs-4 container-fluid">
                    <div class="jumbotron bg-danger">
                        <h3 class="text-xs-center">Help</h3>
                        <hr class="m-y-2">
                        <p>Our website has a bunch of cool features, but it could be a little bit complicated if you have
                        never used a computer before. So, we made a help page so that everyone (yes, everyone) can use our
                        site. To view the help page, just click anywhere on this box.</p>
                    </div>
                </div>
            </a>

            <a <a href="developers.php">
                <div class="col-xs-4 container-fluid">
                    <div class="jumbotron bg-success">
                        <h3 class="text-xs-center">Developers</h3>
                        <hr class="m-y-2">
                        <p>This website was made by four young, aspriring students, who have a profound love for computer
                        science. OK, maybe that's not all true but they are all still pretty cool. So, you should learn a
                        bit about them. To do that, just click on this box.</p>
                    </div>
                </div>
            </a>
        </div>
    </body>
</html>
