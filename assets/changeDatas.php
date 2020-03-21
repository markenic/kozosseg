<?php
    session_start();
    include("conn.php");
    if(isset($_POST["wData"], $_SESSION["user"])){
        if($_POST["wData"]=="newPlace"){
            if(isset($_POST["name"],$_POST["teacher"],$_POST["place"],$_POST["type"])){
                $sql = "INSERT INTO places (name, teacher, place,type)
                VALUES ('".$_POST['name']."', '".$_POST['teacher']."', '".$_POST['place']."','".$_POST['type']."')";
                if ($conn->query($sql) === TRUE) {
                    echo(json_encode(["success" => true,"response" => "",]));
                } else {
                    echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                }
            }
        }else if($_POST["wData"]=="editPlace"){
            if(isset($_POST["name"],$_POST["teacher"],$_POST["place"],$_POST["type"],$_POST["id"])){
                $sql = "UPDATE places SET name='".$_POST['name']."', teacher='".$_POST['teacher']."', place='".$_POST['place']."', type='".$_POST['type']."' WHERE id=".intval($_POST['id']);
                if ($conn->query($sql) === TRUE) {           
                    echo(json_encode(["success" => true,"response" => "",]));
                } else {
                    echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                }
            }
        }else if($_POST["wData"]=="removeGlobalPlace"){
            if(isset($_POST["id"])){
                $sql = "DELETE FROM places WHERE id=".$_POST["id"];

                if ($conn->query($sql) === TRUE) {
                    echo(json_encode(["success" => true,"response" => "",]));
                } else {
                    echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                }

                $sqlp = "SELECT id,name,email,isAdmin,place1,place2,place3 FROM user";
                $resultp = $conn->query($sqlp);
                if(isset($resultp->num_rows)){
                    if ($resultp->num_rows > 0) {
                        $arr = Array();
                        while($row=$resultp->fetch_assoc()){
                            array_push($arr,$row);
                        }
                        $arr = (object)$arr;
                    } else {
                        echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                    }
                }else{
                    echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                }

                foreach ($arr as $key => $value) {
                    if($value["place1"] == $_POST["id"]){
                        $sql = "UPDATE user SET place1='-1' WHERE id=".intval($_SESSION["user"]['ID']);
                        if ($conn->query($sql) === TRUE) {           

                        } else {
                            echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                        }
                    }else if($value["place2"] == $_POST["id"]){
                        $sql = "UPDATE user SET place2='-1' WHERE id=".intval($_SESSION["user"]['ID']);
                        if ($conn->query($sql) === TRUE) {           
                        } else {
                            echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                        }
                    }else if($value["place3"] == $_POST["id"]){
                        $sql = "UPDATE user SET place3='-1' WHERE id=".intval($_SESSION["user"]['ID']);
                        if ($conn->query($sql) === TRUE) {           
                        } else {
                            echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                        }
                    }

                }   
            }
        }else if($_POST["wData"]=="setUserPlaces"){
            if(isset($_POST["place"])){
                $arr = $_POST["place"];

                $sql = "UPDATE user SET place1='".$arr[0]."', place2='".$arr[1]."', place3='".$arr[2]."' WHERE id=".intval($_SESSION["user"]['ID']);
                if ($conn->query($sql) === TRUE) {           
                    echo(json_encode(["success" => true,"response" => "",]));
                } else {
                    echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                }
            }
        }
        else if($_POST["wData"]=="removeCategory"){
            if(isset($_POST["id"])){
                $sql = "DELETE FROM places WHERE id=".$_POST["id"];

                if ($conn->query($sql) === TRUE) {
                    echo(json_encode(["success" => true,"response" => "",]));
                } else {
                    echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                }

                $sqlp = "SELECT id,name,email,isAdmin,place1,place2,place3 FROM user";
                $resultp = $conn->query($sqlp);
                if ($resultp->num_rows > 0) {
                    $arr = Array();
                    while($row=$resultp->fetch_assoc()){
                        array_push($arr,$row);
                    }
                    $arr = (object)$arr;
                } else {
                echo "empty";
                }
                foreach ($arr as $key => $value) {
                    if($value["place1"] == $_POST["id"]){
                        $sql = "UPDATE user SET place1='-1' WHERE id=".intval($_SESSION["user"]['ID']);
                        if ($conn->query($sql) === TRUE) {           
                            echo "success";
                        } else {
                            echo "error";
                        }
                    }else if($value["place2"] == $_POST["id"]){
                        $sql = "UPDATE user SET place2='-1' WHERE id=".intval($_SESSION["user"]['ID']);
                        if ($conn->query($sql) === TRUE) {           
                            echo "success";
                        } else {
                            echo "error";
                        }
                    }else if($value["place3"] == $_POST["id"]){
                        $sql = "UPDATE user SET place3='-1' WHERE id=".intval($_SESSION["user"]['ID']);
                        if ($conn->query($sql) === TRUE) {           
                            echo "success";
                        } else {
                            echo "error";
                        }
                    }
                }
            }
        }
        else if($_POST["wData"]=="removePlace"){
            if(isset($_POST["name"]) and isset($_POST["liid"])){
                $sql = "UPDATE user SET ".$_POST['liid']." = '-1' WHERE id=".intval($_SESSION["user"]['ID']);
                if ($conn->query($sql) === TRUE) {           
                    echo(json_encode(["success" => true,"response" => "",]));
                } else {
                    echo(json_encode(["success" => false,"response" => $conn->error,]));
                }
            }
        }
    }else if(isset($_SESSION["user"])==false){
        echo(json_encode(["success" => false,"response" => "Not logined user",]));
    }
?>