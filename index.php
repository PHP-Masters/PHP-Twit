<?php
    /*
    authors: julian.samek, isaac.ng, alex.kazakov, simon.osak
    date: 2016-05-16
    version: 1.0.0
    index.php: the home page for the site once you are logged in
	This page is where you can write new posts and view all posts in order of date
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
			// returnt he value for the post the suer made using PHP's $_POST funcitonality
			$post = mysql_escape_string($_POST['post']);
			// split the post apart into a list of words - breaking elements at each space
			$post_list = explode(" ", $post);
			// create a string for each of the hastags and for each of the user tags
			$hashtags = "";
			$users = "";
			// as long as the post is not blank
			if ($post != "") {
				// loop through each element in the list
				foreach ($post_list as $word) {
					// if the word starts with a #, it is a hashtag so add it to that string
					if ($word[0] == "#") {
						$hashtags = $hashtags.$word." ";
					// if the word starts with a @, it is a user tag so add it to that string
					} else if ($word[0] == "@") {
						$users = $users.$word." ";
					}
				}
				// write an SQL command to add that post to the table called symbols
				$query = "INSERT INTO symbols (author, post, hashtags, tags, date, time, hours) VALUES ('@$arr[1]', '$post', '$hashtags', '$users', '$date', '$current_time_now', '$hours')";
				// execute the above SQL query
				$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
				// refresh the page to see the new post
				echo "<meta http-equiv='refresh' content='0'>";
			}
			// this check if they clicked the delete button beside a post
			if (isset($_GET['id'])) {
				echo $_SERVER['PHP_SELF'];
				// write SQL commands to delete that post, then run the SQL
	    		$query = "DELETE FROM symbols WHERE id = ".$_GET['id'];
	     		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
				// reload the page
				echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
				exit;
			}
			// close the connection
			mysql_close($connection);
		?>

		<nav class="navbar navbar-light bg-faded" id="navbar-main">
			<a class="navbar-brand" href="">Tweetter</a>
			<ul class="nav navbar-nav">
				<li class="nav-item">
					<a class="nav-link active" href="index.php">All</a>
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
            <div class="jumbotron" style="padding-top: 20px; padding-bottom: 20px;">
                <h4 class="display-4">Most Recent</h4>
                <p class="lead">This a list of all the posts on the app.</p>
            </div>
        </div>

		<div class="col-xs-8">
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
					// if nothing is posted, give a nice message
					} else {
						echo "<div class=card><div class='card-block'>
						<h3 class='text-xs-center'>Be the first to write a post.</h3>
						</div></div>";
					}
					// free the result to reset it for the next time you run the query
					mysql_free_result($result);
				?>
			</div>
		</div>

		<div class="col-xs-4">
			<div class="container-fluid bg-faded" style="padding-top: 10px">
				<div class="card">
	                <h3 class="card-header bg-info text-xs-center">New Post</h3>
	                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
	                    <div class="card-block">
	                        <fieldset class="form-group">
	                            <input class="form-control" type="text" name="post" placeholder="My Very Own Post" style="margin-bottom: 10px"/>
							</fieldset>
	                    </div>
	                    <div class="card-footer bg-faded text-xs-center">
	                        <input class="btn btn-info" type="submit" name="submit" value="Post"/>
	                    </div>
	                </form>
	            </div>
			</div>
		</div>
	</body>
</html>
