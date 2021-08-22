<?php
  session_name("kozossegLogin");
  session_start();
  include("assets/isAdmin.php"); 
  if(isset($_SESSION["lang"])&&$_SESSION["lang"]=="english"){
    include("assets/en.php");
  }else{
    include("assets/hu.php");
  }
?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=7">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./vendor/alertify/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="./vendor/alertify/css/themes/default.css">
  <script src="https://www.google.com/recaptcha/api.js?render=6LcVGsMZAAAAAGd1lp4blTRC1NY-QslUGl6x0nZm"></script>

  <link type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,600,700" rel="stylesheet">
  <link type="text/css" href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link type="text/css" href="./vendor/font-awesome/css/all.min.css" rel="stylesheet">
  <link type="text/css" href="./vendor/venobox/venobox.css" rel="stylesheet">
  <link type="text/css" href="./vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link type="text/css" href="./vendor/aos/aos.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="./css/loader.css">
  <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
  <link type="text/css" href="./vendor/threedots/three-dots.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="./css/style.css">

  <title><?php echo($lang["title"])?></title>
</head>

<body>
  <?php require_once("assets/header.php") ?>
  <div id="hero" class="clearfix">
    <div class="container d-flex h-100">
      <div class="row justify-content-center align-self-center" data-aos="fade-up">
        <div class="col-md-6 intro-info order-md-first order-last" data-aos="zoom-in" data-aos-delay="100">
          <h4><span class="text-main font-weight-bold">Kaposvári SZC Nagyatádi Ady Endre Technikum és Gimnázium</span><br><?php echo($lang["sign up"]) ?></h4>
          <a href="#places" class="icon" style="background-color:rgb(232, 65, 65,.2)">
            <ion-icon size="large" style="color:white" name="arrow-down-outline"></ion-icon>
          </a>

        </div>

        <div class="col-md-6 intro-img order-md-last order-first" data-aos="zoom-out" data-aos-delay="200">
          <img src="img/img.png" alt="" class="img-fluid">
        </div>
      </div>

    </div>
  </div>
  <div class="intro text-dark">
    <div id='places' class="container">
      <div class="section">
        <div class="row">
          <div class="col-12 col-md-8 offset-md-2 text-center section-header" data-aos="zoom-out" style="margin-top:20px;">
            <ion-icon style="font-size:62px;" class="text-main" name="compass"></ion-icon>
            <h3><?php echo($lang["places"])?></h3>
              <?php echo($lang["underPlaces"])?>
          </div>

          <div class="col-md-6" data-aos="zoom-out">
            <div class="shadow-sm rounded bg-white">
              <div class="card-body">
                <h5 class="card-title header-title font-weight-bold"><?php echo($lang["searchByPlace"])?></h5>
                <button class="btn btn-info" onclick="sortByPlaces()"><?php echo($lang["ok"])?></button>
              </div>
            </div>
          </div>
          <div class="col-md-6" data-aos="zoom-out">
            <div class="shadow-sm rounded bg-white">
              <div class="card-body">
                <h5 class="card-title header-title font-weight-bold"><?php echo($lang["filterClear"])?></h5>
                <button class="btn btn-info" onclick="removeFilters()"><?php echo($lang["ok"])?></button>
              </div>
            </div>
          </div>
          <div class="container" data-aos="zoom-in">
            <div class="section bg-white text-dark shadow-sm rounded" style="margin-top:20px; margin-bottom:20px">
              <div class="placeTable" style="width:100%;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="section">
      <div class="row">
        <div class="col-12 col-md-8 offset-md-2 text-center section-header mt-3 mb-3" data-aos="zoom-out">
            <ion-icon style="font-size:62px;" class="text-main" name="compass"></ion-icon>
            <h3><?php echo($lang["selected"])?></h3>
            <a href="wantedplaces.php"><button class="btn btn-info" type="button"><?php echo($lang["ok"])?></button></a>

          </div>
      </div>
    </div>
  </div>
  <?php require_once("assets/footer.php") ?>
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle"><?php echo($lang["login"])?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="alert" role="alert"></div>
          <form class="form-signin" action="/web/login.php" method="post">
          <div class="input-group sideicon mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="userlogo"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" id="usr" class="form-control" placeholder=<?php echo($lang["username"])?> required aria-label="Username" name="usr" aria-describedby="userlogo">
          </div>
            
          <div class="input-group sideicon mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="passlogo"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" id="pass" class="form-control" placeholder=<?php echo($lang["password"])?> required aria-label="Pass" name="password" aria-describedby="passlogo">
          </div>

          </form>
        </div>
        <div class="modal-footer">
          <button id="loginBtn" class="btn btn-lg btn-info btn-block mb-3" onclick="loginVar()"><?php echo($lang["login"])?></button>
            
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle"><?php echo($lang["reg"])?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="regAlert" role="alert"></div>
          <form class="form-signin" action="/web/register.php" method="post">
            <div class="input-group sideicon mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="userlogo"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" id="regUsr" class="form-control" placeholder=<?php echo($lang["username"])?> onkeydown="checkForValid(this)" required aria-label="Username" name="regusr" aria-describedby="userlogo">
              <p class='text-danger mt-2 w-100 d-none' id='errorregUsr'></p>
            </div>
            <div class="input-group sideicon mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="emaillogo"><i class="fas fa-envelope-open-text"></i></span>
              </div>
              <input type="email" id="regEmail" class="form-control" placeholder=<?php echo($lang["email"])?> required onkeydown="checkForValid(this)" aria-label="email" name="regusr" aria-describedby="emaillogo">
              <p class='text-danger mt-2 w-100 d-none' id='errorregEmail'></p>
            </div> 
            <div class="input-group sideicon mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="namelogo"><i class="fas fa-signature"></i></span>
              </div>
              <input type="text" id="regFirstName" class="form-control" placeholder="<?php echo($lang["lastname"])?>" required onkeydown="checkForValid(this)" aria-label="firstName" name="regFirstName" aria-describedby="namelogo">
              <input type="text" id="regLastName" class="form-control" placeholder=<?php echo($lang["firstname"])?> required onkeydown="checkForValid(this)" aria-label="lastName" name="regLastName" aria-describedby="namelogo">

              <p class='text-danger mt-2 w-100 d-none' id='errorregName'></p>
            </div>         
            <div class="input-group sideicon mb-3">
              <select onchange='changeSelect(this)' class="form-control class" name="classes"></select>
            </div>
            <div class="input-group mb-3 teacherCode d-none">
              <div class="input-group-prepend">
                <span class="input-group-text" id="pass"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" id="regTeacherCode" class="form-control" placeholder=<?php echo($lang["teachercode"])?> required onkeydown="checkForValid(this)" aria-label="password" name="regTeacherCode" aria-describedby="passlogo">
              <p class='text-danger mt-2 w-100 d-none' id='errorregTeacherCode'></p>
            </div>  

            <div class="input-group sideicon mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="pass"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" id="regPass" class="form-control" placeholder=<?php echo($lang["password"])?> required onkeydown="checkForValid(this)" aria-label="password" name="regPass" aria-describedby="passlogo">
              <p class='text-danger mt-2 w-100 d-none' id='errorregPass'></p>
            </div>    
          </form>
        </div>
        <div class="modal-footer">
          <button id="regBtn" class="btn btn-info btn-block mb-3" onclick="regVar()"><?php echo($lang["reg"])?></button>
        </div>
      </div>
    </div>
  </div>
  <div id="cookieConsent">
    <i class="fas fa-cookie-bite fa-lg"></i> <?php echo($lang["cookies"])?><a class="cookieConsentOK"><?php echo($lang["ok"])?></a>
  </div>
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
    <script src="js/script.js"></script>
    <script src="js/valid.js"></script>

  <script>

    $(document).ready(function(){   
      setTimeout(function () {
          $("#cookieConsent").fadeIn(200);
      }, 4000);
      $("#closeCookieConsent, .cookieConsentOK").click(function() {
          $("#cookieConsent").fadeOut(200);
      }); 
  }); 
  </script>
</body>

</html>