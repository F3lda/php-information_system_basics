<?php
$article_number = '';
if(isset($_GET["article"])) {
    $article_number = $_GET["article"];
}


// HEAD + START BODY TAG
$cmpnt_html_head = ['title' => 'Article '.$article_number, 'css' => ['./frontend/css/styles.css'], 'js' => ['./frontend/js/common.js']];
include(__DIR__ .'/../../../components/html_head.php');


// MENU
$cmpnt_menu['active'] = 'None';
include(__DIR__ .'/../../../components/menu.php');



echo "<h1>ARTICLE ".$article_number."</h1>";
?>
