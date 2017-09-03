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

	if(!isset($title))
	{
		header("Location: new.php");
		die();
	}

	if(strlen($title) < 5)
	{
		header("Location: new.php");
		die();
	}

	$titlecheck = fopen($path . (string)$latestthread . ".txt", "r");
	$pasttitle = fgets($titlecheck);
	fclose($titlecheck);
	similar_text(trim(preg_replace('/\s\s+/', ' ', $pasttitle)), "|||" . $title, $percentage);
	similar_text("|||" . $title, trim(preg_replace('/\s\s+/', ' ', $pasttitle)), $percentage1);
	similar_text(strrev(trim(preg_replace('/\s\s+/', ' ', $pasttitle))), "|||" . $title, $percentage2);
	similar_text(strrev("|||" . $title), trim(preg_replace('/\s\s+/', ' ', $pasttitle)), $percentage3);
	similar_text(substr(trim(preg_replace('/\s\s+/', ' ', $pasttitle)), 0, 8), "|||" . $title, $percentage4);
	similar_text(substr("|||" . $title, 0, 8), trim(preg_replace('/\s\s+/', ' ', $pasttitle)), $percentage5);
	$percentage = ($percentage + $percentage1)/2;
	$percentage2 = ($percentage2 + $percentage3)/2;
	$percentage3 = ($percentage4 + $percentage5)/2;
	if($percentage >= 65 || $percentage2 >= 65 || $percentage3 >= 65)
	{
		header("Location: new.php");
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
	if(strlen($title) > 47)
	{
		header("Location: new.php");
		die();
	}
	$body = preg_replace('/(&lt;|&gt;|&lt|&gt)/', '', $_POST['body']);
	$body = htmlspecialchars(strip_tags($body), ENT_QUOTES, "UTF-8");
	if(strlen($body) > 455)
	{
		fclose($newthread_file);
		die();
	}
	fwrite($newthread_file, "|||" . $title . "\n");
	fwrite($newthread_file, "||" . $body . "\n");
	fclose($newthread_file);

	header("Location: thread.php?=".(string)$latestthread);
	die();
	}
	catch (Exception $e)
	{
		echo $e->getMessage();
	}
?>
