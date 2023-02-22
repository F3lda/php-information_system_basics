<pre>
<?php
require_once(__DIR__ . '/../sql_database/database/database.php');
require_once(__DIR__ . '/../sql_database/settings.php');
require_once(__DIR__ . '/auth/auth.php');


// connect to database
$database = new Database($db_host, $db_name, $db_username, $db_password);
$database->connect();

$auth = new Auth($database);



// Check if table exists
echo "CHECK AND CREATE TABLE\n";
$result = $database->execute("SELECT 1 FROM users LIMIT 1", []);
print_r($result);
if ($database->lastError() != 'OK') {
    // If not, create one
    $result = $database->execute("CREATE TABLE users (
        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        username VARCHAR(24),
        password VARCHAR(255), /* The password_hash documentation recommends columns length of 255 characters */
        type VARCHAR(24),
        item_last_change TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        item_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )", []);

    if ($database->lastError() == 'OK') {
        echo "\nTable created successfully!\n";

        // INSERT item
        echo "\nINSERT\n";
        $query = "INSERT INTO users (username, password, type, item_last_change, item_created) VALUES (:name, :pass, 'admin', now(), now())";
        $data = ["name" => "admin", "pass" => password_hash("admin", PASSWORD_DEFAULT)];
        $result = $database->insert($query, $data);
        print_r($result);

        // INSERT item
        echo "\nINSERT\n";
        $query = "INSERT INTO users (username, password, type, item_last_change, item_created) VALUES (:name, :pass, 'user', now(), now())";
        $data = ["name" => "user", "pass" => password_hash("user", PASSWORD_DEFAULT)];
        $result = $database->insert($query, $data);
        print_r($result);

    } else {
        print_r($result);
    }
}


echo "</pre>";



// logout
if (isset($_GET['logout'])) {
    $auth->logout();

    // redirect
    header('Location: ./', true, 301);
    die();
}



// Auth Check
if (isset($_POST["login"])) {

    if (!isset($_POST["login"]) || empty($_POST["username"]) || empty($_POST["password"])) {
        
        header('Location: ./', true, 301);
        die();

    } else {

        $result = $auth->login($_POST["username"], $_POST["password"]);
        if (is_string($result)) {
            echo $result;
            die();
        } else if ($result == false) {
            echo "<p>Wrong username or password!</p>";
        }
    }
}

// UI
if ($auth->is_logged_in()) {

    echo "<h1>User: ". $auth->get_logged_in()["user_name"] ."</h1>";
    echo "<a href='./?logout'>Log out</a>";

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




// disconnect from database
$database->disconnect();

?>



<br><br><br>
<button onclick="window.location.href='./../'" type="button">Back to list of examples</button>
