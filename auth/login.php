<?php
session_start();


// header("Content-Type: application/json");

require "../config/db.php";

$redirect = $_GET['redirect'] ?? '../index.php';

$error = "";

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
     $email = trim($_POST['email'] ?? '');
     $pass  = $_POST['password'] ?? '';
 
     if ($email === '' || $pass === '') {
         $error = "All fields are required";
     } else {
 
          $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
 
         if (!$stmt) {
             $error = "Server error";
         } else{
         $stmt->bind_param("s", $email);
         
         if ( !$stmt->execute()){
              $error = "Server error";
             } else {
                 $result = $stmt->get_result();
     
                 if ($result->num_rows === 1) {
                     $user = $result->fetch_assoc();
                     
                     if (password_verify($pass, $user['password'])) {
                 $_SESSION['user_id'] = $user['id'];
                    header("Location:  $redirect");
                    exit;
               } else {
                 $error = "Invalid password";
             }   
         } else {
             $error = "User not found";
             }
         }
         }
     }
 }


// // Only POST allowed
// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     echo json_encode([
//         "status" => false,
//         "message" => "Only POST method allowed"
//     ]);
//     exit;
// }



// // get json input
// $data = json_decode(file_get_contents("php://input"), true);

// $email = trim($data['email'] ?? '');
// $password = $data['password'] ?? '';

// if ($email === '' || $password === '') {
//     echo json_encode([
//         "status" => false,
//         "message" => "Email and password required"
//     ]);
//     exit;
// }

// $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
// $stmt->bind_param("s", $email);
// $stmt->execute();

// $result = $stmt->get_result();

// if ($result->num_rows === 1) {
//     $user = $result->fetch_assoc();

//     if (password_verify($password, $user['password'])) {
//         echo json_encode([
//             "status" => true,
//             "message" => "Login successful",
//             "user_id" => $user['id']
//         ]);
//     } else {
//         echo json_encode([
//             "status" => false,
//             "message" => "Invalid password"
//         ]);
//     }
// } else {
//     echo json_encode([
//         "status" => false,
//         "message" => "User not found"
//     ]);
// }
        
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
    <form class="login-form" method="POST" auto-complete="off">

    <?php if (!empty($error)) : ?>
    <div class="alert alert-danger text-center">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>



        <p class="title" autocomplete="new-email">Login </p>

        <label >
            <input name="email" required placeholder="Email" type="email" class="input"  >

        </label>

        <label >
            <input name="password" required placeholder="Password" type="password" class="input" >

        </label>

        <button class="submit" name="login">Login</button>
        <p class="signin">Dont't have an acount ? <a href="register.php">Sign-up</a> </p>
    </form>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous">
    </script>


    <!-- Custom JS -->

    <script src="../assets/js/script.js"></script>

</body>

</html>