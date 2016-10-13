<!DOCTYPE html>
<html>
<head>
<title> Control Signals </title>
<link rel="stylesheet" type="text/css" href="style.css">
<style text="text/css">
.font
{
	font-size:150%;
}
.update input[type=text]
{
	border:1px solid black;
	width:125px; 
	height:20px;
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
<li><a  class="active" href="control.php">Control</a></li>
<li><a href="info.php">Info</a></li>
<li><a href="project.html">About</a></li>
</ul>
<br/>
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
<!--On/OFF switches-->
<?php
$devices=array();
$i=0;
// d1=device 1,d2=device 2, d3= device 3
$status='NULL';
//Check device status
$d1status="SELECT * FROM relay WHERE id=1";
$d2status="SELECT * FROM relay WHERE id=2";
$d3status="SELECT * FROM relay WHERE id=3";
$devicestatus="SELECT * from relay order by id ASC";
$doorstatus="SELECT status FROM options WHERE id='door'";
$lightstatus="SELECT status FROM options WHERE id='light'";

//Update single devices
$d1on="UPDATE relay SET status='on',timestamp=NOW()  WHERE id=1";
$d1off="UPDATE relay SET status='off',timestamp=NOW()  WHERE id=1";
$d2on="UPDATE relay SET status='on',timestamp=NOW() WHERE id=2";
$d2off="UPDATE relay SET status='off',timestamp=NOW()  WHERE id=2";
$d3on="UPDATE relay SET status='on',timestamp=NOW()  WHERE id=3";
$d3off="UPDATE relay SET status='off',timestamp=NOW()  WHERE id=3";

//Update all devices at once
$allon="UPDATE relay set status='on', timestamp=NOW()";
$alloff="UPDATE relay set status='off', timestamp=NOW()";

//Insert into changelog
$insertd1ontooff="insert into changelog VALUES('$d1displayname(Device 1)','on to off',NOW())";
$insertd2ontooff="insert into changelog VALUES('$d2displayname(Device 2)','on to off',NOW())";
$insertd3ontooff="insert into changelog VALUES('$d3displayname(Device 3)','on to off',NOW())";
$insertd1offtoon="insert into changelog VALUES('$d1displayname(Device 1)','off to on',NOW())";
$insertd2offtoon="insert into changelog VALUES('$d2displayname(Device 2)','off to on',NOW())";
$insertd3offtoon="insert into changelog VALUES('$d3displayname(Device 3)','off to on',NOW())";
$insertlightofftoon="insert into changelog VALUES('light controls','off to on',NOW())";
$insertlightontooff="insert into changelog VALUES('light controls','on to off',NOW())";
$insertdoorofftoon="insert into changelog VALUES('door notification','off to on',NOW())";
$insertdoorontooff="insert into changelog VALUES('door notification','on to off',NOW())";

//Door queries
$dooron="UPDATE options SET status='on',timestamp=NOW() WHERE id='door'";
$dooroff="UPDATE options SET status='off',timestamp=NOW() WHERE id='door'";

//Light queries
$lighton="UPDATE options SET status='on',timestamp=NOW() WHERE id='light'";
$lightoff="UPDATE options SET status='off',timestamp=NOW() WHERE id='light'";

//connection
$d1name="select * from connection where id=1";
$d2name="select * from connection where id=2";
$d3name="select * from connection where id=3";




//Device 1 On
if(isset($_POST['on1'])){

	$val=mysqli_query($connection,$d1status);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='on')
	{
		$turnedon=mysqli_query($connection,$d1on);
		$insert=mysqli_query($connection,$insertd1offtoon);
		usleep(500000);
	}

}

// Device 1 Off
else if(isset($_POST['off1'])){
	$val=mysqli_query($connection,$d1status);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='off')
	{
		$turnedoff=mysqli_query($connection,$d1off);
		$insert=mysqli_query($connection,$insertd1ontooff);
		usleep(500000);
	}

}

// Devicd 2 Off
else if(isset($_POST['off2'])){
	$val=mysqli_query($connection,$d2status);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='off')
	{
		$turnedoff=mysqli_query($connection,$d2off);
		$insert=mysqli_query($connection,$insertd2ontooff);
		usleep(500000);
	}
}

//Device 3 Off
else if(isset($_POST['off3'])){
	$val=mysqli_query($connection,$d3status);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='off')
	{
		$turnedoff=mysqli_query($connection,$d3off);
		$insert=mysqli_query($connection,$insertd3ontooff);
		usleep(500000);
	}
}

//Device 2 On
else if(isset($_POST['on2'])){
	$val=mysqli_query($connection,$d2status);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='on')
	{
		$turnedon=mysqli_query($connection,$d2on);
		$insert=mysqli_query($connection,$insertd2offtoon);
		usleep(500000);
	}

}

