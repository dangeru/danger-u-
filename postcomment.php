<?php
	$id = $_POST['id'];
	$body = htmlspecialchars($_POST['body'], ENT_QUOTES, "UTF-8");

	try
	{
		$threadhandle = fopen("thread/" . $id . ".txt","a");
		fwrite($threadhandle, "#" . $body . "\n");
		fclose($threadhandle);

		header("Location: http://dangeru.us/thread.php?=" . $id);
		die();	
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}	
?>
