<?php
    session_start();
    include("assets/conn.php");

    if(isset($_SESSION["user"]) and isset($_GET["reqType"])){
        if(isset($_GET["place"]) and $_GET["reqType"]=="setPlace"){
            $sql = "UPDATE user SET place1='".$_GET['place'][0]."', place2='".$_GET['place'][1]."', place3='".$_GET['place'][2]."' WHERE id=".intval($_SESSION["user"]['ID']);
            if ($conn->query($sql) === TRUE) {           
                echo "success";
            } else {
                echo "error";
            }
        }
        else if($_GET["reqType"]=="getPlace"){
            $sql = "SELECT place1,place2,place3 FROM user WHERE id=".intval($_SESSION["user"]['ID']);
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {      
                    $arr = [
                        $row["place1"],
                        $row["place2"],
                        $row["place3"],
                    ];
                    echo(json_encode(["success" => true,"response" => $arr,]));
                }
            } else {
                echo(json_encode(["success" => false,"response" => "0 result",]));
            }
        }
        else if($_GET["reqType"]=="setGPlaces"){
            
            $jsonString = file_get_contents('assets/datas/datas.json');
            $data = json_decode($jsonString, true);
            $data[$_GET['idd']]['name'] = $_GET['name'];
            $data[$_GET['idd']]['teacher'] = $_GET['teacher'];
            $data[$_GET['idd']]['place'] = $_GET['place'];
            $data[$_GET['idd']]['type'] = intval($_GET['type']);
            $newJsonString = json_encode($data);
            file_put_contents('assets/datas/datas.json', $newJsonString);
            echo "success";
        }
        else if($_GET["reqType"]=="newPlaces"){
            
            $jsonString = file_get_contents('assets/datas/datas.json');
            $data = json_decode($jsonString, true);

            $newobj = [
                id=>intval(count($data)),
                name=>$_GET['name'],
                teacher=>$_GET['teacher'],
                place=>$_GET['place'],
                type=>intval($_GET['type']),
            ];
            $data[count($data)]=$newobj;        
            $newJsonString = json_encode($data);
            file_put_contents('assets/datas/datas.json', $newJsonString);
            print_r($data);
        }
        else if($_GET["reqType"]=="removePlace"){
            
            if(isset($_GET["name"]) and isset($_GET["liid"])){
                echo $_SESSION["user"]['ID'];
                $sql = "UPDATE user SET ".$_GET['liid']." = '-1' WHERE id=".intval($_SESSION["user"]['ID']);
                if ($conn->query($sql) === TRUE) {           
                    echo "success";
                } else {
                    echo $conn->error;
                }
            }
        }
    }
    else if(isset($_SESSION["user"])==false){
        echo(json_encode(["success" => false,"response" => "Not logined user",]));
    }
    else{
        echo(json_encode(["success" => false,"response" => "error",]));
    }

?>