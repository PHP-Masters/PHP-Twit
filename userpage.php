<html>
    <head>
        <link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
        <link rel="stylesheet" href="Resources/CSS/style.css"/>
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="Resources/JS/jquery.js"/></script>
        <script src="Resources/JS/bootstrap.js"/></script>
        <script src="Resources/JS/script.js"/></script>
    </head>

    <body>
        <?php
			date_default_timezone_set('America/Toronto');
			$date = date('Y-m-d H:i:s');

			require("common.php");
			if(empty($_SESSION['user'])) {
				$location = "http://" . $_SERVER['HTTP_HOST'] . "/login.php";
				echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=home.php">';
				die("Redirecting to login.php");
			}
			$arr = array_values($_SESSION['user']);
			$connection = mysql_connect($host, $username, $password) or die ("Unable to connect!");
			mysql_select_db($dbname) or die ("Unable to select database!");
			$query = "SELECT * FROM symbols WHERE author = '@".$arr[1]."' ORDER BY id DESC";
			$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());

			if (isset($_GET['id'])) {
				echo $_SERVER['PHP_SELF'];
	    		$query = "DELETE FROM symbols WHERE id = ".$_GET['id'];
	     		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
				$location = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
				echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
				exit;
			}
		?>

        <nav class="navbar navbar-light bg-faded" id="navbar-main">
			<a class="navbar-brand" href="">Tweeter</a>
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
					<a class="nav-link active" href="userpage.php">My Page</a>
				</li>
			</ul>
            <a class="btn btn-primary-outline pull-xs-right" href="logout.php">Log Out</a>
		</nav>

        <div class="container-fluid">
            <div class="jumbotron" style="padding-top: 20px; padding-bottom: 20px;">
                <?php
                    $query_bio = "SELECT * FROM users WHERE username = '".$arr[1]."'";
    			    $result_bio = mysql_query($query_bio) or die ("Error in query: $query_bio. ".mysql_error());
                    $row_bio = mysql_fetch_row($result_bio);
                    echo '<h4 class="display-4"> @'.$row_bio[1].'</h4>';
                    if ($row_bio[5] != "") {
                        echo '<p class="lead">'.$row_bio[5].'</p>';
                    } else {
                        echo '<p class="lead">Add a bio so people can learn a bit about you.</p>';
                    }
                    echo '<button class="btn btn-info-outline" data-toggle="modal" data-target="#changebio">
                        Edit Your Bio
                    </button>';
                ?>
            </div>
        </div>

        <div class="col-xs-8">
    		<div class="container-fluid bg-faded" style="padding-top: 10px">
    			<?php
    				if (mysql_num_rows($result) > 0) {
    					while($row = mysql_fetch_row($result)) {
    						$hashtags = explode(" ", $row[3]);
    						$usertags = explode(" ", $row[4]);
    						echo "<div class=card card-block><div class=container-fluid>
    					    <div class=col-xs-11>
    							<br />
    							<h4 class=card-title><a class=author-link href=user.php?user=".substr($row[1], 1).">".$row[1]."</a>
    							<span class='small'>";
    							foreach ($hashtags as $line) {
    								echo "<a class=hashtag-link href=hashtag.php?hashtag=".substr($line, 1).">".$line." </a>";
    							}
    							echo "</span><span class='small'>";
    							foreach ($usertags as $line) {
    								echo "<a class=usertag-link href=user.php?user=".substr($line, 1).">".$line." </a>";
    							}
    							echo "</span><span class='card-text small pull-xs-right'>".$row[7]."</span></h4>
    							<p class=card-text>".$row[2]."</p>
    							<a class='fa fa-thumbs-o-up post-like' href=like.php?id=".$row[0]."&site=".$_SERVER['PHP_SELF']."></a> ".$row[5]."
    							<a class='fa fa-thumbs-o-down post-dislike' href=dislike.php?id=".$row[0]."&site=".$_SERVER['PHP_SELF']."></a> ".$row[6]."
    						    </div>";
    						if ('@'.$arr[1] == $row[1]) {
    							echo "<div class=col-xs-1>
    								<a class='btn btn-sm btn-danger pull-xs-right' href=".$_SERVER['PHP_SELF']."?id=".$row[0]." style='margin-top: 15px'>X</a>
    							</div>";
    						}
    						echo "</div></div>";
    					}
    				} else {
    					echo "<div class=card><div class='card-block'>
    					<h3 class='text-xs-center'>Be the first to write a post.</h3>
    					</div></div>";
    				}

    				mysql_free_result($result);
    			?>
    		</div>
        </div>

        <div class="col-xs-4">
    		<div class="container-fluid bg-faded" style="padding-top: 10px">
                Hello
            </div>
        </div>
    </body>
</html>
