<?php
	$id = $_POST['id'];
	$body = htmlspecialchars(strip_tags($_POST['body']));

	try
	{
		$threadhandle = fopen("thread/" . $id . ".txt","a");
		fwrite($threadhandle, "#" . $body . "\n");
		fclose($threadhandle);

		header("Location: http://dangeru.rf.gd/thread.php?=" . $id);
		die();	
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}	
?>