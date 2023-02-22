<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $cmpnt_html_head['title']; ?></title>
    
    <?php 
    foreach ($cmpnt_html_head['css'] as $link) {
        echo '<link rel="stylesheet" href="'. $link .'">'. PHP_EOL .'   ';
    }
    ?>
    
    <?php 
    foreach ($cmpnt_html_head['js'] as $link) {
        echo '<script src="'. $link .'" type="text/javascript"></script>'. PHP_EOL .'   ';
    }
    ?>

</head>
<body>
