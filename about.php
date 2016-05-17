<?php
    /*
    authors: julian.samek, isaac.ng, alex.kazakov, simon.osak
    date: 2016-05-16
    version: 1.0.0
    about.php: desrcibes basic information about tweetter
    This page only uses html and gives any possible new users
    a sense of the site before they sign up
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

    <body background="Resources/Images/background_3.jpg" bgproperties="fixed">
        <nav class="navbar navbar-light bg-faded" id="navbar-main">
			<a class="navbar-brand" href="home.php">Tweetter</a>
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="about.php">About</a>
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
                <h1>About Tweetter</h1>
                <p style="font-size: 20px">Tweetter is a nonprofit social media that allows you to make posts,view and like others', and write a personal bio.</p>
            </div>

            <div class="col-xs-4 container-fluid">
                <div class="jumbotron bg-warning">
                    <h3 class="text-xs-center">Main Page</h3>
                    <hr class="m-y-2">
                    <p>The main page for Tweetter is a list of all posts, ever. It's pretty cool because you can see what everyone has to say, so you can hear
                    about new ideas and topics, as well as meet (or at least kind of meet) new people. Plus, you will see lots of new hashtags.</p>
                </div>
            </div>

            <div class="col-xs-4 container-fluid">
                <div class="jumbotron bg-danger">
                    <h3 class="text-xs-center">Your Page</h3>
                    <hr class="m-y-2">
                    <p>OK, I'll admit this is a pretty cool part of our website. It allows users to create their own pages that are all about them. That's right,
                    your page is all about you. What does that mean, that you can write a bio and will have a list of all your tweets.</p>
                </div>
            </div>

            <div class="col-xs-4 container-fluid">
                <div class="jumbotron bg-success">
                    <h3 class="text-xs-center">Custom Pages</h3>
                    <hr class="m-y-2">
                    <p>As you now know, you can view pages just about one user. But, our website can create custom pages for tons of other specifics as well. for
                    example, each hastag has its own page, and as well, you can search post by hastags or users.</p>
                </div>
            </div>
        </div>
    </body>
</html>
