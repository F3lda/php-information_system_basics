<?php
$page_file = "home";
$page_title = "Home";

$args = explode('/?/', utf8_decode(urldecode($_SERVER['REQUEST_URI'])));
$query_args = null;
if(count($args) == 2){
	$query_args = explode('/',$args[1]);
	
	echo $args[1]."<br>";
	echo count($query_args)."<br><pre>";
	print_r($query_args);
    echo "</pre><br>";

    if(count($query_args) > 0){
        $page_file = $query_args[0];
        $page_title = ucfirst($query_args[0]);
        if(count($query_args) > 1){
            $page_title .= ' '.$query_args[1];
        }
    }
}

?>


<nav>
    <h1><a href="./?/<?php echo $page_file; ?>"><?php echo $page_title; ?></a></h1>
    <ul>
        <li><a <?php if($page_title == 'Home') {echo 'style="color:red;"';} ?> href="./?/home">Home</a></li>
        <li><a <?php if($page_title == 'About') {echo 'style="color:red;"';} ?> href="./?/about">About</a></li>
        <li><a <?php if($page_title == 'Login') {echo 'style="color:red;"';} ?> href="./?/login">Login</a></li>
        <li><a <?php if($page_title == 'Article') {echo 'style="color:red;"';} ?> href="./?/article/255">Article</a></li>
    </ul>
</nav>



<br><br><br>
<button onclick="window.location.href='./../'" type="button">Back to list of examples</button>
