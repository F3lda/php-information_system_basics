<pre>
<?php
require_once(__DIR__ . '/database/database.php');
require_once(__DIR__ . '/settings.php');


// connect to database
$database = new Database($db_host, $db_name, $db_username, $db_password);
$database->connect();





// Check if table exists
echo "CHECK AND CREATE TABLE\n";
$result = $database->execute("SELECT 1 FROM test_table LIMIT 1", []);
print_r($result);
if ($database->lastError() != 'OK') {
    // If not, create one
    $result = $database->execute("CREATE TABLE test_table (
        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        item_name VARCHAR(24),
        item_description VARCHAR(100),
        item_last_change TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        item_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        item_flags SET('NEW','USED','REMOVED')
        )", []);

    if ($database->lastError() == 'OK') {
        echo "\nTable created successfully!\n";
    } else {
        print_r($result);
    }
}



// INSERT item
echo "\nINSERT\n";
$query = "INSERT INTO test_table (item_name, item_description, item_last_change, item_created, item_flags) VALUES (:name, :description, now(), now(), 1)";
$data = ["name" => "testitem", "description" => "blablablabla"];
$result = $database->insert($query, $data);
print_r($result);



// UPDATE item
echo "\nUPDATE\n";
$query = "UPDATE test_table SET item_description = :description, item_flags = :flags WHERE id = (SELECT max(id) FROM test_table)";
$data = ["description" => "bslbslblsblslb +update", "flags" => 3];
$result = $database->execute($query, $data);
print_r($result);



// SELECT
echo "\nSELECT\n";
$query = "SELECT * FROM test_table WHERE item_name = :item";
$data = ["item" => "testitem"];
$result = $database->fetchAll($query, $data);
print_r($result);






// disconnect from database
$database->disconnect();

?>
</pre>



<br><br><br>
<button onclick="window.location.href='./../'" type="button">Back to list of examples</button>
