<?php
require_once(__DIR__ . '/../sql_database/database/database.php');
require_once(__DIR__ . '/../sql_database/settings.php');


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

        // INSERT item
        echo "\nINSERT\n";
        $query = "INSERT INTO test_table (item_name, item_description, item_last_change, item_created, item_flags) VALUES (:name, :description, now(), now(), 1)";
        $data = ["name" => "testitem32", "description" => "blablablabla adfg adgfadfg adfgadfg"];
        $result = $database->insert($query, $data);
        print_r($result);

        // INSERT item
        echo "\nINSERT\n";
        $query = "INSERT INTO test_table (item_name, item_description, item_last_change, item_created, item_flags) VALUES (:name, :description, now(), now(), 1)";
        $data = ["name" => "testitem8", "description" => "blablablabla adfg adgfadfadfg adfga dfgafg ag adfgadfg"];
        $result = $database->insert($query, $data);
        print_r($result);

        // INSERT item
        echo "\nINSERT\n";
        $query = "INSERT INTO test_table (item_name, item_description, item_last_change, item_created, item_flags) VALUES (:name, :description, now(), now(), 1)";
        $data = ["name" => "testitem12", "description" => "blablablabla adfg adfg adfg sdfg aadgfadfg adfgadfg"];
        $result = $database->insert($query, $data);
        print_r($result);

        // INSERT item
        echo "\nINSERT\n";
        $query = "INSERT INTO test_table (item_name, item_description, item_last_change, item_created, item_flags) VALUES (:name, :description, now(), now(), 1)";
        $data = ["name" => "testitem10", "description" => "blablablabla adfg adgfadfg addgadfg adfgafgadfg"];
        $result = $database->insert($query, $data);
        print_r($result);

        // INSERT item
        echo "\nINSERT\n";
        $query = "INSERT INTO test_table (item_name, item_description, item_last_change, item_created, item_flags) VALUES (:name, :description, now(), now(), 1)";
        $data = ["name" => "testitem11", "description" => "blablablabla adfg adgfadfg adfgadfda adfgagg"];
        $result = $database->insert($query, $data);
        print_r($result);

    } else {
        print_r($result);
    }
}




define('ITEMS_PER_PAGE', 3);



// sql rows limit
$data['page_number'] = 1;
$data['item_count'] = ITEMS_PER_PAGE;

if (isset($_GET['page_number'])) {
    $_GET['page_number'] += 0;
    if (is_int($_GET['page_number']) && $_GET['page_number'] > 0) {
        $data['page_number'] = $_GET['page_number'];
    }
}

if (isset($_GET['item_count'])) {
    $_GET['item_count'] += 0;
    if (is_int($_GET['item_count']) && $_GET['item_count'] > 0 && $_GET['item_count'] < 51 ) {
        $data['item_count'] = $_GET['item_count'];
    }
}

$data['item_limit'] = $data['page_number']*$data['item_count'];




// get and slice rows
$result = $database->fetchAll('SELECT * FROM test_table LIMIT '.$data['item_limit'], []);
if ($database->lastError() !== 'OK') {
    die($database->lasterror());
}


if ($data['page_number'] > 1) {
    $slice_count = ($data['page_number']-1)*$data['item_count'];
    $result = array_slice($result, $slice_count);
}




// print data
echo "<pre>";
print_r($result);
echo "</pre>";




// get all rows count
$result = $database->fetchAll('SELECT COUNT(*) FROM test_table', []);
if ($database->lastError() == 'OK') {
    $result = ['item_count' => $result[0]['COUNT(*)']];
} else {
    die($database->lastError());
}




// print pages
$pages_count = ceil($result["item_count"]/$data['item_count']);

echo "Pages: ";
for($i = 1; $i <= $pages_count; $i++)
{
    echo '<a href="./?page_number='.$i.'&item_count='.$data['item_count'].'">'.$i.'</a> ';
}


echo '<br>Items count: <input type="number" name="item_count" min="1" max="100" value="'.$data['item_count'].'" onchange="window.location.href = \'./?item_count=\'+this.value;">';
?>



<br><br><br>
<button onclick="window.location.href='./../'" type="button">Back to list of examples</button>
