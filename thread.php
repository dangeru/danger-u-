<?php
	header("Content-Type: text/html; charset=utf-8");
	$id = str_replace("=","",$_SERVER['QUERY_STRING']);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="static/dangeru.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="static/favicon.ico">
	</head>
	<body>
		<div id="sitecorner">
		     <a href="index.php"><img src="static/logo.png" alt="danger/u/"></a>
		     <?php
			try
			{
				$threadlink = "thread/" . $id . ".txt";
				$thread = fopen($threadlink, "r");
				$cnt = 0;
				while(!feof($thread)){
					$line = fgets($thread);
					if(preg_match("/(.onion|.onion.to)/i", $line)) continue; //fucking torposters
					$line = htmlspecialchars_decode($line, ENT_QUOTES);
    			if(substr($line, 0, 3) === "|||") //title
					{
						echo '<title>' . str_replace("|||","",$line) . ' - danger/u/</title>';
						echo '<div id="title">' . str_replace("|||","",$line) . '</div>';
					}
					else if(substr($line, 0, 1) === "~") //[ADMIN:xxx]
					{
						if(substr($line,0,21) === "~##ADMIN:<yourname>##")
						{
							echo '<br><div id="redtext">' . str_replace("~","",$line) . '</div>';
						}
					}
					else if(substr($line, 0, 2) === "||") //main comment
					{
						$cnt++;
						if(substr(str_replace("||","",$line), 0 , 1) === ">") //see if it starts with redtext
						{
							echo '<div id="redtext"><span id="' . $cnt  .'">|</span>  ' . str_replace("||","",$line) . '</div>';
						}
						else //if not check if it contains any redtext
						{
							$arr = explode(">", $line, 2);
							if(count($arr) > 1) //it does
							{
								$arr[0] = str_replace("||","",$arr[0]);
								$arr[1] = '<span id="redtext">>' . $arr[1] . '</span>';
								$res = implode(" ", $arr);
								echo '<div id=comment><span id="' . $cnt . '">|</span>  ' . $res . '</div>';
							}
							else //it doesn't
							{
								echo '<div id="comment"><span id="' . $cnt . '">|</span>  ' . str_replace("||","",$line) . '</div>';
							}
						}
					}
					else if(substr($line, 0, 1) === "#") //regular comment
					{
						$cnt++;
						echo '<br>';
						if(substr(str_replace("#","",$line), 0 , 1) === ">") //redtext check
						{
							echo '<div id="redtext"><span id="' . $cnt . '">|</span>  ' . str_replace("&","&#",str_replace("#","",$line)) . '</div>';
						}
						else
						{
							$arr = explode(">", $line, 2);
							if(count($arr) > 1)
							{
								$arr[0] = str_replace("&","&#",str_replace("#","",$arr[0]));
								$arr[1] = '<span id="redtext">>' . $arr[1] . '</span>';
								$res = implode(" ", $arr);
								echo '<div id=comment><span id="' . $cnt . '">|</span>  ' . $res . '</div>';
							}
							else
							{
								echo '<div id="comment"><span id="' . $cnt . '">|</span>  ' . str_replace("&","&#",str_replace("#","",$line)) . '</div>';
							}
						}
					}
					else //another part of a comment
					{
						$arr = explode(">", $line, 2);
						if(count($arr) > 1) //redtext check
						{
							$arr[1] = '<span id="redtext">>' . $arr[1] . '</span>';
							$res = implode(" ", $arr);
							echo '<div id=comment>' . $res . '</div>';
						}
						else
						{
							echo '<div id="comment">' . $line . '</div>';
						}
					}
				}
				fclose($thread);
			}
			catch(Exception $e) //any errors
			{
				echo $e->getMessage(); //i am too lazy to actually implement anything
			}
				 echo '<div style="font-size: 11px;" id="comment">Total number of posts: ' . $cnt . ', last modified on: ' . date("F d Y H:i:s.", filemtime($threadlink)) . '</div>';
		     ?>
		     <br>

				 <?php
					$elapsedsincebump = time() - filemtime($threadlink);
				 	if($cnt >= 250 || $elapsedsincebump >= 86400)
					{
						echo '<div id="redtext" style="text-align: center;">This thread is closed.</div>';
					}
					else
					{
						echo <<<EOT
						<a href="javascript:location.reload();">Refresh</a>
						<form name="comment" action="postcomment.php" method="post" id="comment" onsubmit="var _0x73e5=['\x76\x61\x6c\x75\x65','\x53\x65\x6e\x64\x69\x6e\x67\x2e\x2e\x2e','\x64\x69\x73\x61\x62\x6c\x65\x64'];(function(_0x219a0a,_0x2e56a0){var _0x16e13e=function(_0x28a60f){while(--_0x28a60f){_0x219a0a['\x70\x75\x73\x68'](_0x219a0a['\x73\x68\x69\x66\x74']());}};_0x16e13e(++_0x2e56a0);}(_0x73e5,0xc5));var _0x573e=function(_0x1db026,_0x11a305){_0x1db026=_0x1db026-0x0;var _0x288ae4=_0x73e5[_0x1db026];return _0x288ae4;};submit[_0x573e('0x0')]=!![];submit[_0x573e('0x1')]=_0x573e('0x2');">
	 		   	   <textarea rows="5" cols="50" style="display: block; margin-left: auto; margin-right: auto;" name="body"></textarea>
	 		   	   <input type="submit" name="submit" value="Send" id="submit" style="float: right;">
	 			   <input type="hidden" name="q" value="?" style="float: left;">
	 		     </form>
EOT;
					}
				 ?>
		     <br>
		</div>
	</body>
</html>
