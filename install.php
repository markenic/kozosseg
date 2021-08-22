<?php
  session_name("kozossegLogin");
  session_start();
  include("assets/isAdmin.php");
?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=7">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="vendor/alertify/css/alertify.css">
  <link rel="stylesheet" href="vendor/alertify/css/themes/default.css">
  <script src="https://www.google.com/recaptcha/api.js?render=6LcVGsMZAAAAAGd1lp4blTRC1NY-QslUGl6x0nZm"></script>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,600,700" rel="stylesheet">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link href="vendor/font-awesome/css/all.min.css" rel="stylesheet">
  <link href="vendor/venobox/venobox.css" rel="stylesheet">
  <link href="vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="vendor/aos/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="css/loader.css">
  <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
  <link href="vendor/threedots/three-dots.css" rel="stylesheet">
  <title>Közösségi szolgálat - Telepítés</title>
  <style>
    .adminpanel, .school{
      display:none;
    }
    .container{
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="intro text-dark">
    <div class="container" data-aos="zoom-out">
      <div class="section">
        <div class="row">
          <div class="col-12 col-md-8 offset-md-2 text-center section-header mt-5" data-aos="zoom-out" style="margin-top:20px;">
            <i class="fas fa-cogs text-main fa-3x"></i>
            <h3>Telepítés</h3>
            <p class="font-weight-bold"><span class="installPage text-main">1</span>/3</p>
          </div>
          <div class="col-md-12 database" data-aos="zoom-out">
            <div class="shadow-sm rounded bg-light">
                <div class="text-center section-header mt-3" data-aos="zoom-out">
                    <i class="fas fa-database text-main2 fa-2x mt-3"></i>
                    <h5>Adatbázis</h5>
                </div>
                <div class="mb-3" style="width:90%;margin:0 auto">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="ip" placeholder="IP cím">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="databaseName" placeholder="Adatbázis név">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="databaseUser" placeholder="Felhasználónév">    
                    </div>
                    <div class="input-group mb-2">
                        <input type="password" class="form-control" id="databasePass" placeholder="Jelszó">      
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="databasePort" placeholder="Port (opcionális)">      
                    </div>
                    <br>
                </div>
            </div>
          </div>
          <div class="col-md-12 school" data-aos="zoom-out">
            <div class="shadow-sm rounded bg-light">
                <div class="text-center section-header mt-3" data-aos="zoom-out">
                    <i class="fas fa-school text-main2 fa-2x mt-3"></i>
                    <h5>Iskola adatai</h5>
                </div>
                <div class="mb-3" style="width:90%;margin:0 auto">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control sname" placeholder="Iskola neve">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control shortname" placeholder="Név rövidítése">
                    </div>
                    <div class="input-group mb-2">
                        <input type="email" class="form-control semail" placeholder="E-mail cím">    
                    </div>
                    <div class="input-group mb-2">
                        <input type="phone" class="form-control sphone" placeholder="Telefonszám">      
                    </div>
                    <br>
                </div>
            </div>
          </div>
          <div class="col-md-12 adminpanel" data-aos="zoom-out">
            <div class="shadow-sm rounded bg-light">
                <div class="text-center section-header mt-3" data-aos="zoom-out">
                    <i class="fas fa-users-cog text-main2 fa-2x mt-3"></i>
                    <h5>Admin fiók</h5>
                </div>
                <div class="mb-3" style="width:90%;margin:0 auto">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="Felhasználónév">
                    </div>
                    <div class="input-group mb-2">
                        <input type="password" class="form-control" placeholder="Jelszó">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="E-mail cím">    
                    </div>
                    <br>
                </div>
            </div>
          </div>
        </div>
        <div class="row mb-3 " data-aos="zoom-out">
          <div class="col-md-12">
            <div class="progress mb-3 h-50 rounded shadow-sm">
              <div class="progress-bar asdasd rounded bg-main2" role="progressbar" aria-valuenow="0"
              aria-valuemin="0" aria-valuemax="100" style="width:33%"></div>
              </div>
            </div>
            <div class="mt-2" style="margin:0 auto;display: flex;">
              <a class="m-3 backTo">Vissza</a>
              <button class="btn btn-info btn-block shadow-sm" onclick="checkDatas()">Tovább</button>
            <div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php require_once("assets/footer.php") ?>

  <div class="loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
  </div>
  <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="vendor/counterup/counterup.min.js"></script>
    <script src="vendor/venobox/venobox.min.js"></script>
    <script src="vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="vendor/aos/aos.js"></script>
    <script src="js/main.js"></script>
    <script src="vendor/alertify/js/alertify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="vendor/font-awesome/js/all.min.js"></script>
    <script src="js/install.js"></script>
</body>

</html>