<?php
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
            $stmt = $conn->prepare("insert into `users`(`username`,`email`,`password`) value (?,?,?)");
            $stmt->execute([$username, $email, $password]);
            echo "<script> alert('bien enregistrer') </script>";
            header("Location: sign in.php");
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
    <title>User Registration</title>
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
        input[type="email"],
        input[type="password"] {
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
    </style>
</head>

<body>
    <div class="container">
        <h2>User Registration</h2>
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <p class="error"><?php if (isset($err['name'])) echo $err['name'] ?></p>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <p class="error"><?php if (isset($err['email'])) echo $err['email'] ?></p>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <p class="error"><?php if (isset($err['pass'])) echo $err['pass'] ?></p>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>