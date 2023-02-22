<?php
//-------------------
$username = "admin";
$password = "admin";
//-------------------



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = "";
    $_SESSION['user_name'] = "";
    $_SESSION['user_type'] = "";
}

// logout
if (isset($_GET['logout'])) {
    $_SESSION['user_id'] = "";
    $_SESSION['user_name'] = "";
    $_SESSION['user_type'] = "";

    // redirect
    header('Location: ./', true, 301);
    die();
}



// LOGGED IN
if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != "") {

    // API
    if (isset($_GET["cmd"])) {

        $file = "./file.txt";

        switch ($_GET["cmd"]) {
        
            case 'load':
                echo file_get_contents($file);
                break;
            
            case 'save':
                if (!empty($_POST["file"])) {
                    $content = $_POST["file"];
                    file_put_contents($file, $content);
                } else {
                    echo "ERROR - Empty value";
                }
                break;
            
            default:
                echo "ERROR - Uknown command";
                break;
        }

    // PAGE
    } else {
        echo "<h1>User: ".$_SESSION['user_name']."</h1>";
        echo "<a href='./secret_page/'>Go to Secret page</a><br><br>";
        echo "<a href='./?logout'>Log out</a>";
    }

// NOT LOGGED IN
} else {

    // Login
    if (isset($_POST["login"])) {
        if (!isset($_POST["login"]) || empty($_POST["username"]) || empty($_POST["password"])
        || ($_POST["username"] != $username || $_POST["password"] != $password)) {
            
            // Invalid login
            // redirect
            header('Location: ./', true, 301);
            die();

        } else {
            // OK login
            $_SESSION['user_id'] = "1";
            $_SESSION['user_name'] = $_POST["username"];
            $_SESSION['user_type'] = "admin";

            // redirect
            header('Location: ./', true, 301);
            die();
        }

    // Unauthorized
    } else if (count($_POST) > 0 || count($_GET) > 0) {

        echo "ERROR - Unauthorized";
        http_response_code(401);

    // Login page
    } else {
        ?>

        <h1>Auth example</h1>
        <form method="post" action="./">
          <div>
            <label>Username</label>
            <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
          </div>
          <div>
            <label>Password</label>
            <input type="password" name="password" required />
          </div>
          <button type="submit" name="login" value="login">Log In</button>
        </form>
		
        <?php
    }
}
?>



<br><br><br>
<button onclick="window.location.href='./../'" type="button">Back to list of examples</button>
