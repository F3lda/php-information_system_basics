<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// secret page
if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != "") {

    echo "<h1>Secret page!</h1>";
    echo "<a href='./../'>Back to Home page</a><br><br>";
    echo "<a href='./../?logout'>Log out</a>";

} else {

    echo "ERROR - Unauthorized<br>";
    echo "<a href='./../'>Back to Home page</a><br><br>";
    http_response_code(401);

}

?>
