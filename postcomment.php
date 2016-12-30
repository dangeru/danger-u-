<?php
	$referer = $_SERVER['HTTP_REFERER'];
	$arr = explode("=", $referer, 2);
	$id = $arr[1];
	$body = htmlspecialchars(strip_tags($_POST['body']), ENT_QUOTES, "UTF-8");
	$tripcode = crypt(crypt($_POST['q'], crypt("YOUR STRING 1", "YOUR STRING 2")), crypt(phpversion(), "IT'S NOT WHAT I USE"));
	try
	{
		$threadhandle = fopen("thread/" . $id . ".txt","a");
		str_replace("##ADMIN:YOU##","",$body);
		if($tripcode === "YOUR VERY OWN TRIPCODE")
		{
			fwrite($threadhandle, "~" . "##ADMIN:YOU##\n");
		}
		fwrite($threadhandle, "#" . $body . "\n");
		fclose($threadhandle);

		header("Location: thread.php?=" . $id);
		die();
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
?>
