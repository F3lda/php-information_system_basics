<!DOCTYPE html>
<html>
	<head>
		<title>PHP - Information system basics</title>
	</head>
	<body>
		<h1>PHP - Information system basics</h1>
		<ul>
			<?php 
				foreach (array_diff(scandir('.'), array('.', '..', 'index.php')) as $item)
				{
					echo '<li><a href="./'.$item.'">'.$item.'</a></li>';
				}
			?>
		</ul>
	</body>
</html>
