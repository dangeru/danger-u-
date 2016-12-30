<?php
//path to the thread folder
$path    = "thread/";
if(is_dir($path))
{
	$threads = scandir($path,1);
	natsort($threads);
	$threads = array_reverse($threads, false);
}else
{
	echo '<div id="redtext">The threads directory does not exist</div>';
}

//check if the start GET field isn't empty
if (!empty($_GET['start'])) {
	$startid = $_GET['start'];
} //if it is assign 0
else {
	$startid = 0;
}
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>danger/u/ - dangerous opinions</title>
	<link rel="stylesheet" type="text/css" href="static/dangeru.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="static/favicon.ico">
</head>

<body>
	<div id="boardcontainer">
	     <?php
			 		$boards = "BOARDS DIRECTORY";

					$results = scandir($boards);
					foreach ($results as $result) {
    				if ($result === '.' or $result === '..') continue;
						if ($result == "mobile") continue;
    				if (is_dir($boards . '/' . $result)) {
        			echo '<a href=http://boards.dangeru.us/' . $result . ' id="boardid">/' . $result . '/</a> ';
    				}
					}
			 ?>
	</div>
	<div id="sitecorner">
	     <a href="javascript:location.reload();"><img src="static/logo.png" alt="danger/a/"></a>
	     <a href="new.php" id="newthread">Start a new thread</a>
	     <hr>
	     <?php
			 $min = 0 + 35 * $startid;
			 $max = 35 + 35 * $startid;
		for($i = $min; $i <= $max; $i++)
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
			 <div id="pagecount_container">
				 <a href="index.php?start=0" id="pagecount">1</a>
				 <a href="index.php?start=1" id="pagecount">2</a>
				 <a href="index.php?start=2" id="pagecount">3</a>
			</div>
	</div>
</body>

</html>
