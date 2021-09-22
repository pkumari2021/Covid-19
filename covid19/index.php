<?php
$urlsl="https://www.hpb.health.gov.lk/api/get-current-statistical"; //API URL
//Convert into array
$datasl=json_decode(file_get_contents($urlsl),true);//To create an array

//Local infomation
$local_new_cases=$datasl["data"]["local_new_cases"];
$local_new_deaths=$datasl["data"]["local_new_deaths"];
$local_total_cases=$datasl["data"]["local_total_cases"];
$local_deaths=$datasl["data"]["local_deaths"];
$local_recovered=$datasl["data"]["local_recovered"];
$local_active_cases=$datasl["data"]["local_active_cases"];
$local_total_number_in_hospital=$datasl["data"]["local_total_number_of_individuals_in_hospitals"];
$total_pcr=$datasl["data"]["total_pcr_testing_count"];
$update_date_time=$datasl["data"]["update_date_time"];

//Daily PCR Information
$pcr_info=$datasl['data']['daily_pcr_testing_data'];

//Patient in Hospitals
$patient_info=$datasl['data']['hospital_data'];


 //Global Information
$global_new_cases=$datasl['data']['global_new_cases'];
$global_total_cases=$datasl['data']['global_total_cases'];
$global_deaths=$datasl['data']['global_deaths'];
$global_new_deaths=$datasl['data']['global_new_deaths'];

//echo "<pre>";
//print_r($datasl);
//echo "</pre>";

$urlcountry="https://restcountries.eu/rest/v2/alpha/lk"; 
$datacountry= json_decode(file_get_contents($urlcountry),true);
$population=$datacountry['population'];
//$casesPer= round(((round(($local_total_cases/($population/1000000)),2))/100),2);
//$deathsPer= round(((round(($local_deaths/($population/1000000)),2))/100),2);
$casesPer= round(($local_total_cases/($population/1000000)),2);
$deathsPer= round(($local_deaths/($population/1000000)),2);

