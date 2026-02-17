<?php
require "../config/db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];    
    $cpass = $_POST['confirm_password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email address";
}
    if ($pass !== $cpass) { 
        $error = "Passwords do not match";
    } else {
        
           $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        
        
        if ($check->num_rows > 0) {
            $error = "User already exists";
            } else {

                $hashed = password_hash($pass, PASSWORD_DEFAULT);

                $stmt = $conn->prepare(
                "INSERT INTO users (first_name, last_name, email, password)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssss", $fname, $lname, $email, $hashed);

            if ($stmt->execute()) {
                header("Location: ../index.php");
                exit;
            } 
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/master.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
    <form class="register-form" method="POST" auto-complete="off">



        <p class="title">Register </p>
        <p class="message">Signup now and get full access to our app. </p>
        <div class="flex">
            <label>
                <input  name="first_name" required="" placeholder="" type="text" class="input" >
                <span>Firstname</span>
            </label>

            <label>
                <input name="last_name" required="" placeholder="" type="text" class="input">
                <span>Lastname</span>
            </label>
        </div>

        <label>
            <input name="email" required="" placeholder="" type="email" class="input" autocomplete="new-email">
            <span>Email</span>
        </label>

        <label>
            <input name="password" required="" placeholder="" type="password" class="input" autocomplete="new-password">
            <span>Password</span>
        </label>
        <label>
            <input name="confirm_password" required="" placeholder="" type="password" class="input">
            <span>Confirm password</span>
        </label>
        <button class="submit"  name="submit">Submit</button>
        <p class="signin">Already have an acount ? <a href="login.php">Signin</a> </p>
    </form>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>


        <script>

</script>


    <!-- Custom JS -->

    <script src="../assets/js/script.js"></script>
</body>

</html>