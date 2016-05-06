<html>
	<head>
		<link rel="stylesheet" href="Resources/CSS/bootstrap.css"/>
		<link rel="stylesheet" href="Resources/CSS/style.css"/>
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
		<script src="Resources/JS/jquery.js"/></script>
		<script src="Resources/JS/bootstrap.js"/></script>
		<script src="Resources/JS/style.js"/></script>
	</head>

	<body>
		<?php
		// set the default timezone to use. Available since PHP 5.1
		date_default_timezone_set('UTC');
		// Prints something like: 2016-05-05 16:16:41
		//echo date('Y-m-d H:i:s');
		$date = date('Y-m-d h:i:s');
		?>

		<?php
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

			$post = mysql_escape_string($_POST['post']);
			$hashtags = mysql_escape_string($_POST['hashtags']);
			$tags = mysql_escape_string($_POST['tags']);
			if ($post != "") {
				$query = "INSERT INTO symbols (author, post, hashtags, tags, date) VALUES ('@$arr[1]', '$post', '$hashtags', '$tags', '$date')";
	     		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		 		echo "<meta http-equiv='refresh' content='0'>";
			}

			if (isset($_GET['id'])) {
				echo $_SERVER['PHP_SELF'];
	    		$query = "DELETE FROM symbols WHERE id = ".$_GET['id'];
	     		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
				$location = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
				echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
				exit;
			}

			mysql_close($connection);
		?>

		<nav class="navbar navbar-light bg-faded" id="navbar-main">
			<a class="navbar-brand" href="edit.php">Twitter</a>
            <a class="btn btn-primary-outline pull-xs-right" href="logout.php">Log Out</a>
		</nav>

		<div class="col-xs-8">
			<div class="container-fluid bg-faded" style="padding-top: 10px">
				<?php
					if (mysql_num_rows($result) > 0) {
						while($row = mysql_fetch_row($result)) {

						//	$dt1 = date('Y-m-d H:i:s');
							echo "<div class=card card-block><div class=container-fluid>
							<div class=col-xs-11>
								<p class=card-text>".$row[7]."</p>
								<h4 class=card-title>".$row[1]." <span class='text-info small'>".$row[3]."</span> <span class='text-muted small'>".$row[4]."</span></h4>
								<p class=card-text>".$row[2]."</p>
								<a class='fa fa-thumbs-o-up'></a> ".$row[5]."
								<a class='fa fa-thumbs-o-down'></a> ".$row[6]."
							</div>";


							if ('@'.$arr[1] == $row[1]) {
								echo "<div class=col-xs-1>
									<a class='btn btn-sm btn-danger pull-xs-right' href=".$_SERVER['PHP_SELF']."?id=".$row[0]." style='margin-top: 15px'>X</a>
								</div>";
							}
							echo "</div></div>";
						}
					}
					mysql_free_result($result);
				?>
			</div>
		</div>

		<div class="col-xs-4">
			<div class="container-fluid bg-faded" style="padding-top: 10px">
				<div class="card">
	                <h3 class="card-header bg-info text-xs-center">New Tweet</h3>
	                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
	                    <div class="card-block">
	                        <fieldset class="form-group">
								<input class="form-control" type="text" name="hashtags" placeholder="ex. #hashtags" style="margin-bottom: 10px"/>
	                            <input class="form-control" type="text" name="post" placeholder="ex. My Very Own Tweet" style="margin-bottom: 10px"/>
								<input class="form-control" type="text" name="tags" placeholder="ex. @tag-someone"/>
							</fieldset>
	                    </div>
	                    <div class="card-footer bg-faded text-xs-center">
	                        <input class="btn btn-info" type="submit" name="submit" value="Tweet"/>
	                    </div>
	                </form>
	            </div>
			</div>
		</div>
	</body>
</html>
