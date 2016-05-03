<html>
	<body>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

		<div class="panel panel-primary">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Twitter</div>
		  <div class="panel-body">
		    <p>Type anything you want. Tweet Away!</p>
		  </div>

		  <!-- Table -->
		  <table class="Twitter">
			<body>

		    <!-- This is the HTML form -->

			<?php

				// set database server access variables:
				$host = "localhost";
				$user = "root";
				$pass = "root";
				$db = "testdb";

				// open connection
				$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!");

				// select database
				mysql_select_db($db) or die ("Unable to select database!");

				// create query
				$query = "SELECT * FROM symbols";

				// execute query
				$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());

				// see if any rows were returned
				if (mysql_num_rows($result) > 0) {

		    		// print them one after another
		    		echo "<table class='table' cellpadding=10 border=1>";
		    		while($row = mysql_fetch_row($result)) {
		        		echo "<tr>";
		        		echo "<td>" . $row[1]."</td>";
		        		echo "<td>".$row[2]."</td>";
						echo "<td><a href=".$_SERVER['PHP_SELF']."?id=".$row[0].">Delete</a></td>";
		        		echo "</tr>";
		    		}
				    echo "</table>";

				} else {

		    		// print status message
		    		echo "No rows found!";
				}

				// free result set memory
				mysql_free_result($result);

				// set variable values to HTML form inputs
				$hashtag = mysql_escape_string($_POST['hashtag']);
		    	$tweet = mysql_escape_string($_POST['tweet']);

				// check to see if user has entered anything
				if ($tweet != "") {
			 		// build SQL query
					$query = "INSERT INTO symbols (hashtag, tweet) VALUES ('$hashtag', '$tweet')";
					// run the query
		     		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
					// refresh the page to show new update
			 		echo "<meta http-equiv='refresh' content='0'>";
				}

				// if DELETE pressed, set an id, if id is set then delete it from DB
				if (isset($_GET['id'])) {

					// create query to delete record
					echo $_SERVER['PHP_SELF'];
		    		$query = "DELETE FROM symbols WHERE id = ".$_GET['id'];

					// run the query
		     		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());

					// reset the url to remove id $_GET variable
					$location = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
					echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
					exit;

				}

				// close connection
				mysql_close($connection);

			?>

		  </table>
		</div>

    <!-- This is the HTML form that appears in the browser -->
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<br />
			<div class="input-group">
    		<span class="input-group-addon"/span>
  			<input type="text" class="form-control" name="hashtag" placeholder="Hashtag" aria-describedby="basic-addon2" value="<?php echo $submitted_hashtag; ?>" >
			</div>
    	<br />
    	<div class="input-group">
    		<span class="input-group-addon"/span>
  			<input type="text" class="form-control" name="tweet" placeholder="Tweet" aria-describedby="basic-addon2" value="<?php echo $submitted_tweet; ?>" />
			</div>
    	<br />
    	<div class="btn-group" role="group" aria-label="...">
    		<button type="submit" value="Edit" class="btn btn-default"><font color="blue">Submit</font></button>
        <button type="button" formaction="logout.php" value="Edit" class="btn btn-default"><a href="logout.php"><font color="blue">Log out</font></a></button>
    	</div>
    </form>

	</body>
</html>
