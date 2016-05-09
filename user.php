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
        <nav class="navbar navbar-light bg-faded" id="navbar-main">
			<a class="navbar-brand" href="index.php">Tweeter</a>
			<ul class="nav navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="search.php">Search</a>
				</li>
			</ul>
            <a class="btn btn-primary-outline pull-xs-right" href="logout.php">Log Out</a>
		</nav>

        <?php
            date_default_timezone_set('America/Toronto');
            $date = date('Y-m-d H:i:s');

            require("common.php");
            if(empty($_SESSION['user'])) {
                $location = "http://" . $_SERVER['HTTP_HOST'] . "/login.php";
                echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=http://localhost:8888/PHP-Twit/home.php">';
                die("Redirecting to login.php");
            }
            $arr = array_values($_SESSION['user']);
            $connection = mysql_connect($host, $username, $password) or die ("Unable to connect!");
            mysql_select_db($dbname) or die ("Unable to select database!");
            $query = "SELECT * FROM symbols ORDER BY id DESC";
            $result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
        ?>
        <div class="container-fluid">
            <div class="container-fluid bg-faded" style="padding-top: 10px">
                <?php
                    $returned = false;
                    $user = "@".mysql_escape_string($_GET['user']);
    				while($row = mysql_fetch_row($result)) {
                        if ($user == $row[1] || strpos($row[4], $user) !== false) {
                            $returned = true;
                            $hashtags = explode(" ", $row[3]);
                            $usertags = explode(" ", $row[4]);
                            echo "<div class=card card-block><div class=container-fluid>
                            <div class=col-xs-11>
                                <br />
                                <h4 class=card-title><a class=author-link href=http://localhost:8888/PHP-Twit/user.php?user=".substr($row[1], 1).">".$row[1]."</a>
                                <span class='small'>";
                                foreach ($hashtags as $line) {
                                    echo "<a class=hashtag-link href=http://localhost:8888/PHP-Twit/hashtag.php?hashtag=".substr($line, 1).">".$line." </a>";
                                }
                                echo "</span><span class='small'>";
                                foreach ($usertags as $line) {
                                    echo "<a class=usertag-link href=http://localhost:8888/PHP-Twit/user.php?user=".substr($line, 1).">".$line." </a>";
                                }
                                echo "</span><span class='card-text small pull-xs-right'>".$row[7]."</span></h4>
                                <p class=card-text>".$row[2]."</p>
                                <a class='fa fa-thumbs-o-up post-like'></a> ".$row[5]."
                                <a class='fa fa-thumbs-o-down post-dislike'></a> ".$row[6]."
                                <br />
                            </div>";
                            if ('@'.$arr[1] == $row[1]) {
                                echo "<div class=col-xs-1>
                                    <a class='btn btn-sm btn-danger pull-xs-right' href=".$_SERVER['PHP_SELF']."?id=".$row[0]." style='margin-top: 15px'>X</a>
                                </div>";
                            }
                            echo "</div></div>";
                        }
    				}
                    if (!$returned) {
                        echo "<div class=card><div class='card-block'>
                        <h3 class='text-xs-center'>No posts were returned.</h3>
                        </div></div>";
                    }
    				mysql_free_result($result);
    			?>
            </div>
        </div>
    </body>
</html>
