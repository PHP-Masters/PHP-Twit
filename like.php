<?php
    // pass in some data such as the database
    require("common.php");
    // open the connection - if can't, quit the program - like a try/catch statement
    $connection = mysql_connect($host, $username, $password) or die ("Unable to connect!");
    // connect to the database or quit if it can't
    mysql_select_db($dbname) or die ("Unable to select database!");

    // SQL code to return all the table rows (posts) that have a certain ID
    $query = "SELECT * FROM symbols WHERE id = ".$_GET['id'];
    // execute the query
    $result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());

    // loop through each of the returned rows
    while($row = mysql_fetch_row($result)) {
        // change the likes value  by adding one to it
        // write SQL code
        $command = "UPDATE symbols SET likes = ".($row[5] + 1)." WHERE id = ".$_GET['id'];
        // execute the code
        $result = mysql_query($command) or die ("Error in query: $command. ".mysql_error());
    }
    // free the result, then go back to the original page
    mysql_free_result($result);
    echo '<META HTTP-EQUIV="refresh" CONTENT=0;URL='.$_GET['site'].'>';
    die();
?>
