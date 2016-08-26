<!DOCTYPE HTML>
<html>
<head>
	<title>danger/u/ - dangerous opinions</title>
	<link rel="stylesheet" type="text/css" href="static/dangeru.css">
</head>

<body>
	<div id="sitecorner">
	     <img src="static/logo.png" alt="danger/u/">
	     <a href="new.php" id="newthread">Creating a thread</a>
	     <a href="#" style="float: left;">Title</a><br>
	     <form name="thread" action="threadpost.php" method="post">
	     	   <input type="text" name="title" value=""><br>
		   <a href="#" style="float: left;">Comment</a><br>
		   <textarea rows="5" cols="50" style="display: block; margin-left: auto; margin-right: auto;" name="body"></textarea>
		   <input type="submit" name="submit" value="Create">
	     </form>
	</div>
</body>
</html>
