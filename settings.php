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
  <title><?php echo($lang["title"])?></title>
</head>

<body>
  <?php require_once("assets/header.php") ?>
  <div class="container" style="margin-top:7%">
  <div class="row">
      <div class="col-lg-5 col-xl-5">
          <div class="card-box text-center round">
            <i class="far fa-user fa-3x"></i>

              <h4 class="mb-0"><?php echo($_SESSION["user"]["name"])?></h4>
              <p class="text-muted"><?php echo($_SESSION["user"]["userName"])?></p>
              <div class="text-left mt-3">
                  <p class="text-muted mb-2 font-13"><strong>Email address: </strong> <span class="ml-2"><?php echo($_SESSION["user"]["email"])?></span></p>
                  <p class="text-muted mb-1 font-13"><strong>Language :</strong> <span class="ml-2"><?php echo($lang[$_SESSION["lang"]]) ?></span></p>
              </div>
          </div>

          <div class="card-box round">
              <h4 class="header-title">Places</h4>
              <div class="userPlaces"></div>

          </div>

      </div>

      <div class="col-lg-7 col-xl-7">
          <div class="card-box round">

              <div class="tab-content">
                  

                  <div class="tab-pane show active" id="settings">

                          <h5 class="mb-3 bg-light p-2 round"><i class="fas fa-user-circle"></i> Personal</h5>
                          
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="email">Email address</label>
                                      <input type="email" class="form-control" id="email" placeholder="Email address" value=<?php echo($_SESSION["user"]["email"])?>>

                                  </div>
                              </div>      
                          </div>

                          <div class="row">
                              <div class="col-6">
                                  <div class="form-group">
                                      <label for="pass1">Current password</label>
                                      <input type="password" class="form-control" id="pass1" placeholder="Current password">
                                  </div>
                              </div>
                              <div class="col-6">
                                  <div class="form-group">
                                      <label for="pass2">New Password</label>
                                      <input type="password" class="form-control" id="pass2" placeholder="New password">
                                  </div>
                              </div>
                          </div>
                          <button class="btn btn-success save" onclick="saveDatas()" style="width:100%">Save</button>


                  </div>
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
    <script src="js/settings.js"></script>
  <script>
  $(window).on("load",function(){
     $(".loader-wrapper").fadeOut("slow");
     $("#header").css("display","flex");
  });

  </script>
</body>

</html>