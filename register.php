<?php 
  session_name("kozossegLogin");
  session_start();
  
  include("assets/conn.php");
  if (isset($_POST['usr'], $_POST['pass'], $_POST['email'], $_POST['name'],$_POST["token"])){
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
  
      

    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
      $ip = $_SERVER['REMOTE_ADDR'];
  }
  if($captcha["success"]==true){
    $time = date("Y-m-d-h-m-i-sa");

    $stmt = $conn->prepare("INSERT INTO user (username, name, email, password, ip,class) VALUES (?, ?, ?, ?, ?, ?)");

    $username = trim($_POST["usr"]);
    $email = trim($_POST["email"]);
    $name = trim($_POST["name"]);
    $ogPSW = trim($_POST["pass"]);
    $hashed_password = password_hash($ogPSW, PASSWORD_DEFAULT);

    $class = trim($_POST["classid"]);

    $stmt->bind_param("ssssss", $username, $name, $email, $hashed_password,$ip,$class);


    $checkuser = $conn->prepare("SELECT username FROM `user` WHERE username=?");

    $checkuser->bind_param("s", $username);
    $checkuser->execute();
    $result = $checkuser->get_result();
    $fetch = $result->fetch_assoc();

    $checkemail = $conn->prepare("SELECT email FROM `user` WHERE email=?");
    $checkemail->bind_param("s", $email);
    $checkemail->execute();
    $result2 = $checkemail->get_result();
    $fetch2 = $result2->fetch_assoc();

    $sql = "SELECT * FROM classes";
    $result = $conn->query($sql);
    $inDataBase = false;
    $teacherID = 0;
    if ($result->num_rows > 0) {
        while($row=$result->fetch_assoc()){
            if($row["id"] == $class){
                $inDataBase = true;
            }
            if($row['className']=='Tanárok'){
              $teacherID=$row['id'];
            }
        }
    }

    if(is_array($fetch) and count($fetch)>0){
      echo(json_encode(["success" => false,"response" => "Bad User",]));
      $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
      "User: ".$username.PHP_EOL.
      "Bad Username".PHP_EOL.
      "-------------------------".PHP_EOL;
      file_put_contents('./logs/register_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    }else if(is_array($fetch2) and count($fetch2)>0){
      echo(json_encode(["success" => false,"response" => "Bad Email",]));
      $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
      "User: ".$username.PHP_EOL.
      "Bad Email address".PHP_EOL.
      "-------------------------".PHP_EOL;
      file_put_contents('./logs/register_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    }else{
      if($inDataBase == true){
        if($class==$teacherID){
          $teachercode = trim($_POST['teacherCode']);
          $teacherpass = $conn->prepare("SELECT pass FROM `teacherCode`");
          if($teacherpass->execute()){
            $result = $teacherpass->get_result();
            while ($row = $result->fetch_assoc()) {
              if($row['pass']==$teachercode){
                if ($stmt->execute()) { 
                  echo(json_encode(["success" => true,"response" => "",]));
                  $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                  "User: ".$username.PHP_EOL.
                  "Success register".PHP_EOL.
                  "-------------------------".PHP_EOL;
                  file_put_contents('./logs/register_'.date("j.n.Y").'.log', $log, FILE_APPEND);
              } else {
                  echo(json_encode(["success" => false,"response" => $stmt->error,]));
              }
              }else{
                echo(json_encode(["success" => false,"response" => 'bad teacher code',]));
              }
            }
          }
        }else{
          if ($stmt->execute()) { 
              echo(json_encode(["success" => true,"response" => "",]));
              $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
              "User: ".$username.PHP_EOL.
              "Success register".PHP_EOL.
              "-------------------------".PHP_EOL;
              file_put_contents('./logs/register_'.date("j.n.Y").'.log', $log, FILE_APPEND);
          } else {
              echo(json_encode(["success" => false,"response" => $stmt->error,]));
          }
        }
      }else{
        echo(json_encode(["success" => false,"response" => 'bad classid',]));

      }
    }
  }else{
    echo(json_encode(["success" => false, "response" => $captcha["error-codes"], ]));
  }
}
?>
