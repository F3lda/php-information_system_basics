<?php
//allow access from any client (public API)
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: origin, x-csrftoken, content-type, accept, x-requested-with');



require_once(__DIR__ . '/../../sql_database/database/database.php');
require_once(__DIR__ . '/../../sql_database/settings.php');







function return_error($error_text)
{
    return ['status' => 'ERROR', 'error' => $error_text];
}

function return_ok($data)
{
    return array_merge(['status' => 'OK'], $data);
}

function return_internal_error($error_text)
{
    //return ['status' => 'ERROR', 'error' => 'INTERNAL_ERROR'];
    return ['status' => 'ERROR', 'error' => 'INTERNAL_ERROR', 'error_desc' => $error_text]; // for debug
}





$received_data = json_decode(file_get_contents('php://input'), true);
if ($received_data == NULL) {
    if (isset($_POST["json"])) {
        $received_data = json_decode($_POST["json"], true);
    }
}





//response data
$return_data = ['status' => 'ERROR', 'error' => 'bad request'];
$return_code = 0;


$database = new Database($db_host, $db_name, $db_username, $db_password);
$database->connect();



//process the request
if (!empty($_GET['cmd'])) {
    switch ($_GET["cmd"]) {
        
        /* ********** LOGIN ********** */
        case 'insert':
            if (!empty($received_data['name']) && !empty($received_data['description'])) {

                $query = "INSERT INTO test_table (item_name, item_description, item_last_change, item_created, item_flags) VALUES (:name, :description, now(), now(), 1)";
                $data = ["name" => $received_data['name'], "description" => $received_data['description']];
                $result = $database->insert($query, $data);
                
                
                if ($database->lastError() == 'OK') {
                    $return_data = return_ok($result);
                } else {
                    $return_data = return_error($database->lastError());
                }
                
            } else {
                $return_data = return_error("Missing data!");
            }
            break;
        
        case 'getAll':
            $result = $database->fetchAll('SELECT * FROM test_table', []);

            if ($database->lastError() == 'OK') {
                $return_data = return_ok($result);
            } else {
                $return_data = return_error($database->lastError());
            }
            break;

        case 'getAllCount':
            $result = $database->fetchAll('SELECT COUNT(*) FROM test_table', []);

            if ($database->lastError() == 'OK') {
                $return_data = return_ok(['item_count' => $result[0]['COUNT(*)']]);
            } else {
                $return_data = return_error($database->lastError());
            }
            break;

    }
}



$database->disconnect();


// set exit code
if ($return_code == 0) {
    if ($return_data['status'] == 'OK') {
        $return_code = 200;
    } else if ($return_data['status'] == 'ERROR' && $return_data['error'] == 'INTERNAL_ERROR') {
        $return_code = 500;
    } else {
        $return_code = 400;
    }
}


//send the JSON result
http_response_code($return_code);
echo json_encode($return_data);

?>
