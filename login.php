<?php 
  session_start();
  include("assets/conn.php");
  if (isset($_POST['usr']) and isset($_POST['pass'])){
    $username = $_POST["usr"];
    $result = mysqli_query($conn, "SELECT * FROM `user` WHERE username='$username'");
    if(mysqli_num_rows($result) > 0){
      while($row = $result->fetch_assoc()) {
        if(password_verify($_POST["pass"],$row["password"])){
          $_SESSION['user'] = array(
              'ID' => $row["id"],
              'usrName' => $row["username"],
              'name' => $row["name"],
              'pass' => $row["password"],
              'login' => 'logined'
          );
          echo(json_encode(["success" => true,"response" => "",]));
          
        }else{
          echo(json_encode(["success" => false,"response" => "Bad PW",]));
        }
      }
    }else{
      echo(json_encode(["success" => false,"response" => "Bad PW",]));
    }
  }else{
    header("Location: helyszin.php");
  }
 ?>
