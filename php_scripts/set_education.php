<?php
$data = json_decode($_POST['data'], true);
$id = $_POST['id'];


foreach ($data as $key => $col) {
    $col_name_str = "`shtat_id`, ";
    $value_str = "'$id', ";
    foreach ($col as $col_name => $value) {
        $col_name_str .= "`$col_name`, ";
        $value_str .= "'$value',";
    }
    $col_name_str  = substr($col_name_str,0, -2);
    $value_str = substr($value_str,0, -1);

    $conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
    $sql = "INSERT INTO `education`( $col_name_str) VALUES ($value_str);";
    $res = $conn->query($sql)->fetch();
}


