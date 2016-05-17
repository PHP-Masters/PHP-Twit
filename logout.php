<?php
    /*
    authors: julian.samek, isaac.ng, alex.kazakov, simon.osak
    date: 2016-05-16
    version: 1.0.0
    logout.php: pretty simple - logs you out of the website when your are done with it
    */
?>

<?php
    // First we execute our common code to connection to the database and start the session
    require("common.php");
    // We remove the user's data from the session
    unset($_SESSION['user']);
    // We redirect them to the login page
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=home.php">';
    exit;
?>
