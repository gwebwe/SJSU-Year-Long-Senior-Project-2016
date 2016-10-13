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
$insertdoorofftoon="insert into changelog VALUES('door controls','off to on',NOW())";
$insertdoorontooff="insert into changelog VALUES('door controls','on to off',NOW())";

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
	}
}


//All devices 4 on
else if(isset($_POST['onall'])){
	$num=0;
	$checkall=mysqli_query($connection,$devicestatus);
	while($result=mysqli_fetch_assoc($checkall))
	{
		//will get the data by id, example: id=1 will be first id =2 will be second;
		$devices[num]=$result['status'];
		$num=$num+1;
	}
	for($i=0;$i<$num;$i=$i+1)
	{
		switch($i)
		{
		case 0:
			if($device[i]!='on')
			{
				$turnedon=mysqli_query($connection,$d1on);
				$insert=mysqli_query($connection,$insertd1offtoon);
			}
			break;
		case 1:
			if($device[i]!='on')
			{
				$turnedon=mysqli_query($connection,$d2on);
				$insert2=mysqli_query($connection,$insertd2offtoon);
			}
			break;
		case 2:
			if($device[i]!='on')
			{
				$turnedon=mysqli_query($connection,$d3on);
				$insert3=mysqli_query($connection,$insertd3offtoon);
			}
			break;
		}
	}
}

//All devices 4 off
else if(isset($_POST['offall'])){
	$num=0;
	$checkall=mysqli_query($connection,$devicestatus);
	while($result=mysqli_fetch_assoc($checkall))
	{
		//will get the data by id, example: id=1 will be first id =2 will be second;
		$devices[num]=$result['status'];
		$num=$num+1;
	}
	for($i=0;$i<$num;$i=$i+1)
	{
		switch($i)
		{
		case 0:
			if($device[i]!='off')
			{
				$turnedon=mysqli_query($connection,$d1off);
				$insert=mysqli_query($connection,$insertd1ontooff);
			}
			break;
		case 1:
			if($device[i]!='off')
			{
				$turnedon=mysqli_query($connection,$d2off);
				$insert2=mysqli_query($connection,$insertd2ontooff);
			}
			break;
		case 2:
			if($device[i]!='off')
			{
				$turnedon=mysqli_query($connection,$d3off);
				$insert3=mysqli_query($connection,$insertd3ontooff);
			}
			break;
		}
	}
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
	$d1connectionchange="insert into changelog VALUES('Device 1','$d1displayname to $d1nameupdate',NOW())";
	$d1changelogconnection=mysqli_query($connection,$d1connectionchange);
	$d1nameupdateq="update connection set name='$d1nameupdate' where id=1";
	$d1nameupdatequery=mysqli_query($connection,$d1nameupdateq);
}

else if(isset($_POST['d2connection']))
{

	$d2nameupdate=$_POST['d2value'];
	$d2connectionchange="insert into changelog VALUES('Device 2','$d2displayname to $d2nameupdate',NOW())";
	$d2changelogconnection=mysqli_query($connection,$d2connectionchange);
	$d2nameupdateq="update connection set name='$d2nameupdate' where id=2";
	$d2nameupdatequery=mysqli_query($connection,$d2nameupdateq);
}

else if(isset($_POST['d3connection']))
{

	$d3nameupdate=$_POST['d3value'];
	$d3connectionchange="insert into changelog VALUES('Device 3','$d3displayname to $d3nameupdate',NOW())";
	$d3changelogconnection=mysqli_query($connection,$d3connectionchange);
	$d3nameupdateq="update connection set name='$d3nameupdate' where id=3";
	$d3nameupdatequery=mysqli_query($connection,$d3nameupdateq);
}


?>