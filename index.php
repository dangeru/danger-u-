<?php
header("Content-Type: text/html; charset=utf-8");
//path to the thread folder
$path    = "thread/";
if(is_dir($path))
{
	$files = glob($path . '*.txt');
	usort($files, create_function('$a,$b', 'return filemtime($a)<filemtime($b);'));
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
	<link rel="stylesheet" type="text/css" href="../static/dangeru.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="static/favicon.ico">
</head>

<body>
	<div id="boardcontainer">
	     <?php
			 		$boards = "./";

					$results = scandir($boards);
					foreach ($results as $result) {
    				if ($result === '.' or $result === '..') continue;
						if ($result == "mobile") continue;
						if ($result == "static") continue;
						if (strpos($result, 'well-known') !== false) continue;
    				if (is_dir($boards . '/' . $result)) {
        			echo '<a href=/' . $result . ' id="boardid">/' . $result . '/</a> ';
    				}
					}
			 ?>
	</div>
	<div id="sitecorner">
			<?php
		 		$banners = scandir("./static/banners/<boardname>");
		 		unset($banners[0]);
		 		unset($banners[1]);
		 		$banners = array_values($banners);
		 		$randomfile = $banners[array_rand($banners)];
				echo '<a href="javascript:location.reload();"><img src="../static/banners/<boardname>/' . $randomfile . '" alt="danger/u/"></a>';
			?>
	     <a href="new.php" id="newthread">Start a new thread</a>
	     <hr>
	     <?php
			 $min = 0 + 35 * $startid;
			 $max = 35 + 35 * $startid;
			 for($i = $min; $i <= $max; $i++)
	 		{
	 			try
	 			{
	 				if(is_file($files[$i]))
	 				{
	 					$f = fopen($files[$i], 'r');
	 					$line = fgets($f);
	 					fclose($f);
	 					$tmp = str_replace("thread/","",$files[$i]);
						$elapsedsincebump = time() - filemtime($files[$i]);
						if(strlen($line) < 5)
						{
							$max++;
							continue;
						}
						if($elapsedsincebump >= 86400) {echo '<a style="color: #7a7a7a;" href="thread.php?='.str_replace(".txt","",$tmp).'">'.str_replace("|||","",$line).'</a>';}
						else {echo '<a href="thread.php?='.str_replace(".txt","",$tmp).'">'.str_replace("|||","",$line).'</a>';}

	 				}
	 			}
	 			catch(Exception $e)
	 			{
	 				echo $e;
	 			}
	 		}
	     ?>
			 <div id="pagecount_container">
				 <a href="index.php?start=0" id="pagecount">1</a>
				 <a href="index.php?start=1" id="pagecount">2</a>
				 <a href="index.php?start=2" id="pagecount">3</a>
			</div>
	</div>
	<footer id="comment" style="font-size: xx-small; text-align: center;">
		&copy; 2016-<?php echo date("Y"); ?> prefetcher & github commiters. affiliated with <a href="http://re.wire.zone/" style="font-size: x-small; display: inline-block; ">re:wire</a>.
	</footer>
</body>

</html>
