<!DOCTYPE HTML>
<html>
<head>
	<title>danger/u/ - dangerous opinions</title>
	<link rel="stylesheet" type="text/css" href="static/dangeru.css">
	<link rel="shortcut icon" href="static/favicon.ico">
</head>

<body>
	<div id="sitecorner">
	     <a href="index.php"><img src="static/logo.png" alt="danger/u/"></a>
	     <a href="new.php" id="newthread">Creating a thread</a>
	     <a href="#" style="float: left; font-size: 16px;">Title</a><br>
	     <form name="thread" action="threadpost.php" method="post">
	     	   <input type="text" name="title" value=""><br>
		   <a href="#" style="float: left; font-size: 16px;">Comment</a><br>
		   <textarea rows="5" cols="50" style="display: block; margin-left: auto; margin-right: auto;" name="body"></textarea>
		   <input type="submit" name="submit" value="Create">
	     </form>
	</div>
</body>
</html>
