<?php
  session_start();
  if(isset($_SESSION['user']) == false or $_SESSION['user']['isAdmin']!=1){
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/5ad8cb3834.js" crossorigin="anonymous"></script>

    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">

    <title>Közösségi szolgálat - felület</title>
</head>

<body>
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown-7"
                aria-controls="navbarNavDropdown-7" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown-7">
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION["user"]) and $_SESSION['user']['isAdmin']==1){ ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="admin.php">Admin</a>
                        </li>
                    <?php }?>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="helyszin.php">Helyszínek</a>
                    </li>
                </ul>
            </div>

            <ul class="nav navbar-nav navbar-right">
        <?php if(isset($_SESSION["user"])){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user text-info"></i> <?php echo($_SESSION["user"]["name"]) ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"><i class="fas fa-users-cog text-info"></i> Beállítások</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-map-marked-alt text-info"></i> Választott
                            helyszínek</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt text-info"></i>
                            Kijelentkezés</a>
                    </div>
        </li>
        <?php } else{ ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
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
    </nav>
    <div class="intro bg-white">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-12 col-md-8 offset-md-2 text-center" style="margin-top:20px">
                        <i class="fas fa-users-cog fa-4x text-info"></i>
                        <h3 class="text-info">Beállítások</h3>
                        <p>Itt módosíthatod fiókod beállításaid</p>
                        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                            <div class="card card-newpass my-5 border-0">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Új jelszó</h5>
                                    <?php if(isset($response)){?>
                                    <div class="alert alert-<?php echo $response[0]?>" role="alert">
                                        <?php echo $response[1]?>
                                    </div>
                                    <?php } ?>
                                    <form class="form-newpass" action="assets/changeDatas.php" method="post">
                                        <div class="form-label-group">
                                            <input type="password" id="oldPass" class="form-control" name="oldPass"
                                                placeholder="Régi jelszó" minLength="8" required>
                                            <label for="oldPass">Régi jelszó</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="password" id="pass" class="form-control" name="password"
                                                placeholder="Új jelszó" minLength="8" required>
                                            <label for="pass">Új jelszó</label>
                                        </div>
                                        <input class="btn btn-lg btn-info btn-block text-uppercase" type="submit">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                            <div class="card card-newpass my-5 border-0">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Email cím változtatás</h5>
                                    <?php if(isset($response)){?>
                                    <div class="alert alert-<?php echo $response[0]?>" role="alert">
                                        <?php echo $response[1]?>
                                    </div>
                                    <?php } ?>
                                    <form class="form-newpass" action="/web/settings.php" method="post">
                                        <div class="form-label-group">
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Új email" required>
                                            <label for="email">Új email</label>
                                        </div>
                                        <input class="btn btn-lg btn-info btn-block text-uppercase" type="submit">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js" charset="utf-8"></script>
</body>

</html>