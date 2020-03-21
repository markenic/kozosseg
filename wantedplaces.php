<?php
  session_start();
  include("assets/isAdmin.php");
  if(isset($_SESSION['user']) == false){
    header("Location: helyszin.php");
  }
?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
  <meta http-equiv="X-UA-Compatible" content="IE=7">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link href="fontawesome/css/all.css" rel="stylesheet">

    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/themes/default.css">
    <link rel="stylesheet" href="css/alertify.css">

    <script src="js/alertify.js"></script>
    <title>Közösségi szolgálat - felület</title>
  </head>
  <body onload="loadedPlace('getPlace')">
  <div class="notification"></div>
    <div class="page-hero image" id="banner">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2 text-center">
              <div class="title">
                <h1 class="display-4 text-white">Ady Endre gimnázium</h1>
                <h4 class="text-white">Jelentkezz itt a közösségi szolgálatra!</h4>
                <button class="btn btn-info signupBtn">Jelentkezz most!</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand" href="./">Ady</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown-7" aria-controls="navbarNavDropdown-7"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown-7">
            <ul class="navbar-nav">
              <?php if(isset($_SESSION["user"]) and $isAdmin==1){ ?>
                <li class="nav-item mx-2">
                  <a class="nav-link" href="admin.php">Admin</a>
                </li>
              <?php }?>
              <li class="nav-item mx-2">
                <a class="nav-link" href="helyszin.php">Helyszínek</a>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
          <?php if(isset($_SESSION["user"])){ ?>
            <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user text-info"></i> <?php echo($_SESSION["user"]["name"]) ?>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="settings.php"><i class="fas fa-users-cog text-info"></i> Beállítások</a>
                    <a class="dropdown-item" href="wantedplaces.php"><i class="fas fa-map-marked-alt text-info"></i> Választott helyszínek</a>
                    <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt text-info"></i> Kijelentkezés</a>
                    </div>
                  </div>
                </li>
              <?php } else{ ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user text-info"></i> Fiók
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="login.php"><i class="fa fa-user text-info"></i> Bejelentkezés</a>
                    <a class="dropdown-item" href="register.php"><i class="fas fa-user-plus text-info"></i> Regisztráció</a>
                  </div>
                </li>
                <?php }?>
            </ul>
          </div>
        </div>
    </nav>
    <div class="intro bg-white" style="height:50vh">
      <div class="container">
        <div class="section">
          <div class="row">
            <div class="col-12 col-md-8 offset-md-2 text-center" style="margin-top:40px;">
                <i class="fas fa-map-marked-alt fa-4x text-info"></i>
                <h3 class="text-info">Választott helyszínek</h3>
                <p>Itt módosíthatod választásaid</p>
                <div class="cards"></div>   
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="page-footer font-small bg-dark">
        <div class="footer-copyright text-center py-3 text-white">Coded with <i class="fas fa-heart text-danger"></i> by:
            <a href="https://www.facebook.com/mrkhungary"> Mark</a>
        </div>
    </footer>
    <script src="js/script.js" charset="utf-8"></script>
  </body>
</html>
