<?php
  session_start();
  include("assets/isAdmin.php");
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
    <link rel="stylesheet" href="css/alertify.css">

    <link rel="stylesheet" href="css/themes/default.css">
    <script src="js/alertify.js"></script>
    
    <title>Közösségi szolgálat - felület</title>
  </head>
  <body onload="loadedPlace('table')">
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
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
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
                <a class="nav-link activeNav text-info" href="#">Helyszínek</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="http://ady-nagyatad.hu">Ady Főoldal</a>
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
                    <a class="dropdown-item" data-toggle="modal" data-target="#loginModal"><i class="fa fa-user text-info"></i> Bejelentkezés</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#regModal"><i class="fas fa-user-plus text-info"></i> Regisztráció</a>
                  </div>
                </li>
                <?php }?>
          </ul>
          </div>


        </div>
      </nav>
    <div class="intro bg-white">
      <div class="container">
        <div class="section">
          <div class="row">
            <div class="col-12 col-md-8 offset-md-2 text-center" style="margin-top:20px">
            <i class="fas fa-users fa-4x text-info"></i>
              <h3 class="text-info">Üdvözöllek!</h3>
              <p>Számos közösségi szolgálat közül választhatsz kedvedre, ezen a felületen!</p>   
              <img src="img/logo.png" alt="Közösségi szolgálat logo">         
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="intro bg-light text-dark" >
      <div class="container">
        <div class="section">
          <div class="row">
            <div class="col-12 col-md-8 offset-md-2 text-center" style="margin-top:20px;">
              <i class="fas fa-smile-wink fa-4x text-info"></i>
              <h3 class="text-info">Helyszínek</h3>
              <p>Válogass <span id="placeCount" class="text-info" style="font-weight:700;"></span> helyszínünk közül kedvedre!</p>
            </div>
            <div class="col-md-6">
              <div class="card bg-white">
                <div class="card-body">
                  <h5 class="card-title">Keresés helyszín alapján</h5>
                  <button class="btn btn-info" onclick="sortByPlaces()">Tovább</button>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card bg-white">
                <div class="card-body">
                  <h5 class="card-title">Szűrők törlése</h5>
                  <button class="btn btn-info" onclick="removeFilters()">Tovább</button>
                </div>
              </div>
            </div> 
            <div class="container">
              <div class="section bg-white text-dark border" style="margin-top:20px; margin-bottom:20px">
                <div class="table" style="width:100%;"></div>          
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      <div class="container">
        <div class="section">
          <div class="row">
            <div class="col-12 col-md-8 offset-md-2 text-center" style="margin-top:20px;margin-bottom:20px">
            <i class="fas fa-map-marked-alt fa-4x text-info"></i>
              <h3 class="text-info">Helyszíneim megtekintése!</h3>
              <p class="text-dark">A gombra kattintva megnézheted az eddig kiválaszott helyszíneket, és leadhatod a jelentkezésed.</p>   
              <a href="wantedplaces.php"><button class="btn btn-info" type="button">Megnézem!</button></a>         
            </div>
          </div>
        </div>
      </div>
    <footer class="page-footer font-small bg-dark">
        <div class="footer-copyright text-center py-3 text-white">Coded with <i class="fas fa-heart text-danger"></i> by:
            <a href="https://www.facebook.com/mrkhungary"> Mark</a>
        </div>
    </footer>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Bejelentkezés</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="alert" role="alert"></div>
            <form class="form-signin" action="/web/login.php" method="post">
              <div class="form-label-group">
                <input type="text" id="usr" class="form-control" name="usr" placeholder="Felhasználónév" minLength="6" required autofocus>
                <label for="usr">Felhasználónév</label>
              </div>               
              <div class="form-label-group">
                <input type="password" id="pass" class="form-control" name="password" placeholder="Jelszó" minLength="6" required>
                <label for="pass">Jelszó</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
          <input id="loginBtn" class="btn btn-lg btn-info btn-block text-uppercase" onclick="loginVar()" style="font-weight: 600;" value="Bejelentkezés" type="submit">
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Regisztráció</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="regAlert" role="alert"></div>
            <form class="form-signin" action="/web/register.php" method="post">
              <div class="form-label-group">
                <input type="text" id="regUsr" class="form-control" name="regusr" placeholder="Felhasználónév" minLength="6" required autofocus>
                <label for="regUsr">Felhasználónév</label>
              </div>
              <div class="form-label-group">
                <input type="email" id="regEmail" class="form-control" name="regemail" placeholder="Email" required>
                <label for="regEmail">Email</label>
              </div>               
                <div class="form-label-group">
                  <input type="text" id="regName" class="form-control" name="regname" placeholder="Vezetéknév keresztnév" required>
                  <label for="regName">Vezetéknév keresztnév</label>
                </div>                 
                <div class="form-label-group">
                  <input type="password" id="regPass" class="form-control" name="regpassword" placeholder="Jelszó" minLength="6" required>
                  <label for="regPass">Jelszó</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <input id="regBtn" class="btn btn-lg btn-info btn-block text-uppercase" onclick="regVar()" style="font-weight: 600;" value="Regisztráció" type="submit">
          </div>
        </div>
      </div>
    </div>

    <script src="js/script.js" charset="utf-8"></script>
    <script src="js/valid.js"></script>
  </body>
</html>
