<?php


$data = json_decode($_POST["data"], true);

$search_col = $data["searchColumn"];
$search_str = "";

foreach ($search_col as $key => $value) {
    $search_str.=$value.", ";
}


$search_str = substr($search_str,0, -2);
$order_str = "";
$sum_str = "";
$c = 0;
$filt_word = "WHERE";
$char = "=";

foreach(array_map(null,$data["filterColumn"], $data["methodColumn"], $data["valueColumn"]) as [$col, $method, $value]){
    $col_str = "";
    if ($c) {
        $filt_word = " AND";
    }
    if ($method == "ASC" or $method == "DESC") {
        $order_str = " ORDER BY $col $method";
        continue; 
    }
    if ($method == "GREATER") {
        $char = ">";
    }

    if ($method == "LESS") {
        $char = "<";
    }
    if ($method == "LIKE") {
        $char = "LIKE";
    }
    


    $col_str = "$col $char '$value'";

    $sum_str.= "$filt_word ".$col_str;
    $c = 1;
}
$sum_str .= $order_str;


$sql = "SELECT $search_str FROM `shtat` LEFT JOIN `personal_information` ON shtat.id = personal_information.shtat_id $sum_str";
$conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
$result = $conn->query($sql);
while($row = $result->fetch(PDO:: FETCH_ASSOC)){
    $info = "";
    foreach ($row as $key => $value) {
        $info.= "<td>".$value."</td>";
    }
    echo "<tr>". $info ."</tr>";
}

#Сортировка order by $n $type
#Если 1 значение where $col = "$value" Если больше 1 AND $col = "$value" WHERE меняем на AND При счетчике больше одного
# $col Like "%value%"