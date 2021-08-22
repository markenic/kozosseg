<?php
  session_name("kozossegLogin");
  session_start();
  include("assets/isAdmin.php");
  if(isset($_SESSION['user']) == false or $_SESSION["user"]["admin"]==0){
    header("Location: helyszin.php");
  }
  if(isset($_SESSION["lang"])&&$_SESSION["lang"]=="english"){
    include("assets/en.php");
  }else{
    include("assets/hu.php");
    $_SESSION["lang"] = "hungary";
  }
?>
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="vendor/alertify/css/alertify.css">

    <link rel="stylesheet" href="vendor/alertify/css/themes/default.css">
    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,600,700" rel="stylesheet">

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="vendor/font-awesome/js/all.min.js"></script>
    <link href="vendor/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="vendor/venobox/venobox.css" rel="stylesheet">
    <link href="vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="vendor/aos/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/loader.css">
    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>

    <title><?php echo($lang["title"])?></title>
</head>

<body class="admin">
    <?php require_once("assets/header.php") ?>
    <div class="intro" id="places" style="margin-top:10%">
        <div class="col-12 col-md-8 offset-md-2 text-center section-header" data-aos="zoom-out" style="margin-top:20px;">
            <ion-icon style="font-size:62px;" class="text-main" name="compass"></ion-icon>
            <h3><?php echo($lang["places"]) ?></h3>
            <p><?php echo($lang["editPlace"])?></p>
        </div>
        <div class="col-12 col-md-8 offset-md-2 text-center" data-aos="zoom-in" style="margin-top:20px">
            <div class="container bg-white shadow-sm">
                <div class="section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shadow-sm rounded mt-3 bg-white">
                                <div class="card-body">
                                    <h5 class="card-title header-title font-weight-bold text-uppercase text-muted"><?php echo($lang["searchByPlace"]) ?></h5>
                                    <input type="text" id="searchPlace" onkeyup="searchPlaceByName()" class="form-control"
                                        placeholder=<?php echo($lang["name"])?>>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="shadow-sm rounded mt-3 bg-white">
                                <div class="card-body">
                                    <h5 class="card-title header-title font-weight-bold text-uppercase text-muted"><?php echo($lang["newPlace"])?></h5>
                                    <button class="btn btn-info w-50" onclick="newPlace()"><?php echo($lang["ok"]) ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="section">
                                <div class="cards" style="width:100%;margin-bottom:20px;margin-top:20px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div id="categories" class="intro">
        <div class="col-12 col-md-8 offset-md-2 text-center section-header mt-6" data-aos="zoom-out" style="margin-top:20px;">
        <ion-icon style="font-size:62px;" class="text-main" name="list-circle-outline"></ion-icon>

            <h3><?php echo($lang["categories"])?></h3>
            <p><?php echo($lang["editCat"])?></p>
        </div>
        <div class="container bg-white shadow-sm text-center" data-aos="zoom-out">
            <div class="section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="shadow-sm rounded bg-white mt-3">
                            <div class="card-body">
                                <h5 class="card-title header-title font-weight-bold text-uppercase text-muted"><?php echo($lang["searchByCat"])?></h5>
                                <input type="text" id="searchcat" onkeyup="searchCategoryByName()" class="form-control"
                                    placeholder="Név">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shadow-sm rounded bg-white mt-3">
                            <div class="card-body">
                                <h5 class="card-title header-title font-weight-bold text-uppercase text-muted"><?php echo($lang["newCat"])?></h5>
                                <button class="btn btn-info w-50" onclick="newCategory()"><?php echo($lang["ok"]) ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="section">
                            <div class="categories" style="width:100%;margin-bottom:20px;margin-top:20px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro" style="margin-bottom:50px;" id="users">
        <div class="col-12 col-md-8 offset-md-2 text-center section-header" data-aos="zoom-out" style="margin-top:20px;">
            <ion-icon style="font-size:62px;" class="text-main" name="people-circle-outline"></ion-icon>
            <h3><?php echo($lang["subscribers"]) ?></h3>
            <p><?php echo($lang["editSubs"]) ?></p>
        </div>
        <div class="container bg-white shadow-sm" data-aos="zoom-out">
            <div class="section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="shadow-sm rounded bg-white mt-3">
                            <div class="card-body">
                                <h5 class="card-title header-title font-weight-bold text-uppercase text-muted"><?php echo($lang["searchByName"]) ?></h5>
                                <input type="text" id="searchname" onkeyup="searchPersonByName()" class="form-control" name="searchName" placeholder=<?php echo($lang["name"]) ?>>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shadow-sm rounded bg-white mt-3">
                            <div class="card-body">
                                <h5 class="card-title header-title font-weight-bold text-uppercase text-muted"><?php echo($lang["searchByClass"]) ?></h5>
                                <select id="classSelectToSort" onchange="classSelectToSort()" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                <div class="section">
                        <button onclick='removeEverybody()' class="btn btn-info mt-3"><i class="fas fa-door-closed"></i> <?php echo($lang["endYear"])?></button>
                            <div class="userCards" style="width:100%;margin-bottom:20px;margin-top:20px"></div>
                        </div>
                    </div>
            </div>
                </div>
            </div>

    </div>
    <div class="intro" style="margin-bottom:50px;" id="classes">
        <div class="col-12 col-md-8 offset-md-2 text-center section-header" data-aos="zoom-out" style="margin-top:20px;">
            <ion-icon style="font-size:62px;" class="text-main" name="people-circle-outline"></ion-icon>
            <h3><?php echo($lang["classes"])?></h3>
            <p><?php echo($lang["editClass"])?></p>
        </div>
        <div class="container bg-white shadow-sm">
            <div class="section">
                <div class="row">
                    <div class="col-md-12">
                        <div class="shadow-sm rounded mt-3 bg-white">
                            <div class="card-body">
                                <h5 class="card-title header-title font-weight-bold text-uppercase text-muted"><?php echo($lang["newClass"])?></h5>
                                <button class="btn btn-info" onclick="newClass()"><?php echo($lang["ok"]) ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="section">
                            <div class="classesCard" style="width:100%;margin-bottom:20px;margin-top:20px"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.js" crossorigin="anonymous"></script>
    <script src="js/admin.js" charset="utf-8"></script>
</body>

</html>