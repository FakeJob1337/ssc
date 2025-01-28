<?php
require '/var/www/html/vendor/autoload.php';

use Carbon\Carbon;
$dep = $_POST['departament'];
$deps = join("', '",$dep);

$year_now = date("Y-01-01"); # +1 если на некст год и + 2 снизу
$next_year = date("Y-01-01", strtotime("+1 year")); 
$period = Carbon::parse("{$year_now}")->daysUntil("{$next_year}");
$dates_array = [];
foreach ($period as $key => $date) {
    $dates_array[$date->format('Y-m-d')] = 0;
}

$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$sql = "SELECT `start`, `end` FROM `duty` JOIN shtat ON duty.person_id = shtat.id and shtat.pr2 IN ('$deps')";
$result = $conn->query($sql);
while($row = $result->fetch()){
    $db_period = Carbon::parse($row['start'])->daysUntil($row['end']);
    foreach ($db_period as $key => $date) {
        $date = $date->format('Y-m-d');
        if (array_key_exists($date, $dates_array)) {
            $dates_array[$date] += 1;
        }
    }
}

foreach ($dates_array as $date => $value) {
    $dates_array[date("d-m-Y", strtotime($date))] = $dates_array[$date];
    unset($dates_array[$date]);
}
echo json_encode($dates_array);