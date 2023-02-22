<?php
// SAVE CMD
$get_cmd = '';
if (isset($_GET['cmd'])) {
    $get_cmd = $_GET['cmd'];
}



// PAGE
$pages = [
    'home',
    'home-article',
    'about',
    'login'
];

$PAGE = 'home'; // default page
if (isset($_GET['page'])) {
    if (in_array($_GET['page'], $pages)) {
        $PAGE = $_GET['page'];
    }
}

$PAGE = str_replace("-", "/", $PAGE);

$cmpnt_menu = ['title' => 'PHP - Clean URL example'];
include('./frontend/pages/'.$PAGE.'/index.php');



// PHP FILES
$_GET['cmd'] = $get_cmd;

// BODY END
echo PHP_EOL . '</body>' . PHP_EOL . '</html>' . PHP_EOL;

?>



<br><br><br>
<button onclick="window.location.href='./../'" type="button">Back to list of examples</button>
