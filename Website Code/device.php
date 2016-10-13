<?php
require 'connect.php';
$d1name="select * from connection where id=1";
$d2name="select * from connection where id=2";
$d3name="select * from connection where id=3";
$d1nameq=mysqli_query($connection,$d1name);
if($name=mysqli_fetch_assoc($d1nameq))
{
	$d1displayname=$name['name'];
}
$d2nameq=mysqli_query($connection,$d2name);
if($name=mysqli_fetch_assoc($d2nameq))
{
	$d2displayname=$name['name'];
}
$d3nameq=mysqli_query($connection,$d3name);
if($name=mysqli_fetch_assoc($d3nameq))
{
	$d3displayname=$name['name'];
}
?>