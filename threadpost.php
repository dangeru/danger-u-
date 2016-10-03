<?php
	function customError($errno, $errstr) {
  		 echo "<b>Error:</b> [$errno] $errstr";
  		 die();
	}

	set_error_handler("customError");
	$path = "thread/";
	$threadlist = scandir($path,1);
	natsort($threadlist);	
	$threadlist = array_reverse($threadlist, false);
	if($threadlist[0] === "index.html") //just in case someone has a index.html file in their thread folder
	{
		unset($threadlist[0]);
		$threadlist = array_values($threadlist);
	}
	$latestthread = (int)str_replace("thread/","",str_replace(".txt","",$path . $threadlist[0]));
	
	$title = $_POST['title'];	

	$titlecheck = fopen($path . (string)$latestthread . ".txt", "r");
	$pasttitle = fgets($titlecheck);
	fclose($titlecheck);
	if(strcasecmp($_POST['title'],str_replace("|||","",$pasttitle)) == -1)
	{
		header("Location: http://dangeru.us/new.php");
		die("yes");
	}	
	else
	{
	}
	$latestthread += 1;
	$filepath = $path . (string)$latestthread . ".txt";
	try
	{
	$newthread_file = fopen($filepath,"w+");
	
	$title = strip_tags($_POST['title']);
	if(strlen($title) > 110)
	{
		header("Location: http://dangeru.us/new.php");
		die();		
	}	
	$body = htmlspecialchars(strip_tags($_POST['body']), ENT_QUOTES, "UTF-8");

	fwrite($newthread_file, "|||" . $title . "\n");	
	fwrite($newthread_file, "||" . $body . "\n");
	fclose($newthread_file);

	header("Location: http://dangeru.us/thread.php?=".(string)$latestthread);
	die();	
	}	
	catch (Exception $e)
	{
		echo $e->getMessage();
	}	
?>