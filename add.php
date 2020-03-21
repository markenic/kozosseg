<!DOCTYPE html>
<?php 
  session_start();
  //include("assets/conn.php");
  
 ?>
<html lang="hu" dir="ltr">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/5ad8cb3834.js" crossorigin="anonymous"></script>

        <title>Közösségi szolgálat - Admin felület</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">ADY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Admin <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="helyszin.php">Helyszínek</a>
            </li>
            </ul>
        </div>
        </nav>
        <div class="interface container">
            <div class="row d-flex justify-content-center text-center">
                <h3 style="margin-top:20px">Jelentkezési helyek kezelése</h3>
                <ul class="list"></ul>
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
