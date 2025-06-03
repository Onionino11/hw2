<?php
    setcookie('loggato', '');
    unset($_COOKIE['loggato']);
    header('Location: index.php');
    exit();
?>