<?php
    if(isset($_SESSION['user'])){
        include("conn.php");
        $sql = "SELECT isAdmin FROM user WHERE id=".$_SESSION['user']['ID'];
        $result = $conn->query($sql);
        $isAdmin=0;
        if ($result->num_rows > 0) {
            while($row=$result->fetch_assoc()) $isAdmin=$row['isAdmin'];
        } else {
        echo "empty";
        }
    }

?>