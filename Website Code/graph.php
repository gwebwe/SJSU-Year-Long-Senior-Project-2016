<?php
   include("fusioncharts.php");
	require 'connect.php';
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
	if(isset($_POST['logoff'])){
	$insertlogin="insert into changelog VALUES('login','Logged off',NOW())";
	$insert=mysqli_query($connection,$insertlogin);
	unset($_SESSION['username']);
	mysqli_close($connection);
	header("Location:index.php");
	}
   ?>
<html>

   <head>
  	<title>IoT To Improve Modern Day Life Graph</title>
  	<script src="fusioncharts.js"></script>
   </head>
   <body>
	<?php
	date_default_timezone_set('America/Los_Angeles');
	function values($device,$connection,$database){
		//Device 1 status info
		$d1info="select * from changelog where device like '%$device%' and (status like 'on%' or status like 'off%') order by `timestamp` ASC";
		$d1time=array();
		$d1query=mysqli_query($connection,$d1info);
		$d1result=array();
		$arrayfinal=array();
		$offtime=0;
		$ontime=0;
		$sec=0;
		while($result=mysqli_fetch_assoc($d1query)){
			$d1result[]=$result;
		}
		if((sizeof($d1result))==0){
			switch($device)
			{
				case 'Device 1':
				$status="SELECT * FROM relay WHERE id=1";
				break;
				
				case 'Device 2':
				$status="SELECT * FROM relay WHERE id=2";
				break;
				
				case 'Device 3':
				$status="SELECT * FROM relay WHERE id=3";
				break;
			}
			$result=mysqli_query($connection,$status);
			if($result=mysqli_fetch_assoc($result)){
				$d1time['first']=$result['status'];
				$d1time['timestamp']=$result['timestamp'];
			}
			$currdate=date('Y-m-d H:i:s');
			if($d1time['first']=='off'){
				$date1=new DateTime($d1time['timestamp']);
				$date2=new DateTime($currdate);	
				$diff=$date1->diff($date2);
				$sec=$diff->days *24*60*60;
				$sec+=$diff->h*60*60;
				$sec+=$diff->i*60;
				$sec+=$diff->s;
				//echo $sec.'<br/>';
				$offtime=$sec;
			}
			else{
				$date1=new DateTime($d1time['timestamp']);
				$date2=new DateTime($currdate);	
				$diff=$date1->diff($date2);
				$sec=$diff->days *24*60*60;
				$sec+=$diff->h*60*60;
				$sec+=$diff->i*60;
				$sec+=$diff->s;
				//echo $sec.'<br/>';
				$ontime=$sec;
			}

		}
		else{
			foreach ($d1result as $v)
			{
				if($d1time['first'] == NULL)
				{
					$d1time['first']=$v['status'];
				}
				if($v['timestamp'] != NULL){
				$d1time[]=$v['timestamp'];
				$d1time['last']=$v['timestamp'];
				}
			}
		$size=count($d1time);
			if($d1time['first']=='on to off'){
				for($i=0; $i<$size-2; $i=$i+2){
					$date1=new DateTime($d1time[$i]);
					$date2=new DateTime($d1time[$i+1]);
					$diff=$date1->diff($date2);
					$sec=$diff->days *24*60*60;
					$sec+=$diff->h*60*60;
					$sec+=$diff->i*60;
					$sec+=$diff->s;
					$offtime=$sec+$offtime;

				}
				for($i=1; $i<$size-2; $i=$i+2){
					$date1=new DateTime($d1time[$i]);
					$date2=new DateTime($d1time[$i+1]);
					$diff=$date1->diff($date2);
					$sec=$diff->days *24*60*60;
					$sec+=$diff->h*60*60;
					$sec+=$diff->i*60;
					$sec+=$diff->s;
					$ontime=$sec+$ontime;
				}

			}
			else{
					for($i=0; $i<$size-2; $i=$i+2){
					$date1=new DateTime($d1time[$i]);
					$date2=new DateTime($d1time[$i+1]);
					$diff=$date1->diff($date2);
					$sec=$diff->days *24*60*60;
					$sec+=$diff->h*60*60;
					$sec+=$diff->i*60;
					$sec+=$diff->s;
					//echo $sec.'<br/>';
					$ontime=$sec+$ontime;
				}
				for($i=1; $i<$size-2; $i=$i+2){
					$date1=new DateTime($d1time[$i]);
					$date2=new DateTime($d1time[$i+1]);
					$diff=$date1->diff($date2);
					$sec=$diff->days *24*60*60;
					$sec+=$diff->h*60*60;
					$sec+=$diff->i*60;
					$sec+=$diff->s;
					//echo $sec.'<br/>';
					$offtime=$sec+$offtime;
				}
			}
		}
		$arrayfinal['on']=round(($ontime/60),2);
		$arrayfinal['off']=round(($offtime/60),2);
		//var_dump($arrayfinal);
		return $arrayfinal;
	}
		$jsonEncodedData=json_encode($d1result);
	?>
	<?php
		$device1=array();
		$device2=array();
		$device3=array();
		$graph=array();
		$device1=values('Device 1',$connection,$database);
		$device2=values('Device 2',$connection,$database);
		$device3=values('Device 3',$connection,$database);

		//on
		$graph=array(
        	    "chart" => array(
                 "caption" => "Time of how long device been On",
				  "yAxisName" => "Uptime(min)",
				   "xAxisName" => "Device",
                  "paletteColors" => "#40ff00",
                  "bgColor" => "#ffffff",
                  "borderAlpha"=> "20",
                  "canvasBorderAlpha"=> "0",
                  "usePlotGradientColor"=> "0",
                  "plotBorderAlpha"=> "10",
                  "showXAxisLine"=> "1",
                  "xAxisLineColor" => "#999999",
                  "showValues" => "1",
                  "divlineColor" => "#999999",
                  "divLineIsDashed" => "1",
                  "showAlternateHGridColor" => "0"
              	)
			);
		$graph["data"]=array();
		
		//Device 1 graph
		array_push($graph["data"],array(
		"label" =>'Device 1',
		"value" => $device1['on'],
		)
		);
		//Device 2 graph
		array_push($graph["data"],array(
		"label" =>'Device 2',
		"value" => $device2['on']
			)
		);
		
		//Device 3 graph
		array_push($graph["data"],array(
		"label" =>'Device 3',
		"value" => $device3['on']
			)
		);
		$jsonEncodedData = json_encode($graph);
	?>
	<?php
			$graphoff=array(
        	    "chart" => array(
                 "caption" => "Time of how long device been Off",
				  "yAxisName" => "Downtime(min)",
				   "xAxisName" => "Device",
                  "paletteColors" => "#FF0000",
                  "bgColor" => "#ffffff",
                  "borderAlpha"=> "20",
                  "canvasBorderAlpha"=> "0",
                  "usePlotGradientColor"=> "0",
                  "plotBorderAlpha"=> "10",
                  "showXAxisLine"=> "1",
                  "xAxisLineColor" => "#999999",
                  "showValues" => "1",
                  "divlineColor" => "#999999",
                  "divLineIsDashed" => "1",
                  "showAlternateHGridColor" => "0"
              	)
			);
		$graphoff["data"]=array();
		
		//Device 1 graph
		array_push($graphoff["data"],array(
		"label" =>'Device 1',
		"value" => $device1['off'],
		)
		);
		//Device 2 graph
		array_push($graphoff["data"],array(
		"label" =>'Device 2',
		"value" => $device2['off']
			)
		);
		
		//Device 3 graph
		array_push($graphoff["data"],array(
		"label" =>'Device 3',
		"value" => $device3['off']
			)
		);
		$jsonEncodedDataoff = json_encode($graphoff);
	?>
  	<?php
     	/* **Step 3:** Create a `columnChart` chart object using the FusionCharts PHP class constructor. Syntax for the constructor: `FusionCharts("type of chart", "unique chart id", "width of chart", "height of chart", "div id to render the chart", "data format", "data source")`   */

    	$columnChart = new FusionCharts("Bar2D", "Device Graph On" , 800, 400, "graph", "json",$jsonEncodedData);
     	/* **Step 4:** Render the chart */
     	$columnChart->render();
		$columnChartoff = new FusionCharts("Bar2D", "Device Graph Off" , 800, 400, "graphoff", "json",$jsonEncodedDataoff);
     	/* **Step 4:** Render the chart */
     	$columnChartoff->render();

}
  	?>
<h2> Graphs of devices </h2>
  	<div id="graph">
	</div>
	 <div id="graphoff">
	</div>
   </body>
</html>