<?php
// HEAD + START BODY TAG
$cmpnt_html_head = ['title' => 'Home', 'css' => ['./frontend/css/styles.css'], 'js' => ['./frontend/js/common.js']];
include(__DIR__ .'/../../components/html_head.php');


// MENU
$cmpnt_menu['active'] = 'Home';
include(__DIR__ .'/../../components/menu.php');

?>
<h1>HOME</h1>
<a href="./home-article?article=200">Article 200</a>
