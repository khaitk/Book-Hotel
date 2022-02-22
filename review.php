<?php
    include 'session.php';
     //echo $_SESSION['gmail'];
     
    if(!isset($_SESSION['gmail'])){
        header("location: login.php");
    }else{
        $sqluser = "select * from users where gmail = '$gmail'";
        $queryuser = $conn->query($sqluser);
        $rowuser = mysqli_fetch_array($queryuser, MYSQLI_ASSOC);

        $iduser = $rowuser['id'];
        $idRoom = $_GET['id'];
        
        if(isset($_POST['submit'])){
            $rating = $_POST['rating'];
            $description = $_POST['description'];

            //echo $idRoom.$iduser;
       
            $sql = "INSERT INTO `review`(`idRoom`, `idUser`, `description`, `rating`) 
            VALUES ('$idRoom','$iduser','$description','$rating')";

            if($conn->query($sql)){
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
     }
     
?>