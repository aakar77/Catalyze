<?php

    session_start();
    if(isset($_SESSION['cusname']))
    {
        session_destroy();
        header('Location: ../index.php');
    }
    
?>