//Device 3 on
else if(isset($_POST['on3'])){
	$val=mysqli_query($connection,$d3status);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='on')
	{
		$turnedon=mysqli_query($connection,$d3on);
		$insert=mysqli_query($connection,$insertd3offtoon);
		usleep(500000);
	}
}


//All devices 4 on
else if(isset($_POST['onall'])){
	$num=0;
	$checkall=mysqli_query($connection,$devicestatus);
	while($result=mysqli_fetch_assoc($checkall))
	{
		//will get the data by id, example: id=1 will be first id =2 will be second;
		$devices[]=$result['status'];
	}
	for($i=0;$i<3;$i=$i+1)
	{
		switch($i)
		{
		case 0:
			if($devices[0]!='on')
			{
				$turnedon=mysqli_query($connection,$d1on);
				$insert=mysqli_query($connection,$insertd1offtoon);
			}
			break;
		case 1:
			if($devices[1]!='on')
			{
				$turnedon=mysqli_query($connection,$d2on);
				$insert2=mysqli_query($connection,$insertd2offtoon);
			}
			break;
		case 2:
			if($devices[2]!='on')
			{
				$turnedon=mysqli_query($connection,$d3on);
				$insert3=mysqli_query($connection,$insertd3offtoon);
			}
			break;
		}
	}
		usleep(500000);
}

//All devices 4 off
else if(isset($_POST['offall'])){
	$num=0;
	$checkall=mysqli_query($connection,$devicestatus);
	while($result=mysqli_fetch_assoc($checkall))
	{
		//will get the data by id, example: id=1 will be first id =2 will be second;
		$devices[]=$result['status'];
	}
	for($i=0;$i<3;$i=$i+1)
	{
		switch($i)
		{
		case 0:
			if($devices[0]!='off')
			{
				$turnedon=mysqli_query($connection,$d1off);
				$insert=mysqli_query($connection,$insertd1ontooff);
			}
			break;
		case 1:
			if($devices[1]!='off')
			{				
				$turnedon=mysqli_query($connection,$d2off);
				$insert2=mysqli_query($connection,$insertd2ontooff);
			}
			break;
		case 2:
			if($devices[2]!='off')
			{
				$turnedon=mysqli_query($connection,$d3off);
				$insert3=mysqli_query($connection,$insertd3ontooff);
			}
			break;
		}
	}
			usleep(500000);
}


// Door off controls
else if(isset($_POST['dooroff'])){
	$val=mysqli_query($connection,$doorstatus);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='off')
	{
		$turnedoff=mysqli_query($connection,$dooroff);
		$insert=mysqli_query($connection,$insertdoorontooff);
	}

}

// Lights off controls
else if(isset($_POST['lightoff'])){
	$val=mysqli_query($connection,$lightstatus);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='off')
	{
		$turnedoff=mysqli_query($connection,$lightoff);
		$insert=mysqli_query($connection,$insertlightontooff);
	}

}

//Door on controls
else if(isset($_POST['dooron'])){
	$val=mysqli_query($connection,$doorstatus);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='on')
	{
		$turnedon=mysqli_query($connection,$dooron);
		$insert=mysqli_query($connection,$insertdoorofftoon);
	}

}



//Light on controls
else if(isset($_POST['lighton'])){
	$val=mysqli_query($connection,$lightstatus);
	if($result=mysqli_fetch_assoc($val)){
		$status=$result['status'];
	}
	if($status!='on')
	{
		$turnedon=mysqli_query($connection,$lighton);
		$insert=mysqli_query($connection,$insertlightofftoon);
	}

}
?>
<!--Change the connected to device-->
<?php
if(isset($_POST['d1connection']))
{
	$d1nameupdate=$_POST['d1value'];
	if(strtolower($d1displayname)!=strtolower($d1nameupdate))
	{
	$d1connectionchange="insert into changelog VALUES('Device 1','$d1displayname changed to $d1nameupdate',NOW())";
	$d1changelogconnection=mysqli_query($connection,$d1connectionchange);
	$d1nameupdateq="update connection set name='$d1nameupdate' where id=1";
	$d1nameupdatequery=mysqli_query($connection,$d1nameupdateq);
	}
}

else if(isset($_POST['d2connection']))
{

	$d2nameupdate=$_POST['d2value'];
	if(strtolower($d2displayname)!=strtolower($d2nameupdate))
	{
	$d2connectionchange="insert into changelog VALUES('Device 2','$d2displayname changed to $d2nameupdate',NOW())";
	$d2changelogconnection=mysqli_query($connection,$d2connectionchange);
	$d2nameupdateq="update connection set name='$d2nameupdate' where id=2";
	$d2nameupdatequery=mysqli_query($connection,$d2nameupdateq);
	}
}

