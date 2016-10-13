<!DOCTYPE html>
<html>
<head>
<?php
require 'connect.php';
?>
<title> Monitor Signals </title>
<link rel="stylesheet" type="text/css" href="style.css">
<style text="text/css">
table
{
	border:2px solid #0099FF;
	width:500px;
	position: absolute;
	top:60px;
}
td
{
	width:100px;
}
input[type=submit]
{
	border:1px solid black;
	width:166.67px; 
	height:20px;
	color:white;
	background:#0099FF;
}
input[type=text]
{
	border:1px solid black;
	width:90px; 
	height:20px;
	margin:2px;
}

</style>
</head>
<body>
<div class="nav"> 
<div class="header">
<h2><font size="6">IoT To Improve Modern Day Life</font></h2>
</div>
<ul>
<li><a href="monitor.php" class="active">Monitor </a></li>
<li><a href="control.php">Control</a></li>
<li><a href="info.php">Info</a></li>
<li><a href="project.html">About</a></li>
</ul>
<br/>
</div>
<?php
 require 'device.php';
 session_start();
	if(!isset($_SESSION['username']))
	{
	echo "You need to be logged in to view this page";
	echo "<br/>";
	echo "Will be moved to login page";
	header('Refresh:2; index.php');
	}
	else
	{
		if(isset($_POST['logoff']))
		{
		$insertlogin="insert into changelog VALUES('login','Logged off',NOW())";
		$insert=mysqli_query($connection,$insertlogin);
		unset($_SESSION['username']);
		unset($_SESSION['device']);
		unset($_SESSION['date']);
		unset($_SESSION['status']);
		unset($_SESSION['deviceo']);
		mysqli_close($connection);
		header("Location:index.php");
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
</div>
<div class="pickdevice">
<!-- View Selected Device -->
<h3> View Selected Device </h3>
<form action=monitor.php method=post>
<!--Device 1-->
<input type='submit' name="device1" value="Device 1">
<br/>
<!--Device 2-->
<input type='submit' name="device2" value="Device 2">
<br/>
<!--Device 3-->
<input type='submit' name="device3" value="Device 3">
<br/>
<!--All devices-->
<input type='submit' name="alldevices" value="All Devices">
<br/>
<!--Changes to Devices-->
<input type='submit' name="devicechanges" value="Device Changes">
<br/>
<!--Door-->
<input type='submit' name="doorcontrols" value="Door Notification">
<br/>
<!--Light-->
<input type='submit' name="lightcontrols" value="Light Controls">
<br/>
<!--Login-->
<input type='submit' name="login" value="Login">
<br/>
<!--View all-->
<input type='submit' name="all" value="View All">
</form>
<!-- Delete Changelog entry(denoted by the e at the end of the name)-->
<h3> Clear Selected Device </h3>
<form action=monitor.php method=post>
<!--Device 1-->
<input type='submit' name="device1e" onclick="return confirm('Delete Device 1 from changelog?');" value="Device 1">
<br/>
<!--Device 2-->
<input type='submit' name="device2e" onclick="return confirm('Delete Device 2 from changelog?');" value="Device 2">
<br/>
<!--Device 3-->
<input type='submit' name="device3e" onclick="return confirm('Delete Device 3 from changelog?');" value="Device 3">
<br/>
<!--All devices-->
<input type='submit' name="alldevicese"  onclick="return confirm('Delete all devices from changelog?');" value="All Devices">
<br/>
<!--Changes to Devices-->
<input type='submit' name="devicechangese"  onclick="return confirm('Delete Device Changes from changelog?');" value="Device Changes">
<br/>
<!--Door-->
<input type='submit' name="doorcontrolse" onclick="return confirm('Delete Door Notification from changelog?');" value="Door Notification">
<br/>
<!--Light-->
<input type='submit' name="lightcontrolse" onclick="return confirm('Delete Light controls from changelog?');" value="Light Controls">
<br/>
<!--Login
<input type='submit' name="logine" value="Login">
<br/>
-->
<!--View all
<input type='submit' name="alle" value="All">
-->
<h3> Connected To </h3>
<b> Device 1:</b>
<input type="text" name="d1value" placeholder="<?php echo $d1displayname?>">
<br/>
<input type="submit" name="d1connection" value="Update">
<br/>
<b> Device 2:</b>
<input type="text" name="d2value" placeholder="<?php echo $d2displayname?>">
<br/>
<input type="submit" name="d2connection" value="Update">
<br/>
<b> Device 3:</b>
<input type="text" name="d3value" placeholder="<?php echo $d3displayname?>">
<br/>
<input type="submit" name="d3connection" value="Update">
</form>
<br/>

<a href="graph.php" target="_blank"> Graph for up/down time </a>
</div>

<div class="data">
<h3> Changelog </h3>
<?php
function query($deviceq,$orderq,$connection,$database)
{
	//Selected device
	$orderbyasc="field(device,'device 1', 'device 2', 'device 3', 'door controls', 'light controls','login') ASC";
	$orderbydesc="field(device,'device 1', 'device 2', 'device 3', 'door controls', 'light controls','login') DESC";
	//Everything includes login/door/lights
	if($deviceq=='all')
	{
			switch($orderq)
			{
			case 'date/time':
			if($_SESSION['date']!=1)
			{
				$_SESSION['date']=1;
				$changelogq="select * from changelog order by `timestamp` ASC";
			}
			else
			{
				$_SESSION['date']=0;
				$changelogq="select * from changelog order by `timestamp` DESC";
			}
			break;
			
			case 'status':
			if($_SESSION['status']!=1)
			{
				$_SESSION['status']=1;
				$changelogq="select * from changelog order by `status` ASC";
			}
			else
			{
				$_SESSION['status']=0;
				$changelogq="select * from changelog order by `status` DESC";
			}
			break;
			
			case 'device':
				if($_SESSION['deviceo']!=1)
				{
					$_SESSION['deviceo']=1;
					$changelogq="select * from changelog order by `device` ASC";
				}
				else
				{
					$_SESSION['deviceo']=0;
					$changelogq="select * from changelog order by `device` DESC";
				}
			break;
			
			default:
			$changelogq="select * from changelog";
			break;
			}
		
	}
	// All devices
	else if($deviceq=='alldevices')
	{
			switch($orderq)
			{
				case 'date/time':
				if($_SESSION['date']!=1)
				{
				$_SESSION['date']=1;
				$changelogq="select * from changelog where device like '%Device%' order by `timestamp` ASC";
				}
				else
				{
				$_SESSION['date']=0;
				$changelogq="select * from changelog where device like '%Device%' order by `timestamp` DESC";
				}
				break;
				case 'status':
				if($_SESSION['status']!=1)
				{
				$_SESSION['status']=1;
				$changelogq="select * from changelog where device like '%Device%' order by `status` ASC";
				}
				else
				{
				$_SESSION['status']=0;
				$changelogq="select * from changelog where device like '%Device%' order by `status` DESC";
				}
				break;
				
				case 'device':
				if($_SESSION['deviceo']!=1)
				{
					$_SESSION['deviceo']=1;
					$changelogq="select * from changelog where device like '%Device%' order by `device` ASC";
				}
				else
				{
					$_SESSION['deviceo']=0;
					$changelogq="select * from changelog where device like '%Device%' order by `device` DESC";
				}
				break;
				default:
				$changelogq="select * from changelog where device like '%Device%'";
				break;
			}
	}
	//Device change
	else if($deviceq=='Device Changes')
	{
			switch($orderq)
			{
				case 'date/time':
				if($_SESSION['date']!=1)
				{
				$_SESSION['date']=1;
				$changelogq="select * from changelog where status like '%changed%' order by `timestamp` ASC";
				}
				else
				{
				$_SESSION['date']=0;
				$changelogq="select * from changelog where status like '%changed%' order by `timestamp` DESC";
				}
				break;
				case 'status':
				if($_SESSION['status']!=1)
				{
				$_SESSION['status']=1;
				$changelogq="select * from changelog where status like '%changed%' order by `status` ASC";
				}
				else
				{
				$_SESSION['status']=0;
				$changelogq="select * from changelog where status like '%changed%' order by `status` DESC";
				}
				break;
				
				case 'device':
				if($_SESSION['deviceo']!=1)
				{
					$_SESSION['deviceo']=1;
					$changelogq="select * from changelog where status like '%changed%' order by `device` ASC";
				}
				else
				{
					$_SESSION['deviceo']=0;
					$changelogq="select * from changelog where status like '%changed%' order by `device` DESC";
				}
				break;
				default:
				$changelogq="select * from changelog where status like '%changed%'";
				break;
			}
	}
	//Everything else Etc device 1 , device 2
	else
	{
			switch($orderq)
			{
				case 'date/time':
				if($_SESSION['date']!=1)
				{
				$_SESSION['date']=1;
				$changelogq="select * from changelog where device like '%$deviceq%' order by `timestamp` ASC";
				}
				else
				{
				$_SESSION['date']=0;
				$changelogq="select * from changelog where device like '%$deviceq%' order by `timestamp` DESC ";
				}
				break;
				
				case 'status':
				if($_SESSION['status']!=1)
				{
				$_SESSION['status']=1;
				$changelogq="select * from changelog where device like '%$deviceq%'  order by `status` ASC";
				}
				else
				{
				$_SESSION['status']=0;
				$changelogq="select * from changelog where device like '%$deviceq%'  order by `status` DESC";
				}
				break;
				
				case 'device':
					if($deviceq=='light controls' || $deviceq=='door controls' || $deviceq=='login')
					{
						$changelogq="select * from changelog where device='$deviceq'";
					}
					else
					{
						if($_SESSION['deviceo']!=1)
						{
							$_SESSION['deviceo']=1;
							$changelogq="select * from changelog where device like '%$deviceq%' order by `device` ASC";
						}
						else
						{
							$_SESSION['deviceo']=0;
							$changelogq="select * from changelog where device like '%$deviceq%' order by `device` DESC";
						}
					}
				break;
				
				default:
				$changelogq="select * from changelog where device like '%$deviceq%'";
				break;
			}
	}
	$queryq=mysqli_query($connection,$changelogq);
	if(!$queryq)
	{
		echo " Error in query function";
	}
	// Table/ Buttonst that will be needed for order
	echo '<table border="1">';
	echo '<tr>';
	echo '<form action=monitor.php method=post>';
	echo '<th> <input type="submit" name="device" value="Device"/> </th>';
	echo '<th> <input type="submit" name="status" value="Status"/> </th>';
	echo '<th> <input type="submit" name="time" value="Date/Time"/> </th>';
	echo '</tr>';
	echo '</form>';
	//Display the information on the website.
	while($resultq=mysqli_fetch_assoc($queryq))
	{
		$device=$resultq['device'];
		$status=$resultq['status'];
		$time=$resultq['timestamp'];
		echo '<tr>'."\n";
		echo "<td> $device</td><br/>"."<td> $status</td><br/>"."<td> $time</td><br/>";
		echo '</tr>'."\n";
	}
	echo "</table>";
	graph($resultq);
	
	
}
// Empty database function
function deletefromchangelog($devicee,$connection,$database)
{
	if($devicee=='all')
	{
		$changeloge="delete from changelog";
	}
	else if($devicee=='alldevices')
	{
		$changeloge="delete from changelog where device like '%Device%'";
	}
	else if($devicee=='Device Changes')
	{
		$changeloge= "delete from changelog where status like '%changed%'";
	}
	else
	{
		$changeloge="delete from changelog where device like '%$devicee%'";
	}
	$emptyresult=mysqli_query($connection,$changeloge);
	if(!$emptyresult)
	{
		echo " Empty Function";
	}
}
switch(isset($_POST))
{
	//Select
	case isset($_POST['device1']):
	$device=$_POST['device1'];
	$_SESSION['device']=$device;
	break;
	
	case isset($_POST['device2']):
	$device=$_POST['device2'];
	$_SESSION['device']=$device;
	break;
	
	case isset($_POST['device3']):
	$device=$_POST['device3'];
	$_SESSION['device']=$device;
	break;
	
	case isset($_POST['alldevices']):
	$device='alldevices';
	$_SESSION['device']=$device;
	break;
	
	case isset($_POST['doorcontrols']):
	$device='door notification';
	$_SESSION['device']=$device;
	break;
	
	case isset($_POST['lightcontrols']):
	$device='light controls';
	$_SESSION['device']=$device;
	break;
	
	case isset($_POST['login']):
	$device=strtolower($_POST['login']);
	$_SESSION['device']=$device;
	break;
	
	case isset($_POST['all']):
	$device='all';
	$_SESSION['device']=$device;
	break;
	case isset($_POST['devicechanges']):
	$device=$_POST['devicechanges'];
	$_SESSION['device']=$device;
	break;
	
	// Empty
	case isset($_POST['device1e']):
	$devicee=$_POST['device1e'];
	deletefromchangelog($devicee,$connection,$database);
	break;
	
	case isset($_POST['device2e']):
	$devicee=$_POST['device2e'];
	deletefromchangelog($devicee,$connection,$database);
	break;
	
	case isset($_POST['device3e']):
	$devicee=$_POST['device3e'];
	deletefromchangelog($devicee,$connection,$database);;
	break;
	
	case isset($_POST['alldevicese']):
	$devicee='alldevices';
	deletefromchangelog($devicee,$connection,$database);
	break;
	
	case isset($_POST['doorcontrolse']):
	$devicee='door notification';
	deletefromchangelog($devicee,$connection,$database);
	break;
	
	case isset($_POST['lightcontrolse']):
	$devicee='light controls';
	deletefromchangelog($devicee,$connection,$database);
	break;
	
	case isset($_POST['logine']):
	$devicee=$_POST['logine'];
	deletefromchangelog($devicee,$connection,$database);
	break;
	
	case isset($_POST['alle']):
	$devicee='all';
	deletefromchangelog($devicee,$connection,$database);
	break;
	
	case isset($_POST['devicechangese']):
	$devicee=$_POST['devicechangese'];
	deletefromchangelog($devicee,$connection,$database);
	break;
	
}
// Order by
switch(isset($_POST))
{
	//Order By device
	case isset($_POST['device']):
	$order=strtolower($_POST['device']);
	break;
	
	//Order by status
	case isset($_POST['status']):
	$order=strtolower($_POST['status']);
	break;
	
	// Order by date
	case isset($_POST['time']):
	$order=strtolower($_POST['time']);
	break;
	
	default:
	$order="";
	break;
}
/*if(isset($_POST['filtersubmit']))
	{
		$filter='yes';
					echo "<br/>";
				echo "<br/>";
						echo "<br/>";
								echo "<br/>";			
		// First date
		$monthF=$_POST['monthF'];
		$dayF=$_POST['dayF'];
		$yearF=$_POST['yearF'];
		$hourF=$_POST['hourF'];
		$minF=$_POST['minF'];
		$ampmF=$_POST['ampmF'];

		if(($dayF=='1')||($dayF=='2')||($dayF=='3')||($dayF=='4')||($dayF=='5')||($dayF=='6')||($dayF=='7')||($dayF=='8')||($dayF=='9'))
		{
			$dayF="0$dayF";
		}
		$firstdate="$yearF-$monthF-$dayF";
		echo "<br/>";
		// Second date
		$monthS=$_POST['monthS'];
		$dayS=$_POST['dayS'];
		$yearS=$_POST['yearS'];
		$hourS=$_POST['hourS'];
		$minS=$_POST['minS'];
		$ampmS=$_POST['ampmS'];

		if(($dayS=='1')||($dayS=='2')||($dayS=='3')||($dayS=='4')||($dayS=='5')||($dayS=='6')||($dayS=='7')||($dayS=='8')||($dayS=='9'))
		{
			$dayS="0$dayS";
		}
		$seconddate="$yearS-$monthS-$dayS";
	}
	$_SESSION['filter']=$filter; */
query($_SESSION['device'],$order,$connection,$database);
}
?>
</div>
</body>
</html>