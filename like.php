<?php
    require("common.php");
    $arr = array_values($_SESSION['user']);
    $connection = mysql_connect($host, $username, $password) or die ("Unable to connect!");
    mysql_select_db($dbname) or die ("Unable to select database!");
    $query = "SELECT * FROM symbols WHERE id = ".$_GET['id'];
    $result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
    while($row = mysql_fetch_row($result)) {
        $command = "UPDATE symbols SET likes = ".($row[5] + 1)." WHERE id = ".$_GET['id'];
        $result = mysql_query($command) or die ("Error in query: $command. ".mysql_error());
    }
    mysql_free_result($result);
    echo '<META HTTP-EQUIV="refresh" CONTENT=0;URL=http://localhost:8888'.$_GET['site'].'>';
    die();
?>
