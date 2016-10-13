<!DOCTYPE html>
<html>
<head>
<title>Information </title>
<link rel="stylesheet" type="text/css" href="style.css">
<style text="text/css">
.info{
	position: relative;
	top:-1em;
	width:auto;
	float:left;
}
</style>
</head>
<body>
<div class="nav"> 
<div class="header">
<h2><font size="6">IoT To Improve Modern Day Life</font></h2>
</div>
<ul>
<li><a href="monitor.php">Monitor</a></li> 
<li><a href="control.php">Control</a></li>
<li><a href="info.php" class="active">Info</a></li>
<li><a href="project.html">About</a></li>
</ul>
</div>
<?php
session_start();
require 'connect.php';
require 'device.php';
if(!isset($_SESSION['username']))
{
	echo "You need to be logged in to view this page";
	echo "<br/>";
	echo "Will be moved to login page";
	header('Refresh:2; index.php');
}
else
{
	if(isset($_POST['logoff'])){
	$insertlogin="insert into changelog VALUES('login','Logged off',NOW())";
	$insert=mysqli_query($connection,$insertlogin);
	unset($_SESSION['username']);
	mysqli_close($connection);
	header("Location:index.php");
	}
?>
<div class="info">
<h2> Information for control and monitor page</h2>
<ul>
	<li><b>Control Page</b></li>
		<ul>
			<li>Device Controls: Outlets are controlled in this section</li>
			<li>Notification Controls: Door and Light sensors are controlled in this section</li>
				<ul>
					<li>Door Notification:Controls when emails are sent depending on the status of the door sensor.
						<ul>
						<li>On:Emails will be sent when door sensor is opened</li>
						<li>Off:Nothing will be done, even if door sensors are opened</li>
						</ul>
					</li>
					<li>Light Controls:Controls when automated features will be used on outlets, depending on amount of light in the room.
						<ul>
						<li>On:Light outlets will be turned off on large amount of light in room</li>
						<li>Off:No automated feature to turn off outlets.</li>
						</ul>
					</li>
				</ul>
		</ul>
	<li><b>Monitor Page</b> </li>
		<ul>
				<li>View Selected Devices: Click on button to show the changelog for that button </li>
				<li>Clear Selected Dvices: Click on button to delete the changelog for that button </li>
				<li>Connected to: Self-updating to show what you currently have connected to the outlet</li>
				<li>Graph for up/down time:Will open new tab that shows graphs about on and off time for each device based on changelog</li>
				<li>Device/Status/Date/Time: Clicking on these buttons will sort the changelog </li>
		</ul>
	</ul>
</div>
<?php
}
?>
</body>
</html>