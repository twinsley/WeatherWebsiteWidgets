<?php
/*
Plugin Name: Site Plugin for weather compass
Description: Site specific code changes for weather compass
*/
//updateData();
if(isset($_GET['function_name']) && !empty($_GET['function_name'])) {
    $function_name = $_GET['function_name'];
    switch($function_name) {
        case 'updateData':
            updateData();
            break;
        // Add additional cases for other functions as needed
    }
}
 add_action( 'wp_ajax_nopriv_update_data', 'updateData' );
add_action( 'wp_ajax_update_data', 'updateData' );
function updateData()
{
    $windSpeeds = array();
    $windDirections = array();
    $temperatures = array();
    $humidityLevels = array();
    $response = array();
    $conn = new mysqli("eussub1weatherstorage.mysql.database.azure.com","sqladmin","oM9cYJMqruDEvmi3Rh3QhxHKtcWNVVsvxPg@Qa^V","wx1");
    $airport = '42i';
    $query = "SELECT * FROM wxdata WHERE `identifier` = '$airport' order by date desc LIMIT 6";
    $result = $conn->query($query);
      while($row = $result->fetch_assoc()) {
       $windSpeeds[] = $row["windspeed"];
       $windDirections[] = $row["winddirection"];
       $temperatures[] = $row["temperature"];
       $humidityLevels[] = $row["humidity"];
    }

    $minWindSpeed = -1;
    $maxWindSpeed = 0;
    $avgSum = 0;
    $avgWindSpeed = 0;
    $avgDirection = 0;
    $avgTemp = 0;
    $avgHumidity = 0;

    foreach($windSpeeds as $speed)
    {
        if($speed < $minWindSpeed || $minWindSpeed == -1)
        {
            $minWindSpeed = $speed;
        }
        if($speed > $maxWindSpeed)
        {
            $maxWindSpeed = $speed;
        }
        $avgSum += $speed;       

    }
    $avgWindSpeed = $avgSum / count($windSpeeds);
    $avgSum = 0;

    foreach($windDirections as $direction)
    {
        $avgSum += $direction;
    }
    $avgDirection = $avgSum / count($windDirections);
    $avgSum = 0;

    foreach($temperatures as $temp)
    {
        $avgSum += $temp;
    }
    $avgTemp = $avgSum / count($temperatures);
    $avgSum = 0;

    foreach($humidityLevels as $humidity)
    {
        $avgSum += $humidity;
    }
    $avgHumidity = $avgSum / count($humidityLevels);
    $avgSum = 0;
    $res = array();
    $res[0] = $minWindSpeed;
    $res[1] = $avgWindSpeed;
    $res[2] = $maxWindSpeed;
    $res[3] = $avgDirection;
    $res[4] = $avgTemp;
    $res[5] = $avgHumidity;
    $res[6] = $airport;
   $response = implode(",", $res);

    echo $response;

    wp_die();
}
?>
