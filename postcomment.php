<?php
	$referer = $_SERVER['HTTP_REFERER'];
	$arr = explode("=", $referer, 2);
	$id = $arr[1];
	echo $id;
	//custom spam prevention code

	function tailCustom($filepath, $lines = 1, $adaptive = true) {
		// Open file
		$f = @fopen($filepath, "rb");
		if ($f === false) return false;
		// Sets buffer size, according to the number of lines to retrieve.
		// This gives a performance boost when reading a few lines from the file.
		if (!$adaptive) $buffer = 4096;
		else $buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));
		// Jump to last character
		fseek($f, -1, SEEK_END);
		// Read it and adjust line number if necessary
		// (Otherwise the result would be wrong if file doesn't end with a blank line)
		if (fread($f, 1) != "\n") $lines -= 1;

		// Start reading
		$output = '';
		$chunk = '';
		// While we would like more
		while (ftell($f) > 0 && $lines >= 0) {
			// Figure out how far back we should jump
			$seek = min(ftell($f), $buffer);
			// Do the jump (backwards, relative to where we are)
			fseek($f, -$seek, SEEK_CUR);
			// Read a chunk and prepend it to our output
			$output = ($chunk = fread($f, $seek)) . $output;
			// Jump back to where we started reading
			fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);
			// Decrease our line counter
			$lines -= substr_count($chunk, "\n");
		}
		// While we have too many lines
		// (Because of buffer size we might have read too many)
		while ($lines++ < 0) {
			// Find first newline and remove all text before that
			$output = substr($output, strpos($output, "\n") + 1);
		}
		// Close file and return
		fclose($f);
		return trim($output);
	}

	function spamCheck($comment, $id) {
			$spam = tailCustom("thread/" . $id . ".txt", 2);
			$spamarray = explode("\n", $spam, 2);
			$spamarray[0] = trim(preg_replace('/\s\s+/', ' ', filter_var($spamarray[0], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)));
			$spamarray[1] = trim(preg_replace('/\s\s+/', ' ', filter_var($spamarray[1], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)));
			$str = trim(preg_replace('/\s\s+/', ' ', filter_var(html_entity_decode($comment), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)));
	    if(strcasecmp($spamarray[0], $spamarray[1]) === 0 && strcasecmp($spamarray[0], "#" . $str) === 0)
	    {
				header("Location: thread.php?=" . $id);
				die();
	    }
	    else
	    {

	    }
		}

	//normal code block

	$body = htmlspecialchars(preg_replace('/([0-9#][\x{20E3}])|[\x{00ae}\x{00a9}\x{203C}\x{2047}\x{2048}\x{2049}\x{3030}\x{303D}\x{2139}\x{2122}\x{3297}\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', html_entity_decode(strip_tags($_POST['body']))), ENT_QUOTES, "UTF-8");
	$tripcode = crypt(crypt($_POST['q'], crypt("stop", "dissing")), crypt(phpversion(), "my fly girl"));
	spamCheck($_POST['body'], $id);
	try
	{
		$threadhandle = fopen("thread/" . $id . ".txt","a");
		$body = preg_replace('/(~##ADMIN:prefetcher##|~##MOD:Anon E##|##ADMIN:prefetcher##|##MOD:Anon E##)/i', '', $body);
		if($tripcode === "R1WsmOljr95kM")
		{
			fwrite($threadhandle, "~" . "##ADMIN:prefetcher##\n");
		}
		else if($tripcode === "R1jZ254IsKgDU")
		{
			fwrite($threadhandle, "~" . "##MOD:Anon E##\n");
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