else if(isset($_POST['d3connection']))
{

	$d3nameupdate=$_POST['d3value'];
	if(strtolower($d3displayname)!=strtolower($d3nameupdate))
	{
	$d3connectionchange="insert into changelog VALUES('Device 3','$d3displayname changed to $d3nameupdate',NOW())";
	$d3changelogconnection=mysqli_query($connection,$d3connectionchange);
	$d3nameupdateq="update connection set name='$d3nameupdate' where id=3";
	$d3nameupdatequery=mysqli_query($connection,$d3nameupdateq);
	}
}


?>
<div class="logininfo">
<?php
if(isset($_SESSION['username']))
{	 
	 echo "Logged in as: ";
	 echo $_SESSION['username'];
	 echo "<form action=monitor.php method=post>";
	 echo "<input type='submit' class='logoffbutton' name='logoff' value='Log Off'>";
	 echo "</form>";
}
?>
</div>
<!--Device Sensor Controls-->
<div class="device">
<b>
<font size="6"> Device Controls </font>
</b>
<br/>
<!--Device 1 Buttons-->
<b class="font"><?php echo "Device 1($d1displayname)"?></b>
<form action=control.php method=post>
<input type="submit" name="on1" value="Turn On">
<input type="submit" name="off1" value="Turn Off">
<br/>
</form>
<b>Current Status:</b>
<?php
$d1result=mysqli_query($connection,$d1status);
if($result=mysqli_fetch_assoc($d1result)){
	if($result['status']=='on')
	{
		echo "<font color=green> On </font>";
	}
	else
	{
		echo "<font color=red> Off </font>"; 
	}
}
?>
<br/>
<!-- Device 2 Buttons-->

<b class="font"><?php echo "Device 2($d2displayname)"?></b>
<br/>
<form action=control.php method=post>
<input type="submit" name="on2" value="Turn On">
<input type="submit" name="off2" value="Turn Off">
</form>
<b>Current Status:</b>
<?php
$d2result=mysqli_query($connection,$d2status);
if($result=mysqli_fetch_assoc($d2result)){
	if($result['status']=='on')
	{
		echo "<font color=green> On </font>";
	}
	else
	{
		echo "<font color=red> Off </font>"; 
	}
}
?>
<br/>

<!--Device 3 Buttons-->
<b class="font"><?php echo "Device 3($d3displayname)"?></b>
<form action=control.php method=post>
<input type="submit" name="on3" value="Turn On">
<input type="submit" name="off3" value="Turn Off">
</form>
<b>Current Status:</b>
<?php
$d3result=mysqli_query($connection,$d3status);
if($result=mysqli_fetch_assoc($d3result)){
	if($result['status']=='on')
	{
		echo "<font color=green> On </font>";
	}
	else
	{
		echo "<font color=red> Off </font>"; 
	}
}
?>
<br/>

<!--All Devices Buttons-->
<b class="font">All Devices</b>
<form action=control.php method=post>
<input type="submit" name="onall" value="Turn On">
<input type="submit" name="offall" value="Turn Off">
</form>
</div>

<div class="notification">
<!-- Door/Light Controls-->
<b>
<font size="6"> Notification Controls </font>
</b>
<br/>
<!--Door Controls-->
<b class="font">Door Notification</b>
<form action=control.php method=post>
<input type="submit" name="dooron" value="Turn On">
<input type="submit" name="dooroff" value="Turn Off">
</form>
<b>Current Status:</b>
<?php
$doorresult=mysqli_query($connection,$doorstatus);
if($result=mysqli_fetch_assoc($doorresult)){
	if($result['status']=='on')
	{
		echo "<font color=green> On </font>";
	}
	else
	{
		echo "<font color=red> Off </font>"; 
	}
}
?>
<br/>

<!--Light Controls-->
<b class="font">Light Control</b>
<form action=control.php method=post>
<input type="submit" name="lighton" value="Turn On">
<input type="submit" name="lightoff" value="Turn Off">
</form>
<b>Current Status:</b>
<?php
$lightresult=mysqli_query($connection,$lightstatus);
if($result=mysqli_fetch_assoc($lightresult))
{
	if($result['status']=='on')
	{
		echo "<font color=green> On </font>";
	}
	else
	{
		echo "<font color=red> Off </font>"; 
	}
}
?>
</div>
<?php
if(isset($_POST['logoff'])){
	session_start();
	session_unset();
	session_destroy();
	mysqli_close($connection);
	header('Refresh:.5; index.php');
}
}
?>

</body>
</html>