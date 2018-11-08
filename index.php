<?php
   ob_start();
   session_start();
   require('db.inc.php');
   
   if (isset($_POST['btnLogin']) || $_POST['btnLogin']=="Login")
	{
	$tusername=$_REQUEST['username'];
	$tusername=strtolower($tusername);
	$tpassword=$_REQUEST['password'];
	$tdatetime=strftime("%Y-%m-%d %H:%M:%S");
	$sql = "SELECT *,count(*) as login FROM `users` WHERE `username`='$tusername' and `password`= '$tpassword'";
	$result= mysql_query($sql) or die("<script> alert('Invalid Username or Password'); document.history(-1);</script>");
	if($row=mysql_fetch_assoc($result))
	{
	if($row['login']==0)
	{	
		echo "<script> alert('Invalid Username or Password'); document.history(-1);</script>";
	}
	else
	{	
		$_SESSION["login"]= true;
		$_SESSION["username"] = $tusername;
		$_SESSION["currentdate"] = $tdatetime;
		header("location:inventory.php");
			
	}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>IMS UCSC</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="index.php"><img src="images/ucsclogo.png" alt="LOGO"></a>
			  
			</div>
			
		</div>
	</div>
	<div id="contents" align="center">
		<div id="adbox">
			<div class="wrapper clearfix">
			</div>
			<div class="highlight">
				<h2>I N V E N T O R Y &nbsp;  M A N A G E M E N T &nbsp;  S Y S T E M</h2>
			</div>
		</div>
		<div class="body clearfix">
			<table>
					<form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
					<tr><td><p class="plog">Please login to continue</p></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="tdsp">Username</td><td><input type="text" name = "username" id = "username"></td></tr>
					<tr><td>&nbsp;</td><td></td><td>Password</td><td><input type="password" name = "password" id = "password"></td></tr>
					<tr><td>&nbsp;</td><td></td><td><input name="btnLogin" type="submit" class="btn2" id="btnLogin" value="Login" /></td></tr>
					</form>
			</table>
		</div>
	</div>
</body>
</html>