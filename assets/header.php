<?php
  if(isset($_SESSION["lang"])&&$_SESSION["lang"]=="english"){
    include("assets/hu.php");
  }else{
    include("assets/en.php");
    $_SESSION["lang"] = "hungary";
  }
?>

<header id="header" class="fixed-top header-transparent">
    <div class="container d-flex align-items-center">

      <h4 class="logo mr-auto"><a href="index.php">Ady</a></h4>
      <nav class="main-nav d-none d-lg-block">
        <ul>
          <?php if(isset($_SESSION["user"]["ID"]) and $_SESSION["user"]["admin"]==1){ ?>

            <?php if(isset($_SESSION["user"])){ ?>
              <li class="drop-down"><a href="admin.php">Admin</a>
              <ul>
                <li><a href="admin.php#places"><?php echo($lang["places"])?></a></li>
                <li><a href="admin.php#categories"><?php echo($lang["categories"])?></a></li>
                <li><a href="admin.php#users"><?php echo($lang["users"])?></a></li>
                <li><a href="admin.php#classes"><?php echo($lang["classes"])?></a></li>

              </ul>
            </li>
            <?php }else{?>
              <li class="nav-item mx-2">
              <a class="nav-link" data-toggle="modal" data-target="#regModal" href="#"><?php echo($lang["reg"])?></a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" data-toggle="modal" data-target="#loginModal" href="#"><?php echo($lang["login"])?></a>
            </li>
            <?php }?>
            <li class="nav-item mx-2">
              <a class="nav-link" href="stats.php"><?php echo($lang["stat"])?></a>
            </li>
          <?php }?>
          <li class="nav-item mx-2">
            <a class="nav-link activeNav text-main" href="helyszin.php"><?php echo($lang["places"])?></a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="http://ady-nagyatad.hu"><?php echo($lang["home"])?></a>
          </li>
          <?php if(isset($_SESSION["user"]["name"])){ ?>
          <li class="drop-down"><a href=""><?php echo($_SESSION["user"]["name"]) ?></a>
            <ul>
              <li><a href="settings.php"><?php echo($lang["settings"])?></a></li>
              <li><a href="logout.php"><?php echo($lang["logout"])?></a></li>
            </ul>
          </li>
          <?php }else{?>
            <li class="nav-item mx-2">
            <a class="nav-link" data-toggle="modal" data-target="#regModal" href="#"><?php echo($lang["reg"])?></a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" data-toggle="modal" data-target="#loginModal" href="#"><?php echo($lang["login"])?></a>
          </li>
            <?php }?>
        </ul>
      </nav>

    </div>
  </header>