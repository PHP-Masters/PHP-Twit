<?php
    /*
    authors: julian.samek, isaac.ng, alex.kazakov, simon.osak
    date: 2016-05-16
    version: 1.0.0
    devlopers.php: a brief page outlining the four developers and what they did
    This page does not really benefit new users, but it helps learning environments
    understand how roles are played in website development, as well as giving the
    creators some fame.
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
                    <a class="nav-link" href="about.php">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="help.php">Help</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="developers.php">Developers</a>
                </li>
            </ul>
            <a class="btn btn-primary-outline pull-xs-right" id="register-btn" href="register.php">Register</a>
			<a class="btn btn-primary-outline pull-xs-right" id="register-btn" href="login.php">Login</a>
		</nav>

        <div class="container-fluid">
            <div class="jumbotron bg-faded" style="padding-top: 20px; padding-bottom: 20px;">
                <h1>About US</h1>
                <p style="font-size: 20px">We are Julian, Isaac, Alex, and Simon, the creators of Tweetter. Any complaints - don't contact us.</p>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-warning">
                    <h3 class="text-xs-center">@juliansamek</h3>
                    <hr class="m-y-2">
                    <p>Julian here. I was in charge of all the PHP code that makes this website recognize when you write, delete, like, or dislike
                    a post. You can also thank me for creating the individual user pages.</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-danger">
                    <h3 class="text-xs-center">@isaacng</h3>
                    <hr class="m-y-2">
                    <p>Hey, I'm Isaac. I was in charge of creating adding some CSS to make this website so beautiful, along with adding the date
                    and time functions for posts. That way, you know when something was posted.</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-success">
                    <h3 class="text-xs-center">@alexkazakov</h3>
                    <hr class="m-y-2">
                    <p>It's Alex from Russia, yes, Russia. I was in charge of creating this awesome home page along with the search function.
                    What would a social media be without a seach function?</p>
                </div>
            </div>

            <div class="col-xs-3 container-fluid">
                <div class="jumbotron bg-info">
                    <h3 class="text-xs-center">@simonosak</h3>
                    <hr class="m-y-2">
                    <p>I'm Simon and I'm one of the creators of Tweetter. I've been working hard on this site, by working on our github
                    documentation along with the home page, help page, about page, and this page.</p>
                </div>
            </div>
        </div>
    </body>
</html>
