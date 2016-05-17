<?php
    /*
    authors: julian.samek, isaac.ng, alex.kazakov, simon.osak
    date: 2016-05-16
    version: 1.0.0
    hashtag.php: will display a specific page with only post under a certain hashtag
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

    <body>
        <?php
            // pass in some data such as the database
            require("common.php");
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

            // open the connection or quit the program
            $connection = mysql_connect($host, $username, $password) or die ("Unable to connect!");
            // connect to the database or quit the program
            mysql_select_db($dbname) or die ("Unable to select database!");

            // write a query to return all the rows from the table "symbols" in descending order by ID - ascending order by time
            $query = "SELECT * FROM symbols ORDER BY id DESC";
            // run  the SQL code above
            $result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
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
					<a class="nav-link" href="<?php echo 'userpage.php?user='.$arr[1]; ?>">My Page</a>
				</li>
			</ul>
            <a class="btn btn-primary-outline pull-xs-right" href="logout.php">Log Out</a>
		</nav>

        <div class="container-fluid">
            <div class="container-fluid bg-faded" style="padding-top: 10px">
                <?php
                    // set a boolean to see if any rows were returned - right now it is false
                    $returned = false;
                    // return the value for the hastag you are returning
                    $hashtag = "#".mysql_escape_string($_GET['hashtag']);
                    // loop through each row that was returned
    				while($row = mysql_fetch_row($result)) {
                        // check if the row contains the hashtag
                        if (strpos($row[3], $hashtag) !== false) {
                            // if so, set returned to true
                            $returned = true;
                            // return the post
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
                                <a class='fa fa-thumbs-o-up post-like' href=like.php?id=".$row[0]."&site=".$_SERVER['PHP_SELF']."?hashtag=".$_GET['hashtag']."></a> ".$row[5]."
								<a class='fa fa-thumbs-o-down post-dislike' href=dislike.php?id=".$row[0]."&site=".$_SERVER['PHP_SELF']."?hashtag=".$_GET['hashtag']."></a> ".$row[6]."                                <br />
                            </div>";
                            // if you posted the post, add a delete button
                            if ('@'.$arr[1] == $row[1]) {
                                echo "<div class=col-xs-1>
                                    <a class='btn btn-sm btn-danger pull-xs-right' href=".$_SERVER['PHP_SELF']."?id=".$row[0]." style='margin-top: 15px'>X</a>
                                </div>";
                            }
                            echo "</div></div>";
                        }
    				}
                    // if nothing was returned, tell the user that
                    if (!$returned) {
                        echo "<div class=card><div class='card-block'>
                        <h3 class='text-xs-center'>No posts were returned.</h3>
                        </div></div>";
                    }
                    // free the result to reset
    				mysql_free_result($result);
    			?>
            </div>
        </div>
    </body>
</html>
