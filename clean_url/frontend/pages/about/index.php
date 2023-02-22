<?php
// HEAD + START BODY TAG
$cmpnt_html_head = ['title' => 'About', 'css' => ['./frontend/css/styles.css'], 'js' => ['./frontend/js/common.js']];
include(__DIR__ .'/../../components/html_head.php');


// MENU
$cmpnt_menu['active'] = 'About';
include(__DIR__ .'/../../components/menu.php');

?>
<h1>ABOUT</h1>
