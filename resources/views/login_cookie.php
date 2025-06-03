<?php
function verificaCredenziali($email, $password) {
    $conn = mysqli_connect("localhost","root","","malu") or die(mysqli_error($conn));

        $email = mysqli_real_escape_string($conn, $_GET['email']);
        $query = "SELECT * FROM users WHERE email = '".$email."'";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
            if ($password == $entry['password']) { 
                mysqli_free_result($res);
                mysqli_close($conn);
                setcookie('loggato', $entry['id'], time() + 3600);
                header('Location: index.php');
                exit();
            }
            return false;

            
        }
        else {
             header('Location: singup.php');
             exit();
        }
}


if ((isset($_POST['email']) && isset($_POST['password'])) || (isset($_GET['email']) && isset($_GET['password']))) {
    $email = isset($_POST['email']) ? $_POST['email'] : $_GET['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : $_GET['password'];
    verificaCredenziali($email, $password);
        
    header('Location: index.php?err=1');
    exit();
}
else {
    header('Location: index.php');
    exit();
}



?>