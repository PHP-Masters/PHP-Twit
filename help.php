<?php
    /*
    authors: julian.samek, isaac.ng, alex.kazakov, simon.osak
    date: 2016-05-16
    version: 1.0.0
    help.php: gives additional support to new users trying to use the website for their first time
    The page provides help for 8 different scenarios
    */
?>

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
                    <a class="nav-link active" href="help.php">Help</a>
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
                <h1>Need Some Help?</h1>
                <p style="font-size: 20px">Tweetter can seem a bit complicated, so we created this page to help you out.</p>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">How to Login</h3>
                    <hr class="m-y-2">
                    <p>If you have already created an account, you don't need to register again. Instead, just login <body>
                    clicking on the lgin button in your screen top right corner.</p>
                    </body></p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">How to Sign Up</h3>
                    <hr class="m-y-2">
                    <p>To use our website for the first time, you have to register an account. So, click on the register
                    button in your screen's top right, then fill out the boxes.</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">Register Failed?</h3>
                    <hr class="m-y-2">
                    <p>Our website will tell you where and why you failed, and so just change that value. Your
                    register attempt might fail if you input a fake email or if your username is taken.</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">Post Something</h3>
                    <hr class="m-y-2">
                    <p>Click on "All" in the menu bar to go to the home page. Then, just type in the box to your
                    right and click post. Plus, you can add hashtags and tag users.</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">Custom Posts</h3>
                    <hr class="m-y-2">
                    <p>To add a hashtag to a post, just type #_____. To tag a user, type @_____. You can add these
                    tags anywher in your posts. Then, you can click on them to view more.</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">Your User Page</h3>
                    <hr class="m-y-2">
                    <p>Click on "My Page" in the menu bar. There, you can add/edit your bio by
                    clicking on the button that says "Edit Your Bio". There's also a list of all your posts.</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">Search</h3>
                    <hr class="m-y-2">
                    <p>Click on "Search" in the menu bar. There, you can search posts by username or by hashtag.
                    Type in the box you want to search from, and search away.</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">Like/Trending</h3>
                    <hr class="m-y-2">
                    <p>When you see a post you like, click the thumb's up icon below it. This likes the post. If
                    you hate the post, click the thumb's down icon. Popular posts go in the trending page.</p>
                </div>
            </div>
        </div>
    </body>
</html>
