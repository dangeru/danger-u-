<?php
	$id = str_replace("=","",$_SERVER['QUERY_STRING']);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>danger/u/ - dangerous opinions</title>
		<link rel="stylesheet" type="text/css" href="static/dangeru.css">
	</head>
	<body>
		<div id="sitecorner">
		     <a href="index.php"><img src="static/logo.png" alt="danger/u/"></a>
		     <?php
			try
			{
				$threadlink = "thread/" . $id . ".txt";
				$thread = fopen($threadlink, "r");
				while(!feof($thread)){
					$line = fgets($thread);
    					if(substr($line, 0, 3) === "|||")
					{
						echo '<div id="title">' . str_replace("|||","",$line) . '</div>';
					} else if(substr($line, 0, 2) === "||")
					{
						if(substr(str_replace("||","",$line), 0 , 4) === "&gt;")
						{
							echo '<div id="redtext">|  ' . str_replace("||","",$line) . '</div>';
						}
						else
						{	
							echo '<div id="comment">|  ' . str_replace("||","",$line) . '</div>';
						}
					} else if(substr($line, 0, 1) === "#")
					{
						echo '<br>';
						if(substr(str_replace("#","",$line), 0 , 4) === "&gt;")
						{
							echo '<div id="redtext">|  ' . str_replace("#","",$line) . '</div>';
						}
						else
						{	
							echo '<div id="comment">|  ' . str_replace("#","",$line) . '</div>';
						}
					}	
				}
				fclose($threadlink);
			}	
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		     ?>
		     <br><br>
		     <form name="comment" action="postcomment.php" method="post">
		   	   <textarea rows="5" cols="50" style="display: block; margin-left: auto; margin-right: auto;" name="body"></textarea>
			   <input type="text" name="id" value="<?php echo $id ?>" style="visibility: hidden;">
		   	   <input type="submit" name="submit" value="Send" style="float: right;">  
		     </form>
		</div>
	</body>
</html>