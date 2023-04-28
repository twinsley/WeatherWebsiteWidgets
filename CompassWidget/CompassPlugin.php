
<?php
updateData();
if(isset($_POST['function_name']) && !empty($_POST['function_name'])) {
    $function_name = $_POST['function_name'];
    switch($function_name) {
        case 'updateData':
            updateData();
            break;
        // Add additional cases for other functions as needed
    }
}
function updateData()
{
    $windSpeeds = array();
    $windDirections = array();
    $temperatures = array();
    $humidityLevels = array();
    $conn = new \mysqli("localhost","root","password","wx1"); //connection string here
    $airport = '42i';
    $query = "SELECT * FROM wxdata WHERE `identifier` = '$airport' order by date desc LIMIT 5";
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
    echo "<h1>Min windspeed: $minWindSpeed </h1>";
    echo "<h1>Max windspeed: $maxWindSpeed </h1>";
    echo "<h1>Avg windspeed: $avgWindSpeed </h1>";
    echo "<h1>Avg wind Direction: $avgDirection </h1>";
    echo "<h1>Avg Temperature: $avgTemp </h1>";
    echo "<h1>Avg Humidity: $avgHumidity </h1>";
}
?>
