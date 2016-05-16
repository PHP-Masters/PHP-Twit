<?php
    // pass in some info such as the database
    require("common.php");
    // open the connection or end the program if you can't: like try catch
    $connection = mysql_connect($host, $username, $password) or die ("Unable to connect!");
    // connect to the database or quit the program
    mysql_select_db($dbname) or die ("Unable to select database!");

    // create an sql query that will select all the items from the table "symbols" that have the desired ID
    $query = "SELECT * FROM symbols WHERE id = ".$_GET['id'];
    // run the query
    $result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());

    // loop through each of the returned table rows
    while($row = mysql_fetch_row($result)) {
        // change the value in that row for dislikes by adding one
        $command = "UPDATE symbols SET dislikes = ".($row[6] + 1)." WHERE id = ".$_GET['id'];
        // run that above code
        $result = mysql_query($command) or die ("Error in query: $command. ".mysql_error());
    }
    // free result set memory
    mysql_free_result($result);
    // go back to the original page
    echo '<META HTTP-EQUIV="refresh" CONTENT=0;URL='.$_GET['site'].'>';
    die();
?>
