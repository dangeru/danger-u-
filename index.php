<?php
$path    = "thread/";
if(is_dir($path))
{
	$threads = scandir($path,1);
}else
{
	echo "no";
}

natsort($threads);
$threads = array_reverse($threads, false);
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>danger/u/ - dangerous opinions</title>
	<link rel="stylesheet" type="text/css" href="static/dangeru.css">
</head>

<body>
	<div id="boardcontainer">
	     <a id="boardid" href="http://dangeru.us/a">/a/</a> 
	     <a id="boardid" href="http://dangeru.us/burg/">/burg/</a> 
	     <a id="boardid" href="http://dangeru.us/">/u/</a> 
	     <a id="boardid" href="http://dangeru.us/new/">/new/</a> 
	     <a id="boardid" href="http://dangeru.us/v/">/v/</a>
	</div>
	<div id="sitecorner">
	     <a href="javascript:location.reload();"><img src="static/logo.png" alt="danger/u/"></a>
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