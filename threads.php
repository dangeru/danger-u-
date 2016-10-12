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
for($i = 0; $i <= 35; $i++)
{
	try
	{
		if(is_file($path . $threads[$i]))
		{
			$f = fopen($path . $threads[$i], 'r');
			$line = fgets($f);
			fclose($f);
			echo str_replace(".txt","",$threads[$i]).'#'.str_replace("|||","",$line).PHP_EOL;
		}				
	}
	catch(Exception $e)
	{
				
	}				
}		
?>
