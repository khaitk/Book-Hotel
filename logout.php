<?php
   session_start();
   unset($_SESSION['gmail']);
   header("Location: index.php");
?>