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
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="vendor/alertify/css/alertify.css">
  <link rel="stylesheet" href="vendor/alertify/css/themes/default.css">
  <script src="https://www.google.com/recaptcha/api.js?render=6LcVGsMZAAAAAGd1lp4blTRC1NY-QslUGl6x0nZm"></script>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,600,700" rel="stylesheet">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,200;0,400;0,500;0,600;1,100&display=swap" rel="stylesheet">

  <link href="vendor/font-awesome/css/all.min.css" rel="stylesheet">
  <link href="vendor/venobox/venobox.css" rel="stylesheet">
  <link href="vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="vendor/aos/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="css/loader.css">
  <link rel="stylesheet" href="css/profile.css">

  <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
  <link href="vendor/threedots/three-dots.css" rel="stylesheet">

  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css"
    integrity="sha256-IvM9nJf/b5l2RoebiFno92E5ONttVyaEEsdemDC6iQA=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
    integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
  <title><?php echo($lang["title"])?></title>
</head>

<body>
  <?php require_once("assets/header.php") ?>
  <div class="container" style="margin-top:7%">
  <div class="row">
      <div class="col-lg-6 col-xl-6">
          <div class="card-box text-center round">
          <div class="icon" style="background-color:rgba(79, 219, 142,0.2);color:rgb(67, 181, 118)">
              <i class="fas fa-user fa-2x"></i>
            </div>
            <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Jelentkezők száma">Jelentkezők száma</h5>
            <h3 class=" font-weight-bold" title="Jelentkezők/Összes felhasználó" id="usersCount"></h3>
          </div>
      </div>
      <div class="col-lg-6 col-xl-6">
          <div class="card-box text-center round">
            <div class="icon" style="background-color:rgba(219, 79, 79,0.2);color:rgb(219, 79, 79)">
              <i class="fas fa-map-marker-alt fa-2x"></i>
            </div>
            <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Jelentkezők száma">Helyszínek száma</h5>
            <h3 class=" font-weight-bold" title="Helyszínek" id="placesCount"></h3>
          </div>
      </div>
      <div class="col-lg-6 col-xl-6">
          <div class="card-box text-center round">
            <h4 class="header-title font-weight-bold mb-3 text-uppercase" title="Helyszínek jelentkezési aránya">Helyszínek jelentkezési aránya</h4>
            <canvas id="myChart"></canvas>
          </div>
      </div>
      <div class="col-lg-6 col-xl-6">
        <div class="card-box text-center round">
          <h4 class="header-title font-weight-bold mb-3 text-uppercase" title="Helyszínek jelentkezési aránya">Helyszínek jelentkezési aránya</h4>
          <canvas id="myChart2"></canvas>
        </div>
      </div>      
      <div class="col-lg-12 col-xl-12">
        <div class="card-box text-center round">
          <h4 class="header-title font-weight-bold mb-3 text-uppercase" title="Helyszínek jelentkezési aránya">Helyszínek jelentkezési aránya osztály szinten</h4>
          <select onchange="showClassStats()" class="form-control class"></select>
          <div class="canvasdiv"></div>
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
    <script src="js/stat.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"
    integrity="sha256-TQq84xX6vkwR0Qs1qH5ADkP+MvH0W+9E7TdHJsoIQiM=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
    integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
  <script>
  $(window).on("load",function(){
     $(".loader-wrapper").fadeOut("slow");
     $("#header").css("display","flex");
  });

  </script>
</body>

</html>