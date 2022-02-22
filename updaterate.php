<?php
	include './session.php';

	$id = $_GET['id'];

	$description = $_POST['description'];
	$rating = $_POST['rating'];

	$sql = "UPDATE `review` SET `description`='$description',`rating`='$rating' WHERE id = $id";

	if($conn->query($sql) == TRUE){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        echo "Error: " . $sqlbills . "<br>" . $conn->error;
}

?>