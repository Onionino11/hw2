<?php
  
    if (
        isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) &&
        isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['birthday']) &&
        isset($_POST['city']) && isset($_POST['province']) && isset($_POST['phone'])
    ) {
        $conn = mysqli_connect("localhost","root","","malu") or die(mysqli_error($conn));
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $province = mysqli_real_escape_string($conn, $_POST['province']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $accept_marketing = isset($_POST['accept_marketing']) ? intval($_POST['accept_marketing']) : 0;


        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            header('Location: singup.php?err=1');
            exit();
        } elseif ($password !== $confirm_password) {
            header('Location: singup.php?err=2');
            exit();
        } else {
            $query = "INSERT INTO users (email, password, first_name, last_name, birthday, city, province, phone, accept_marketing) VALUES ('$email', '$password', '$first_name', '$last_name', '$birthday', '$city', '$province', '$phone', $accept_marketing)";
            if (mysqli_query($conn, $query)) {
                header('Location: login_cookie.php?email=' . urlencode($email) . '&password=' . urlencode($password));
                exit();
            } else {
                header('Location: singup.php?err=3');
                exit();
            }
        }
        mysqli_close($conn);
    } else {
        header('Location: singup.php?err=4');
        exit();
    }
?>