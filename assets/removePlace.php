<?php
    session_start();
    include("conn.php");

    $jsonString = file_get_contents('datas/datas.json');
    $data = json_decode($jsonString, true);
    unset($data[$_POST["id"]]);
    $newJsonString = json_encode($data);
    file_put_contents('datas/datas.json', $newJsonString);
    print_r($data);

?>