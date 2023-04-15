/**
Compass Widget


*/

/**
function getWindSpeed
    Call the database for the last 5? entries where airportid = selected airportid
    Set variables for min and max. Average the readings, set var for avg 
    Set the display to the variables
    Call setArrow(int direction)


function setArrow(int direction)
    
*/
<?php
function updateData()
{
    $conn = new mysqli(); //connection string here
    $minWindSpeed = 0;
    $maxWindSpeed = 0;
    $avgSum = 0;
    $avgWindSpeed = 0;
    $avgDirection = 0;
    $windSpeeds = array();
    $windDirections = array();
    foreach($windSpeeds as $speed)
    {
        if($speed < $minWindSpeed)
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
    setArrow($avgDirection);
    
}
function setArrow(int $direction)
{
    // Set arrow graphic on the points of center and direction int
}
?>