<?php
if(isset($_GET['cname'])){
    $cname=$_GET['cname'];
}else{
    die();
}
$cname_2 = str_replace("-","%20",$cname);

//county details using restcountries api 
$urlcountry="https://restcountries.eu/rest/v2/name/"."$cname_2"."?fullText=true";
$datacountry= json_decode(file_get_contents($urlcountry),true);

//print_r($datacountry['flag']);
//echo "<br />";
//echo "<pre>";
//print_r($datacountry);
//echo "</pre>";

//Selected country Local infomation
$flag =$datacountry[0]['flag'];
$country_name =$datacountry[0]['name'];
$capital =$datacountry[0]['capital'];

$altSpellings_arr =$datacountry[0]['altSpellings'];
$altSpellings =$altSpellings_arr[0];

$region =$datacountry[0]['region'];
$subregion =$datacountry[0]['subregion'];
$population =$datacountry[0]['population'];
$area =$datacountry[0]['area'];
$gini =$datacountry[0]['gini'];

$currencies =$datacountry[0]['currencies'];
//$currencies =$currencies_arr[0]. "/" .$currency_arr[1];
$currencies =$currencies[0]['code']. "/" .$currencies[0]['name']. "/" .$currencies[0]['symbol'];
//$currencies_code =$currencies[0]['code'];
//$currencies_arr =$currencies[0]['name'];
//$currencies_arr =$currencies[0]['symbol'];

//map
$latlng_arr=$datacountry[0]['latlng'];
$lat=$latlng_arr[0];
$lng=$latlng_arr[1];

//covid details using rapid api
$curl = curl_init();
curl_setopt_array($curl, [
	CURLOPT_URL => "https://covid-193.p.rapidapi.com/statistics?country=".$cname,
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
<center>
	<h1><strong> <?php echo $country_name =$datacountry[0]['name'] ?></strong></h1><br>
	<img src="<?php echo $flag ?>" style="width:50%; height:50%; border:1px solid #A9A9A9"/>
</center>
<br><br>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
		<link href="css/main.css" rel="stylesheet">
		<link rel="stylesheet" href="js/bootstrap.js">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    </head>
    <body class="container">
        
        <table class="table" id="t02">
            <tr>
                <th>Capital</th>
				<th>Alter Spellings</th>
				<th>Region</th>
                <th>Sub Region</th>
                <th>Population</th>
				<th>Area</th>
				<th>Gini</th>
				<th>Currency</th>
            </tr>
            <tr>
                <td><?php echo $capital; ?></td>
                <td><?php echo $altSpellings; ?></td>
                <td><?php echo $region; ?></td>
                <td><?php echo $subregion; ?></td>
                <td><?php echo $population; ?></td>
                <td><?php echo $area; ?></td>
				<td><?php echo $gini; ?></td>
				<td><?php echo $currencies; ?></td>               
            </tr>
        </table>
		<br>
		
	    <h2> Covid States</h2>
		<table class="table"id="t03">
			<tr>
                <th>New Cases</th>
				<th>Active Cases</th>
				<th>Critical Cases</th>
				<th>Recoverd Cases</th>
				<th>Total Cases</th>
				<th>Cases Per 1M</th>  
				<th>New Deaths</th>
                <th>Total Deaths</th>
				<th>Deaths Per 1M</th>
				<th>Total PCR Testing</th>
				<th>Tests Per 1M</th>  
            </tr>
			
			<?php foreach ($dataTotal['response'] as $value){ ?>
			<tr>
				
				<td id="td03"><?php echo $value['cases']['new']; ?></td>
				<td><?php echo $value['cases']['active']; ?></td>
				<td><?php echo $value['cases']['critical']; ?></td>
				<td><?php echo $value['cases']['recovered']; ?></td>
				<td><?php echo $value['cases']['total']; ?></td>
				<td><?php echo $value['cases']['1M_pop']; ?></td>
				<td id="td03"><?php echo $value['deaths']['new']; ?></td>
				<td><?php echo $value['deaths']['total']; ?></td>
				<td><?php echo $value['deaths']['1M_pop']; ?></td>
				<td><?php echo $value['tests']['total']; ?></td>
				<td><?php echo $value['tests']['1M_pop']; ?></td>	 				
			</tr>
			<?php } ?>
		</table>
		<br>
		
		<h2> Google Map</h2>
		<center>
		<div id="map"></div> 
			<script> 
				function initMap() { 
					var test= {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>}; 
					var map = new google.maps.Map(document.getElementById('map'), { 
					zoom: 6, 
					center: test 
					});
					
					var marker = new google.maps.Marker({ 
					position: test, 
					map: map 
					}); 
				} 
			</script> 
		<script async defer src= "https://maps.googleapis.com/maps/api/js?key=AIzaSyAu3PF1122w0NqcnxhZAa28BbKfpT4Dm04&callback=initMap"> 
		</script> 
		</center>
		
		<br>
		<marquee>
			<h4>Copyright © IT2018014 </h4>
		</marquee>

	</body>
</html>
