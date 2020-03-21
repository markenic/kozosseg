<?php 
  session_start();
  include("assets/conn.php");
  if (isset($_POST['usr'], $_POST['pass'],$_POST['usr'],$_POST['email'].$_POST['name'])){
    $username = $_POST["usr"];
    $email = $_POST["email"];
    $name = $_POST["name"];  
    $hashed_password = password_hash($_POST["pass"], PASSWORD_DEFAULT);
    $time = date("Y-m-d-h-m-i-sa");
    $sql = "INSERT INTO user (username, email,name,password,registered)
    VALUES ('$username', '$email','$name','$hashed_password','$time')";

    if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `user` WHERE username='".$username."'")) > 0){
      echo(json_encode(["success" => false,"response" => "Bad User",]));
    }
    else if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `user` WHERE email='".$email."'")) > 0){
      echo(json_encode(["success" => false,"response" => "Bad Email",]));
    }
    else{
      if ($conn->query($sql) === TRUE) {
        echo(json_encode(["success" => true,"response" => "",]));
      } else {
        echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
      }
    }
  }
 ?>
