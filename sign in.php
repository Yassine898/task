<?php
session_start();
include("conn.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
    $err = [];
    if (!isset($username) || empty($username)) $err['name'] = "Voulez vous entrez votre name!!!!";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $err['email'] = "VOULEZ VOUS ENTREZ UN VALIDE EMAIL";
    if (!isset($email) || empty($email)) $err['email'] = "Voulez vous entrez votre email!!!!";
    if (!isset($password) || empty($password)) $err['pass'] = "Voulez vous entrez un password!!!!";
    if (empty($err)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE username=? and email=? and password=?");
            $stmt->execute([$username, $email, $password]);
            if($stmt->rowCount()==1){
                $user=$stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['id']=$user['id_user'];
                $_SESSION['name']=$username;
                $_SESSION['email']=$email;
               header("Location: main.php"); 
            }else{
                $error="votre name or email or password incorrect";
            }
            
        } catch (PDOException $e) {
            echo "Error de enregistrement =>" . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign-In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background-color: #45a049;
        }
        .error { 
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
            padding: 10px; 
            margin: 0 auto 20px auto; 
            border-radius: 5px; 
            max-width: 400px; 
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    if(isset($error)) echo "<div class='error'>$error</div>";
    ?>
    <div class="container">
        <h2>User Sign-In</h2>
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
               <?php if (isset($err['name'])) echo " <p class='error'>".$err['name']."</p>" ?>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <?php if (isset($err['email'])) echo " <p class='error'>".$err['email']."</p>" ?>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($err['pass'])) echo " <p class='error'>".$err['pass']."</p>" ?>
            </div>
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>

</html>