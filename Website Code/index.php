<!DOCTYPE html>
<html>
<head>
<title>Login Screen</title>
<style type="text/css">
input[type=text]
{
	border:1px solid black;
}
input[type=password]
{
	border:1px solid black;
}
</style>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php 
session_start();
require 'connect.php';
if(isset($_SESSION['username']))
{
	header("Location:control.php");
}
else 
{
?>
<div class="nav"> 
<div class="header">
<h2><font size="6">IoT To Improve Modern Day Life</font></h2>
</div>
<ul>
<li><a href="monitor.php">Monitor</a></li> 
<li><a href="control.php">Control</a></li>
<li><a href="info.php">Info</a></li>
<li><a href="project.html">About</a></li>
</ul>
<br/>
</div>
<div id="login">
<form action=index.php method=post>
Username <input type="text" name="login" class="text"/> 
<br/>
Password <input type="password" name="password" class="text"/>
<br/>
<input type="submit" name="submit" value="Submit">
</form>
<?php 
if(isset($_POST['submit']) && !empty($_POST ['login']) &&!empty($_POST ['password']))
{
$status=0;
$checkusername='select * from login';
$value=mysqli_query($connection,$checkusername);

if($result=mysqli_fetch_array($value))
{
	$username=$result['username'];
	$password=$result['password'];
	if($_POST['login']==$username)
	{
		//echo $username;
		//$checkpassword="select login from login where username=$username";
		//$value2=mysqli_query($connection,$checkpassword);
			if(password_verify($_POST['password'],$password))
			{
				$updatetime="update login set timestamp=NOW() where username='$username'";
				$insertlogin="insert into changelog VALUES('login','Logged in',NOW())";
				$run=mysqli_query($connection,$updatetime);
				$insert=mysqli_query($connection,$insertlogin);
				//sets up the new session
				$_SESSION['username']=$username;
				header("Location: control.php");
			}
			else
			{
					echo 'Incorrect information';
			}
	}
	else{
		echo 'incorrect information';	
	}
}
}
}
?>
</div>


</body>


</html>