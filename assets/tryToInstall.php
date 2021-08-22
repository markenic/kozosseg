<?php
    session_name("kozossegLogin");
    error_reporting(0);
    session_start();
    if(isset($_POST["wData"])==false){
        echo(json_encode(["success" => false,"response" => "Missing wData",]));
        return false;
    }
    if($_POST["wData"]=="database"){
        if(isset($_POST["ip"],$_POST["dbname"],$_POST["dbuser"],$_POST["dbpass"])){
            $port = $_POST["dbport"] || 3306;
            $conn = new mysqli($_POST["ip"], $_POST["dbuser"], $_POST["dbpass"], $_POST["dbname"]);
    
            if ($conn->connect_error) {
                //2002 - Bad IP
                //1049 - Bad DB
                //1045 - Bad Username/password
                echo(json_encode(["success" => false,"response" => $conn->connect_errno,]));  
            }else{
                echo(json_encode(["success" => true,"response" => "success mysql connect",]));  
                $db = array('ip' => $_POST["ip"],'dbname' => $_POST["dbname"],'user' => $_POST["dbuser"]);
                $array = array('database'=>$db);
                $fp = fopen('results.json', 'w');
                fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));
                fclose($fp);
            }
        }else{
            echo(json_encode(["success" => false,"response" => "Missing datas",]));  
            $school = array('name' => $_POST["ip"],'shortName' => $_POST["dbname"],'email' => $_POST["dbuser"],'phoneNumber'=>'063054345');      

        }
    }else if($_POST["wData"]=="school"){
        if(isset($_POST["name"],$_POST["shortName"],$_POST["email"],$_POST["phone"])){
            echo(json_encode(["success" => true,"response" => "",]));  

        }else{
            echo(json_encode(["success" => false,"response" => "Missing datas",]));  
    
        }
    }


?>