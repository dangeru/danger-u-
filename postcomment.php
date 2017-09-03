<?php
	$referer = $_SERVER['HTTP_REFERER'];
	$arr = explode("=", $referer, 2);
	$id = $arr[1];
	echo $id;
	//custom spam prevention code

	function spamCheck($comment, $id) {
			$spam = file_get_contents("thread/" . $id . ".txt");
			$spam = preg_replace("/[^A-Za-z0-9# \s\s+]/", " ", $spam);
			$spam = preg_replace("/\s\s(?<!#^)[a-zA-Z0-9\s]/", " ", $spam);
			$spam = preg_replace("/.#(?!=[0-9])(?=[A-Z a-z])/", "\n", $spam);
			$spamarray = explode("\n", $spam);
			end($spamarray);
			$spamarray[0] = filter_var(prev($spamarray), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$spamarray[1] = filter_var(prev($spamarray), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$str = "#" . preg_replace("/[^A-Za-z0-9 \s]/", "", trim(preg_replace('/\s\s+/', ' ', filter_var(html_entity_decode($comment), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH))));
			similar_text($spamarray[0], $spamarray[1], $percentage1);
			similar_text($spamarray[1], $spamarray[0], $percentage2);
			similar_text($str, $spamarray[0], $percentage3);
			similar_text($spamarray[0], $str, $percentage4);
			$percentage1 = ($percentage1+$percentage2)/2;
			$percentage2 = ($percentage3+$percentage4)/2;
	    if($percentage1 >= 65 && $percentage2 >= 65)
	    {
				header("Location: thread.php?=" . $id);
				die();
	    }
	    else
	    {

	   	}
		}

	//normal code block

	$body = preg_replace('/(&lt;|&gt;|&lt|&gt)/', '', $_POST['body']);

	$body = htmlspecialchars(preg_replace('/([0-9#][\x{20E3}])|[\x{00ae}\x{00a9}\x{203C}\x{2047}\x{2048}\x{2049}\x{3030}\x{303D}\x{2139}\x{2122}\x{3297}\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', html_entity_decode(strip_tags($body))), ENT_QUOTES, "UTF-8");
	$tripcode = crypt($_POST['q'], "your crypto shit");
	if(strlen($body) > 455)
	{
		header("Location: thread.php?=" . $id);
		die();
	}
	spamCheck($_POST['body'], $id);
	try
	{
		$threadhandle = fopen("thread/" . $id . ".txt","a");
		$body = preg_replace('/(~##ADMIN:(((you)))##|##ADMIN:(((you)))##)/i', '', $body);
		if($tripcode === "<yourtrip>")
		{
			fwrite($threadhandle, "~" . "##ADMIN:(((you)))##\n");
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