//all country covid information
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://covid-193.p.rapidapi.com/statistics",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: covid-193.p.rapidapi.com",
		"x-rapidapi-key: eaeb1571acmsh8d5b716e094606fp1961dbjsna4465da4ff2b"
	],
 ]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$dataTotal=json_decode($response,true);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
		<link href="css/main.css" rel="stylesheet">
		<link rel="stylesheet" href="js/bootstrap.js">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container">
          <img src="img/cov-img.png" style="width:100%;height:200; padding-top:5px" >
        <div class="content">
           <h1 align="center">Covid19 Information</h1>
        </div> </div> <br>	
		
	    <div class="container">
	 
        <h2>Local Cases</h2>
		
		<div class="card">
			<div class="container">
				<h4>New Cases</h4> 
				<h3>&plus;<b><?php echo $local_new_cases; ?></b></h3> 
			</div>
		</div>	
		
		<div class="card">
			<div class="container">
				<h4>New Deaths</h4> 
				<h3 style="color:red">&plus;<b><?php echo $local_new_deaths; ?></b></h3>
			</div>
		</div>
		
		<div class="card">
			<div class="container">
				<h4>Total Cases</h4> 
				<h3 style="color:#2929a3"><b><?php echo $local_total_cases; ?></b></h3> 
			</div>
		</div>
		
		<div class="card">
			<div class="container">
				<h4>Active Cases</h4> 
				<h3 style="color:blue"><b><?php echo $local_active_cases; ?></b></h3> 
			</div>
		</div>
		
		<div class="card">
			<div class="container">
				<h4>Total Deaths</h4> 
				<h3 style="color:red"><b><?php echo  $local_deaths; ?></b></h3>
			</div>
        </div>

		<div class="card">
			<div class="container">		
				<h4>Total Recovered</h4> 
				<h3 style="color:green"><b><?php echo $local_recovered; ?></b></h3>		
			</div>
		</div>
		
		<div class="card">
			<div class="container">		
				<h4>Number of PCR Testing</h4> 
				<h3 style="color:#cc0099"><b><?php echo $total_pcr; ?></b></h3>		
			</div>
		</div>
		
		<div class="card">
			<div class="container">		
				<h4>Number of Patients in the Hospital</h4> 
				<h3><b><?php echo $local_total_number_in_hospital; ?></b></h3>		
			</div>
		</div>
		
		<div class="card">
			<div class="container">		
				<h4>Cases per 100 PCR Testing</h4> 
				<h3><?php echo round((round(($local_total_cases/$total_pcr),2)*100),2); ?></h3>	
			</div>
		</div>
		
		<div class="card">
			<div class="container">		
				<h4>Deaths Per 1 Million</h4> 
				<h3><?php echo $deathsPer; ?></h3>		
			</div>
		</div>
		
		<div class="card">
			<div class="container">		
				<h4>Cases Per 1 Million</h4> 
				<h3><?php echo $casesPer; ?></h3>		
			</div>
		</div>&nbsp;
		
		<img src="img/icon2.gif" alt="Avatar" style="width:65px;height:75px; padding-top:15px">
		<img src="img/icon1.gif" alt="Avatar" style="width:65px;height:75px; padding-top:15px">	
		<img src="img/icon3.gif" alt="Avatar" style="width:65px;height:75px; padding-top:15px">	
		<img src="img/icon5.gif" alt="Avatar" style="width:65px;height:75px; padding-top:15px">
        <img src="img/icon4.gif" alt="Avatar" style="width:65px;height:75px; padding-top:15px">
  	
		<br><br><br>
	
       <center><h2>Polymerase Chain Reaction (PCR) Testing in Sri Lanka</h2> <br/>  </center>
        <div class="card1">
			<div class="container1">		   
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['Date', 'Count'],
					<?php foreach ($pcr_info as $value){ ?>
					['<?php echo $value["date"] ?>',  <?php echo $value["count"] ?>],
					<?php } ?>
				]);

				var options = {
					title: 'Daily PCR Testing',
					hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
					vAxis: {minValue: 0},
					bar: {groupWidth: "95%"},
					legend: { position: "none" }
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('curve_chart'));
	
				chart.draw(data, options);
			}
		</script>
		<div id="curve_chart" style="width: 100%; height: 450px"></div> 
		</div><!--container-->
		</div><!--card-->
		
		<br><br>
  <center>
		<h2>Global Cases</h2> <br>
        
		<div class="flip-card">
			<div class="flip-card-inner">
				<div class="flip-card-front">
					<img src="img/icon2.gif" alt="Avatar" style="width:150px;height:150px; padding-top:15px">
				</div>
				<div class="flip-card-back">
					<h2>New Cases</h2> 
					&plus;<?php echo $global_new_cases; ?>
					<img src="img/icon2.gif" alt="Avatar" style="width:60px;height:75px; padding-top:15px">		
				</div>
			</div>
		</div>
      
		<div class="flip-card">
			<div class="flip-card-inner">
				<div class="flip-card-front">
					<img src="img/icon3.gif" alt="Avatar" style="width:150px;height:150px; padding-top:15px">
				</div>
				<div class="flip-card-back">
					<h2>New Deaths</h2> 
					&plus;<?php echo $global_new_deaths; ?>
					<img src="img/icon3.gif" alt="Avatar" style="width:75px;height:75px; padding-top:15px">
				</div>
			</div>
		</div>
		
		 <div class="flip-card">
			<div class="flip-card-inner">
				<div class="flip-card-front1">
					<img src="img/icon2.gif" alt="Avatar" style="width:150px;height:150px; padding-top:15px ">
				</div>
				<div class="flip-card-back1">
					<h2>Total Cases</h2> 
					<?php echo $global_total_cases; ?>
					<img src="img/icon2.gif" alt="Avatar" style="width:60px;height:75px; padding-top:15px">	
				</div>
			</div>
		</div> 
		
		
		<div class="flip-card">
			<div class="flip-card-inner">
				<div class="flip-card-front1">
					<img src="img/icon3.gif" alt="Avatar" style="width:150px;height:150px; padding-top:15px">
				</div>
				<div class="flip-card-back1">
					<h2>Total Deaths</h2> 
					<?php echo $global_deaths; ?>
					<img src="img/icon3.gif" alt="Avatar" style="width:60px;height:75px; padding-top:15px">
					
				</div>
			</div>
		</div> 		
</center>	
		<br><br>
		<center><h2>COVID19 Information in All Countries</h2></center>
		<div style="overflow-y:scroll;">
		<table class="table" id="t01" style="overflow-y:scroll;">
			<tr>
				<th>Country</th>
				<th>Continent</th>
				<th>New Cases</th>
				<th>New Deaths</th>
				<th>Total Cases</th> 
				<th>Total Deaths</th>
				<th>Recovered Cases</th>				
			</tr>	

			<?php foreach ($dataTotal['response'] as $value){ ?>
			    <tr onclick="window.location.href='country.php?cname=<?php echo $value['country'];?>'">
                    <td  class="text-custom" id="td01"><?php echo $value['country'];?></td>
					<td><?php echo $value['continent']; ?></td>
					<td id="td02"><?php echo $value['cases']['new']; ?></td>
					<td id="td03"><?php echo $value['deaths']['new']; ?></td>
					<td><?php echo $value['cases']['total']; ?></td>
					<td><?php echo $value['deaths']['total']; ?></td>
					<td><?php echo $value['cases']['recovered']; ?></td>  
				</tr>
			<?php } ?>
		</table>
		</div>
	    
	
		<br>
		<marquee>
			<h4>Copyright © IT2018014 | Updated : <?php echo $update_date_time; ?> </h4>
		</marquee>
	</div>
    </body>
	
	
</html>
 