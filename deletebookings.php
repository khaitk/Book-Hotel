<?php
    include 'session.php';

    $sqluser = "select * from users where gmail = '$gmail'";
    $queryuser = $conn->query($sqluser);
    $rowuser = mysqli_fetch_array($queryuser, MYSQLI_ASSOC);

    $id = $rowuser['id'];
    $idbooking = $_GET['idbookings'];
    $idbill = $_GET['idbills'];
    $idrooms = $_GET['idrooms'];



    $sqlbills = "delete from bills where id = $idbill ";

    if ($conn->query($sqlbills) === TRUE)
    {
        $sqlbooking = "delete from bookings where id = $idbooking and idUser = $id";

        if($conn->query($sqlbooking) === TRUE)
        {
            $sqlroom = "UPDATE `rooms` SET `status`='NO' WHERE id = '$idrooms'";

            if($conn->query($sqlroom) === TRUE)
            {
                header('Location: bills.php');
            }
            else
            {
                echo "Error: " . $sqlroom . "<br>" . $conn->error;
            }
        }
        else 
        {
            echo "Error: " . $sqlbooking . "<br>" . $conn->error;
        }
    } 
    else
    {
        echo "Error: " . $sqlbills . "<br>" . $conn->error;
    }


?>