 <?php
    session_name("kozossegLogin");
    session_start();
    include("conn.php");
    include("isAdmin.php");
    if(isset($_POST["wData"])){
        if(isset($_SESSION["user"]["ID"])){
            if($_POST["wData"]=="newPlace"){
                if(isset($_POST["name"],$_POST["teacher"],$_POST["place"],$_POST["type"]) and $_SESSION["user"]["admin"] == 1){
                    $stmt = $conn->prepare("INSERT INTO places (name, teacher, place, type) VALUES (?, ?, ?, ?)");
                    
                    $name = trim($_POST["name"]);
                    $teacher = trim($_POST["teacher"]);
                    $place = trim($_POST["place"]);
                    $type = trim($_POST["type"]);
                    $teacherInDatabase = false;
                    $where = 0;
                    $sql = "SELECT * FROM teachers";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row=$result->fetch_assoc()){
                            if($row["name"] == $teacher){
                                $where = $row["id"];
                                $teacherInDatabase = true;
                            }
                        }
                    }
                    if($teacherInDatabase==false){
                        $stmtT = $conn->prepare("INSERT INTO teachers (name) VALUES (?)");
                        $stmtT->bind_param("s", $teacher);
                        $stmtT->execute();
                        $where = $conn->insert_id;
                    }
                    $stmt->bind_param("sisi", $name,$where, $place,$type);
            
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => $conn->insert_id,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "New place - ".$conn->insert_id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }else{
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to add new place - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }
            else if($_POST["wData"]=="newCategory"){
                if(isset($_POST["name"]) and $_SESSION["user"]["admin"] == 1){
                    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
                    $name = trim($_POST["name"]);
                    $stmt->bind_param("s", $name);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => $conn->insert_id,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "New Category - ".$conn->insert_id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    } else {
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to add new category - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }
            else if($_POST["wData"]=="newClass"){
                if(isset($_POST["name"]) and $_SESSION["user"]["admin"] == 1){
                    $stmt = $conn->prepare("INSERT INTO classes (className) VALUES (?)");
                    $name = trim($_POST["name"]);
                    $stmt->bind_param("s", $name);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => $conn->insert_id,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "New Class - ".$conn->insert_id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    } else {
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to add new class - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }
            else if($_POST["wData"]=="removeCategory"){
                if(isset($_POST["id"]) and $_SESSION["user"]["admin"] == 1){
                    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
                    $id = trim($_POST["id"]);
                    $stmt->bind_param("s", $id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "Category Removed - ".$id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    } else {
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to remove a category - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }

                    $sqlp = "SELECT id,type FROM places";
                    $resultp = $conn->query($sqlp);
                    if ($resultp->num_rows > 0) {
                        $arr = Array();
                        while($row=$resultp->fetch_assoc()){
                            array_push($arr,$row);
                        }
                        $arr = (object)$arr;
                    } else {
                    echo "empty";
                    }
                    foreach ($arr as $key => $value) {
                        if($value["type"] == $id){
                            $stmt = $conn->prepare("UPDATE places SET type='-1' WHERE id=".$value['id']."");
                            if (!$stmt->execute()) { 
                                echo(json_encode(["success" => false,"response" => $stmt->error,]));
                                
                            }
                        }
                    }
                }
            }
            else if($_POST["wData"]=="removeClass"){
                if(isset($_POST["id"]) and $_SESSION["user"]["admin"] == 1){
                    $stmt = $conn->prepare("DELETE FROM classes WHERE id=?");
                    $id = trim($_POST["id"]);
                    $stmt->bind_param("s", $id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "Class Removed - ".$id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    } else {
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to remove a class - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }       
            else if($_POST["wData"]=="editPlace"){
                if(isset($_POST["name"],$_POST["teacher"],$_POST["place"],$_POST["type"],$_POST["id"]) and $_SESSION["user"]["admin"] == 1){
                    $name = trim($_POST["name"]);
                    $teacher = trim($_POST["teacher"]);
                    $place = trim($_POST["place"]);
                    $type = trim($_POST["type"]);
                    $id = trim($_POST["id"]); 
                    
                    $teacherInDatabase = false;
                    $where = 0;
                    $sql = "SELECT * FROM teachers";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row=$result->fetch_assoc()){
                            if($row["name"] == $teacher){
                                $where = $row["id"];
                                $teacherInDatabase = true;
                            }
                        }
                    }
                    if($teacherInDatabase==false){
                        $stmtT = $conn->prepare("INSERT INTO teachers (name) VALUES (?)");
                        $stmtT->bind_param("s", $teacher);
                        $stmtT->execute();
                        $where = $conn->insert_id;
                    }

                    $stmt = $conn->prepare("UPDATE places SET name=?, teacher=?, place=?, type=? WHERE id=?");     
                    $stmt->bind_param("sssii", $name, $where, $place,$type,$id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "place edited - ".$id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }else{
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to edit a place - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }
            else if($_POST["wData"]=="editCategory"){
                if(isset($_POST["name"],$_POST["id"]) and $_SESSION["user"]["admin"] == 1){
                    $name = trim($_POST["name"]);
                    $id = trim($_POST["id"]);        
                    $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
                    $stmt->bind_param("si", $name, $id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "Category edited - ".$id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }else{
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to edit a category - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }else if($_POST["wData"]=="removeGlobalPlace"){
                if(isset($_POST["id"]) and $_SESSION["user"]["admin"] == 1){
                    $stmt = $conn->prepare("DELETE FROM places WHERE id=?");
                    $id = trim($_POST["id"]);
                    $stmt->bind_param("s", $id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $stmt = $conn->prepare("DELETE FROM userplaces WHERE placeid=?");
                        $id = trim($_POST["id"]);
                        $stmt->bind_param("i", $id);
                        if ($stmt->execute()) { 
                            //echo(json_encode(["success" => true,"response" => "",]));
                            $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                            "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                            "error when you tried to remove a global place - ".$stmt->error.PHP_EOL.
                            "-------------------------".PHP_EOL;
                            file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        } else {
                            echo(json_encode(["success" => false,"response" => $stmt->error,]));
                            $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                            "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                            "error when you tried to remove a global place - ".$stmt->error.PHP_EOL.
                            "-------------------------".PHP_EOL;
                            file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        }

                    } else {
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to remove a global place - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
    
                }
            }else if($_POST["wData"]=="setUserPlaces"){
                if(isset($_POST["placeid"],$_POST["hour"])){
                    $sql = "SELECT * FROM userplaces WHERE uid=?";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("s", intval($_SESSION["user"]['ID']));
                    $gotPlace = [];
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $ids = [];
                    while($row = $result->fetch_assoc()){
                        array_push($gotPlace, $row);
                        array_push($ids, $row["placeid"]);
                    }
                    $maxPlaces = 3;

                    if(count($gotPlace)<$maxPlaces){
                        $stmt = $conn->prepare("INSERT INTO userplaces(uid,placeid,hour) VALUES (?,?,?)");
                        $uid = intval($_SESSION["user"]['ID']);
                        $placeid = trim($_POST["placeid"]);
                        $hour = trim($_POST["hour"]);
                        if(isValueInArray($ids,$placeid)){
                            echo(json_encode(["success" => false,"response" => "Exist in table",]));
                            
                        }else{
                            $sql = "SELECT * FROM places";
                            $result = $conn->query($sql);
                            $inDataBase = false;
                            if ($result->num_rows > 0) {
                                while($row=$result->fetch_assoc()){
                                    if($row["id"] == $placeid){
                                        $inDataBase = true;
                                    }
                                }
                            }
                            
                            if($inDataBase){
                                $stmt->bind_param("iii", $uid,$placeid,$hour);
                                if ($stmt->execute()) { 
                                    echo(json_encode(["success" => true,"response" => "",]));
                                } else {
                                    echo(json_encode(["success" => false,"response" => $stmt->error,]));
                                }
                            }else{
                                echo(json_encode(["success" => false,"response" => "No valid placeId",]));
                            }
                        }

                    }else{
                        echo(json_encode(["success" => false,"response" => "too much places",]));
                    }
                }
            }
            else if($_POST["wData"]=="removePlace"){
                if(isset($_POST["id"])){
                    $stmt = $conn->prepare("DELETE FROM userplaces WHERE id=?");
                    $id = trim($_POST["id"]);
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "place removed - ".$id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    } else {
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to remove a place - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }
            else if($_POST["wData"]=="editUser"){
                if(isset($_POST["id"], $_POST["name"],$_POST["email"],$_POST["class"])){
                    $id = trim($_POST["id"]);
                    $name = trim($_POST["name"]);
                    $email = trim($_POST["email"]);
                    $class = trim($_POST["class"]);
                    $stmt = $conn->prepare("UPDATE user SET name=?, email=?, class=? WHERE id=?");
                    $stmt->bind_param("ssii", $name,$email,$class,$id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "Class edited - ".$id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }else{
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to edit a user - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }
            else if($_POST["wData"]=="removeUser"){
                if(isset($_POST["id"])){
                    $id = trim($_POST["id"]);
                    
                    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "Person removed - ".$id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    } else {
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to remove a person - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
            }
            else if($_POST["wData"]=="editClass"){
                if(isset($_POST["id"],$_POST["name"])){
                    $id = trim($_POST["id"]);
                    $name = trim($_POST["name"]);
                    $stmt = $conn->prepare("UPDATE classes SET className=? WHERE id=?");
                    $stmt->bind_param("si", $name,$id);
                    if ($stmt->execute()) { 
                        echo(json_encode(["success" => true,"response" => "",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "Class edited - ".$id.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }else{
                        echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to edit a class - ".$stmt->error.PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
                else{
                    echo(json_encode(["success" => false,"response" => "No classid available",]));
                    $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                    "error when you tried to edit a place - No classid available".PHP_EOL.
                    "-------------------------".PHP_EOL;
                    file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                }
            }        
            else if($_POST["wData"]=="editUserHour"){
                if(isset($_POST["id"],$_POST["hour"])){
                    $id = trim($_POST["id"]);
                    $hour = trim($_POST["hour"]);
                    if(is_numeric($hour)){
                        $stmt = $conn->prepare("UPDATE userPlaces SET hour=? WHERE id=?");
                        $stmt->bind_param("ii", $hour,$id);
                        if ($stmt->execute()) { 
                            echo(json_encode(["success" => true,"response" => "",]));
                            $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                            "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                            "hour edited - ".$id.PHP_EOL.
                            "-------------------------".PHP_EOL;
                            file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        }else{
                            echo(json_encode(["success" => false,"response" => $stmt->error,]));
                            $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                            "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                            "error when you tried to edit hour - ".$stmt->error.PHP_EOL.
                            "-------------------------".PHP_EOL;
                            file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        }
                    }else{
                        echo(json_encode(["success" => false,"response" => "wrong format",]));
                    }
                }
                else{
                    echo(json_encode(["success" => false,"response" => "No classid available",]));
                    $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                    "error when you tried to edit a place - No classid available".PHP_EOL.
                    "-------------------------".PHP_EOL;
                    file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                }
            }
            else if($_POST['wData']=='removeEveryBody'){
                $stmt = $conn->prepare("DELETE FROM user WHERE isAdmin = '0'");
                if ($stmt->execute()) { 
                    $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                    "All people removed by - ".$_SESSION["user"]["ID"].PHP_EOL.
                    "-------------------------".PHP_EOL;
                    file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                } else {
                    echo(json_encode(["success" => false,"response" => $stmt->error,]));
                    $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                    "error when you tried to remove people - ".$stmt->error.PHP_EOL.
                    "-------------------------".PHP_EOL;
                    file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                }
                $stmt = $conn->prepare("DELETE FROM userplaces");
                if ($stmt->execute()) {                 
                    echo(json_encode(["success" => true,"response" => "",]));
                    $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                    "All userplaces removed by - ".$_SESSION["user"]["ID"].PHP_EOL.
                    "-------------------------".PHP_EOL;
                    file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                } else {
                    echo(json_encode(["success" => false,"response" => $stmt->error,]));
                    $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                    "error when you tried to remove userplaces - ".$stmt->error.PHP_EOL.
                    "-------------------------".PHP_EOL;
                    file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                }
            }/*
            else if($_POST["wData"]=="changeClass"){
                if(isset($_POST["classid"])){
                    $class = trim($_POST["classid"]);
                    $sql = "SELECT * FROM classes";
                    $result = $conn->query($sql);
                    $inDataBase = false;
                    if ($result->num_rows > 0) {
                        while($row=$result->fetch_assoc()){
                            if($row["id"] == $classid){
                                $inDataBase = true;
                            }
                        }
                    }
                    if($inDataBase){
                        $stmt = $conn->prepare("UPDATE user SET class=? WHERE id=".intval($_SESSION["user"]['ID']));
                        $stmt->bind_param("s", $class);
                        if ($stmt->execute()) { 
                            echo(json_encode(["success" => true,"response" => "",]));
                            $_SESSION["user"]["classid"] = $class;
                            $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                            "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                            "Class changed".PHP_EOL.
                            "-------------------------".PHP_EOL;
                            file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        }else{
                            echo(json_encode(["success" => false,"response" => $stmt->error,]));
                            $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                            "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                            "error when you tried to change class - ".$stmt->error.PHP_EOL.
                            "-------------------------".PHP_EOL;
                            file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        }
                    }else{
                        echo(json_encode(["success" => false,"response" => "not valid classid",]));
                        $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                        "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                        "error when you tried to change class - not valid classid".PHP_EOL.
                        "-------------------------".PHP_EOL;
                        file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                }
                else{
                    echo(json_encode(["success" => false,"response" => "No classid available",]));
                }*/

            
        }        
        if($_POST["wData"]=="setLang"){
            if(isset($_POST["lang"])){
                if($_POST["lang"]=="hungary"||$_POST["lang"]=="english"){
                    $_SESSION["lang"] = $_POST["lang"];
                    if(isset($_SESSION["user"]["ID"])){
                        $stmt = $conn->prepare("UPDATE user SET language=? WHERE id=?");     
                        $stmt->bind_param("si", $_SESSION["lang"],$_SESSION["user"]["ID"]);
                        if ($stmt->execute()) { 
                            echo(json_encode(["success" => true,"response" => "",]));
                        }else{
                            echo(json_encode(["success" => false,"response" => $stmt->error,]));
                        }
                    }else{
                        echo(json_encode(["success" => true,"response" => "",]));
                    }

                }else{
                    echo(json_encode(["success" => false,"response" => "bad language",]));

                }
            }
            else{
                echo(json_encode(["success" => false,"response" => "bad language",]));

            }
        }
    }
    else if(isset($_SESSION["user"]["ID"])==false){
        echo(json_encode(["success" => false,"response" => "Not logined user",]));
    }
    function isValueInArray($arr,$value){
        for($i=0;$i<count($arr);$i++){
            if($arr[$i]==$value){
                return true;
            }
        }

    }
?>