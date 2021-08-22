<?php
  session_name("kozossegLogin");
  session_start();

  include("assets/conn.php");
  if (isset($_POST['usr'],$_POST["pass"],$_POST["token"])) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array('secret' => '6LcVGsMZAAAAAAyg_7nhDayk-kXoIJQPdQ5_V1HT', 'response' => $_POST["token"],'remoteip'=>$_SERVER["REMOTE_ADDR"]);

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $captcha = file_get_contents($url, false, $context);
    $captcha = json_decode($captcha,true);

    if($captcha["success"]==true){

      $stmt = $conn->prepare("SELECT * FROM `user` WHERE username=?");
      $username = trim($_POST["usr"]);
      $pass = $_POST["pass"];
      $stmt->bind_param("s", $username);
      if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
          while ($row = $result->fetch_assoc()) {
            if (password_verify($pass, $row["password"])) {
              echo(json_encode(["success" => true, "response" => "", ]));
              $_SESSION['user'] = array(
                'ID' => $row["id"],
                'userName' => $row["username"],
                'name' => $row["name"],
                'pass' => $row["password"],
                'email' => $row["email"],
                'classid' => $row["class"],
                'admin' => $row["isAdmin"],
                'login' => 'logined'
              );
              $_SESSION["lang"] = $row["language"];
              $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
              "User: ".$username.PHP_EOL.
              "Success login".PHP_EOL.
              "-------------------------".PHP_EOL;
              file_put_contents('./logs/login_'.date("j.n.Y").'.log', $log, FILE_APPEND);
              $time = date("Y-m-d h:i:s");
              $updateTime = $conn->prepare("UPDATE user SET last_Login=? WHERE id=?");
              $updateTime->bind_param('si', $time, $row["id"]);
              $updateTime->execute();


            } else {
              echo(json_encode(["success" => false, "response" => "Bad PW", ]));
              $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
              "User: ".$username.PHP_EOL.
              "Bad PW".PHP_EOL.
              "-------------------------".PHP_EOL;
              file_put_contents('./logs/login_'.date("j.n.Y").'.log', $log, FILE_APPEND);
            }
          }
        } else {
          echo(json_encode(["success" => false, "response" => "Bad PW", ]));
          $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
          "User: ".$username.PHP_EOL.
          "Bad PW".PHP_EOL.
          "-------------------------".PHP_EOL;
          file_put_contents('./logs/login_'.date("j.n.Y").'.log', $log, FILE_APPEND);
        }
      } else {
        echo(json_encode(["success" => false, "response" => $stmt->error, ]));
        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "User: ".$username.PHP_EOL.
        $stmt->error.PHP_EOL.
        "-------------------------".PHP_EOL;
        file_put_contents('./logs/login_'.date("j.n.Y").'.log', $log, FILE_APPEND);
      }
    }else{
      echo(json_encode(["success" => false, "response" => $captcha["error-codes"], ]));
      $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
      "User: ".$username.PHP_EOL.
      $captcha["error-codes"].PHP_EOL.
      "-------------------------".PHP_EOL;
      file_put_contents('./logs/login_'.date("j.n.Y").'.log', $log, FILE_APPEND);
      
    }
  } else {
    header("Location: helyszin.php");
  }
?>