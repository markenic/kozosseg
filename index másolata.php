<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" charset="utf-8"></script>
    <title>Közösségi szolgálatra jelentkezés</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <h5 class="card-title text-center">Belépés</h5>
              <form class="form-signin" action="index.php" method="post">
                <div class="form-label-group">
                  <input type="text" id="inputEmail" class="form-control" name="om" placeholder="OM azonosító" required autofocus>
                  <label for="inputEmail">OM azonosító</label>
                </div>

                <div class="form-label-group">
                  <input type="password" id="inputPassword" class="form-control" name="pass" placeholder="Jelszó" required>
                  <label for="inputPassword">Jelszó</label>
                </div>

                <button class="btn btn-lg btn-danger btn-block text-uppercase" type="submit">Belépés</button>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<?php


function reg($usr,$pass){
  include "assets/conn.php";
  if(strlen($usr)<5)
  {
      echo "nem elég hosszú";
  }else{

    addUser($usr,$pass);
  }

}
reg($_POST["om"],$_POST["pass"])
?>
