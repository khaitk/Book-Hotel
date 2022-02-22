<?php
	include './session.php';

	$id = $_GET['id'];


	$sql = "DELETE FROM `review` WHERE id = $id";

	if($conn->query($sql) == TRUE){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
}

?>