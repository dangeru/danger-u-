<?php
$path    = "thread/";
if(is_dir($path))
{
	$threads = scandir($path,1);
}else
{
	echo "no";
}

?>
<!DOCTYPE HTML>
<html>

<head>
	<title>danger/u/ - dangerous opinions</title>
	<link rel="stylesheet" type="text/css" href="static/dangeru.css">
</head>

<body>
	<div id="sitecorner">
	     <img src="static/logo.png" alt="danger/u/">
	     <a href="new.php" id="newthread">Start a new thread</a>
	     <hr>
	     <?php
		for($i = 0; $i <= 35; $i++)
		{
			try
			{
				if(is_file($path . $threads[$i]))
				{
					$f = fopen($path . $threads[$i], 'r');
					$line = fgets($f);
					fclose($f);
					echo '<a href="thread.php?='.str_replace(".txt","",$threads[$i]).'">'.str_replace("|||","",$line).'</a>';
				}				
			}
			catch(Exception $e)
			{
				
			}				
		}		
	     ?>
	</div>
</body>

</html>