<?php
    /*
    authors: julian.samek, isaac.ng, alex.kazakov, simon.osak
    date: 2016-05-16
    version: 1.0.0
    userpage.php: gives each user their own page that lists all fo their posts and has their bio
    */
?>

<html>
    <head>
        <!-- this imports all of our CSS -->
        <link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- this adds all of our javascript code -->
        <script src="Resources/JS/jquery.js"/></script>
        <script src="Resources/JS/bootstrap.js"/></script>
        <script src="Resources/JS/script.js"/></script>
    </head>

    <body background="Resources/Images/background.jpg" bgproperties="fixed">
        <?php
            // pass in some data such as the database
            require("common.php");
            // open the connection or quit the program
            $connection = mysql_connect($host, $username, $password) or die ("Unable to connect!");
            // connect to the database or quit the program
            mysql_select_db($dbname) or die ("Unable to select database!");

            // chck if they are signed in
            if(empty($_SESSION['user'])) {
                // if not, go back to the home page
                echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=home.php">';
                die();
            }

            // set the time zone, then return the current time and date
            date_default_timezone_get('America/Toronto');
            $date = date('Y-m-d');
            $current_time_now = time();

            // return an array that has the user's info - username, email, ...
            $arr = array_values($_SESSION['user']);
            // set the user value (whoever's page it is)
            $user = $_GET['user'];

            // SQL commands that will return all the values from symbols where the author is whoever's page it is in descending order by ID - also ascending order by time
			$query = "SELECT * FROM symbols WHERE author = '@".$user."' ORDER BY id DESC";
            // execute the SQL query
            $result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());

            // return a string value for what they entered as their new bio
            $new_bio = mysql_escape_string($_POST['bio']);
            // if the bio is not blank
			if ($new_bio != "") {
                // write an SQL command to change that user's bio to whatever they entered
				$command = "UPDATE users SET bio = '".$new_bio."' WHERE username = '".$user."'";
                // execute the sql commmand
                $result_command = mysql_query($command) or die ("Error in query: $command. ".mysql_error());
                // reload the page witht he correct $_GET value so that it is the right user's page
                echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=userpage.php?user='.$user.'">';
            }

            // this check if they clicked the delete button beside a post
			if (isset($_GET['id'])) {
				echo $_SERVER['PHP_SELF'];
				// write SQL commands to delete that post, then run the SQL
	    		$query = "DELETE FROM symbols WHERE id = ".$_GET['id'];
	     		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
				// reload the page witht he correct $_GET value so that it is the right user's page
				echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=userpage.php?user='.$user.'">';
				exit;
			}
		?>

        <nav class="navbar navbar-light bg-faded" id="navbar-main">
			<a class="navbar-brand" href="">Tweetter</a>
			<ul class="nav navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php">All</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="search.php">Search</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="trending.php">Trending</a>
				</li>
                <li class="nav-item">
					<a class="nav-link active" href="<?php echo 'userpage.php?user='.$arr[1]; ?>">My Page</a>
				</li>
			</ul>
            <a class="btn btn-primary-outline pull-xs-right" href="logout.php">Log Out</a>
		</nav>

        <div class="container-fluid">
            <div class="jumbotron" style="padding-top: 20px; padding-bottom: 20px;">
                <?php
                    // return the row form the table named users with the username value of whoever's page it is
                    $query_bio = "SELECT * FROM users WHERE username = '".$user."'";
                    // run the SQL code above
    			    $result_bio = mysql_query($query_bio) or die ("Error in query: $query_bio. ".mysql_error());
                    // fetch the returned result as an array
                    $row_bio = mysql_fetch_row($result_bio);
                    // echo the username and its bio
                    echo '<h4 class="display-4"> @'.$user.'</h4>';
                    if ($row_bio[5] != "") {
                        echo '<p class="lead">'.$row_bio[5].'</p>';
                    } else {
                        echo '<p class="lead">Add a bio so people can learn a bit about you.</p>';
                    }

                    // if it is the user's page (not someone else's), return a button that lets them edit their bio
                    if ($arr[1] == $user) {
                        echo '<button class="btn btn-info-outline" data-toggle="modal" data-target="#changebio">
                            Edit Your Bio
                        </button>';
                    }
                ?>
            </div>
        </div>

        <!-- create  a modal that pops up when the change your bio button is pressed, allowing you to edit your bio -->
        <div class="modal fade" id="changebio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Change Your Bio</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo 'userpage.php?user='.$user ?>" method="post">
    	                    <input class="form-control" type="text" name="bio" value="<?php echo $row_bio[5] ?>" style="margin-bottom: 10px"/>
                            <div class="text-xs-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <input class="btn btn-info" type="submit" name="submit" value="Save Changes"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
    		<div class="container-fluid bg-faded" style="padding-top: 10px">
    			<?php
                    // if there are any rows in $result, loop thorugh each of them
                    if (mysql_num_rows($result) > 0) {
                        while($row = mysql_fetch_row($result)) {
                            // create array that include all hastags and user tags in the post
                            $hashtags = explode(" ", $row[3]);
                            $usertags = explode(" ", $row[4]);
                            // echo (like print) the row as a bootstrap card
                            echo "<div class=card card-block><div class=container-fluid>
                            <div class=col-xs-11>
                            <br />
                            <h4 class=card-title><a class=author-link href=userpage.php?user=".substr($row[1], 1).">".$row[1]."</a>
                            <span class='small'>";
                            // echo each of the hastags as a link to their own page
                            foreach ($hashtags as $line) {
                                echo "<a class=hashtag-link href=hashtag.php?hashtag=".substr($line, 1).">".$line." </a>";
                            }
                            // echo each of the user tags as a link to that user's page
                            echo "</span><span class='small'>";
                            foreach ($usertags as $line) {
                                echo "<a class=usertag-link href=userpage.php?user=".substr($line, 1).">".$line." </a>";
                            }

                            // echo the date/time
                            // if it was posted today
                            if ($row[7] == $date) {
                                $current_time_now = $current_time_now - $row[8];
                                $current_time_now = $current_time_now / 60;
                                // if it was posted less than an hour ago
                                if ($current_time_now < 60) {
                                    // echo how many minutes old
                                    echo "</span><span class='card-text small pull-xs-right'><p>".floor($current_time_now)." minutes ago </p> </span></h4>";
                                } else {
                                    // echo how many hours old
                                    $current_time_now = $current_time_now / 60;
                                    echo "</span><span class='card-text small pull-xs-right'><p>".floor($current_time_now)." hours ago </p> </span></h4>";
                                }
                            } else {
                                // echo the date it was posted
                                echo "</span><span class='card-text small pull-xs-right'>".$row[7]."</span> </h4>";
                            }
                            // reset the current time
                            $current_time_now = time();

                            // add the like/dislike icons and tallies
                            // use font-awesome icons to do so
                            echo "<p class=card-text>".$row[2]."</p>
                            <a class='fa fa-thumbs-o-up post-like' href=like.php?id=".$row[0]."&site=".$_SERVER['PHP_SELF']."?user=".$user."></a> ".$row[5]."
                            <a class='fa fa-thumbs-o-down post-dislike' href=dislike.php?id=".$row[0]."&site=".$_SERVER['PHP_SELF']."?user=".$user."></a> ".$row[6]."                                <br />
                            </div>";
                            // if you posted the post, add a delete button
                            if ('@'.$arr[1] == $row[1]) {
                                echo "<div class=col-xs-1>
                                    <a class='btn btn-sm btn-danger pull-xs-right' href=".$_SERVER['PHP_SELF']."?user=".$user."&id=".$row[0]." style='margin-top: 15px'>X</a>
                                </div>";
                            }
                            echo "</div></div>";
                        }
                    // if nothing is posted, give a nice message
                    } else {
                        echo "<div class=card><div class='card-block'>
                        <h3 class='text-xs-center'>Write your first post.</h3>
                        </div></div>";
                    }

                    // free the result to reset it for the next time you run the query
                    mysql_free_result($result);

                    // close the connection
        			mysql_close($connection);
    			?>
    		</div>
        </div>
    </body>
</html>
