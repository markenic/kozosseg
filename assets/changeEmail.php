<?php
  session_name("kozossegLogin");
    session_start();
    include("conn.php");
    if(isset($_SESSION['user']["ID"])){
        if(isset($_POST["email"])){
            if($_POST["email"]==$_SESSION["user"]["email"]){
                echo(json_encode(["success" => false,"response" => "no need to change",]));
                return false;
            }
            $sql = "SELECT email FROM user WHERE id=".$_SESSION['user']['ID'];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE user SET email=? WHERE id=".$_SESSION['user']['ID']);
                $stmt->bind_param("s",$_POST["email"]);
                if ($stmt->execute()) { 
                    echo(json_encode(["success" => true,"response" => "",]));
                    $_SESSION["user"]["email"] = $_POST["email"];
                }else{
                    echo(json_encode(["success" => false,"response" => $stmt->error,]));
                }
            } else {
                echo(json_encode(["success" => false,"response" => "no datas",]));
            }
        }else{
            echo(json_encode(["success" => false,"response" => "no datas",]));
        }
    }else{
        echo(json_encode(["success" => false,"response" => "not logined user",]));
    }

?>