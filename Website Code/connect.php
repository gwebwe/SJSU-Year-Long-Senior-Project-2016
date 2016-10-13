<?php 
$connection=mysqli_connect('localhost','root','*****');
if($connection){
	//echo "Connection to server successful<br/>";
	$database=mysqli_select_db($connection,'iot');
	if(!$database){
	die("Failed connection for database ".mysqli_error());
	}
}
else{
	die("Connection failed <br/>". mysqli_error());
}
?>
