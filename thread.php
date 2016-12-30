<?php
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
					$line = htmlspecialchars_decode($line, ENT_QUOTES);
    			if(substr($line, 0, 3) === "|||") //title
					{
						echo '<title>' . str_replace("|||","",$line) . ' - danger/u/</title>';
						echo '<div id="title">' . str_replace("|||","",$line) . '</div>';
					}
					else if(substr($line, 0, 1) === "~") //[ADMIN:xxx]
					{
						if(substr($line,0,21) === "~##ADMIN:prefetcher##")
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
		     ?>
		     <br>
		     <a href="javascript:location.reload();">Refresh</a>
		     <form name="comment" action="postcomment.php" method="post">
		   	   <textarea rows="5" cols="50" style="display: block; margin-left: auto; margin-right: auto;" name="body"></textarea>
		   	   <input type="submit" name="submit" value="Send" style="float: right;">
			   <input type="hidden" name="q" value="?" style="float: left;">
		     </form>
		     <br>
		</div>
	</body>
</html>
