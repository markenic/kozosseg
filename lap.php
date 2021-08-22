<?php
  session_name("kozossegLogin");
  session_start();
  include("assets/conn.php");
  if(isset($_SESSION['user']) == false){
    header("Location: helyszin.php");
  }
  if(isset($_POST["userid"])){
    include("assets/isAdmin.php");
    if(isset($_SESSION['user']) == false or $_SESSION["user"]["admin"]==0){
      header("Location: helyszin.php");
    }

    $sql = "SELECT id,name,email,isAdmin,places,class FROM user WHERE id=".$_POST["userid"];
    $result = $conn->query($sql);
    if(isset($result->num_rows)){
        if ($result->num_rows > 0) {
            $arr = Array();
            while($row=$result->fetch_assoc()){
                $name = $row["name"];
                $class = $row["class"];
            }
        }
    }
  }else{
      $name = $_SESSION["user"]["name"];
      $class = $_SESSION["user"]["classid"];
  }
  $schoolName = "Kaposvári szakképzési centrum Nagyatádi Ady Endre Gimnáziuma, Szakgimnáziuma, Szakközépiskolája és Kollégiuma";
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.js"
            crossorigin="anonymous"></script>
    
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/paper.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/paper_print.css" type="text/css" media="print">
        <title>Jelentkezési lap</title>
    </head>
    <body onload="window.print()">
        <?php if(isset($_POST["userid"])){ ?>
            <input type="hidden" id="userid" value='<?php echo($_POST["userid"])?>'>
        <?php } ?>
        <div class="container">
            <h2 style="text-align: center;text-decoration:underline;font-weight: bold;">Jelentkezési lap</h2>
            <p style="text-align: center;text-decoration:underline;">iskolai közösségi szolgálatra</p>
            <p>Alulírott <span class="userFullName"><?php echo($name) ?></span> tanuló a <?php echo($schoolName) ?> <span class="userClass">
                <?php
                    $sql = "SELECT * FROM classes";
                   $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row=$result->fetch_assoc()){
                            if($row["id"]==$class){
                                echo($row["className"]);
                            }
                            
                        }
                    }
                
                ?>
                </span> osztályos tanulója a <span class="schoolYear"></span> tanévben az alábbi területeken
                kívánok eleget tenni a közösségi szolgálatnak:</p>
            <ul class="places"></ul>
            <p style="float:right">(tanévenként minimum egy, maximum három terület választható)</p>
            <br>
            <br>
            <br>
            <br>  
            <p style="float:right;text-align: center;width:40%;border-style: dotted none none none;">Tanuló aláírása</p>
            <br>
            <br>
            <br>
            <p style="font-weight: bold;">Szülő, gondviselő nyilatkozata:</p>
            <p>
                Alulírott …………………………………………………………………………………….. nevezett tanuló szülője/gondviselője az iskolai közösségi 
                szolgálat teljesítését a jelzett területeken támogatom és tudomásul veszem.
            </p>
            <br>
            <br>
            <p style="float:right;text-align: center;width:40%;border-style: dotted none none none;">Szülő aláírása</p>
        </div>
    </body>
    <script src="js/paper.js"></script>
</html>