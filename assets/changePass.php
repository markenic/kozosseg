<?php
  session_name("kozossegLogin");
    session_start();
    include("conn.php");
    if(isset($_SESSION['user']["ID"])){
        if(isset($_POST["oldpass"],$_POST["newpass"])){

            $oldpw = trim($_POST["oldpass"]);
            $newpw = trim($_POST["newpass"]);
            if(strlen($newpw)<5){
                echo(json_encode(["success" => false,"response" => "low char",]));
                return false;
            }
            $sql = "SELECT password FROM user WHERE id=".$_SESSION["user"]['ID'];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row=$result->fetch_assoc()){
                    if (password_verify($oldpw, $row["password"])) {
                        $hashedpass = password_hash($newpw, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("UPDATE user SET password=? WHERE id=?");
                        $stmt->bind_param("si",$hashedpass,$_SESSION['user']['ID']);
                        if ($stmt->execute()) { 
                            echo(json_encode(["success" => true,"response" => "",]));
                            $_SESSION["user"]["pass"]=$hashedpass;
    
                        }else{
                            echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        }
                    }else{
                        echo(json_encode(["success" => false,"response" => "bad pass",]));
                    }
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