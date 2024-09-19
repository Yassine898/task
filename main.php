<?php
include("conn.php");
session_start();
if($_SERVER['REQUEST_METHOD']=="POST"){
    extract($_POST);
    $err=[];
    if(!isset($task_name) || empty($task_name)) $err['name']="Voulez vous entrez un nom pour le task";
    if(!isset($task_description) || empty($task_description)) $err['desc']="voulez vous entrez u desciption pour le task";
    if(empty($err)){
        try{
            $stmt=$conn->prepare("insert into `tasks`(`task_name`,`description`,`id_owner`) value (?,?,?)");
            $stmt->execute([$task_name,$task_description,$_SESSION['id']]);
            $sucmsg="task bien enregistrer";
        }catch(PDOException $e){
            echo "Error de insertion de task =>".$e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }
        header, footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"], input[type="password"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .task-list {
            margin-top: 20px;
        }
        .task {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
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
.succe{
    background-color: lightgreen; 
            color: white; 
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
    <header>
        <h1>Task Management</h1>
        <button class="out">log out</button>
    </header>
        <?php if(isset($sucmsg)) echo "<div class='succe'>".$sucmsg."</div>";?>
    <div class="container">
        <h2>Add a Task</h2>
        <form  method="post">
            <div class="form-group">
                <label for="task_name">Task Name:</label>
                <input type="text" id="task_name" name="task_name" >
                <?php if(isset($err['name'])) echo "<div class='error'>".$err['name']."</div>";?>
            </div>
            <div class="form-group">
                <label for="task_description">Task Description:</label>
                <textarea id="task_description" name="task_description" rows="4" ></textarea>
                <?php if(isset($err['desc'])) echo "<div class='error'>".$err['desc']."</div>";?>
            </div>
            <button type="submit">Add Task</button>
        </form>
    </div>

    <div class="container">
        <h2>My Tasks</h2>
        <div class="task-list">
            <!-- Example tasks -->
            <?php
            $stmt=$conn->prepare("SELECT `task_name`,`description` FROM `tasks` WHERE id_owner=?");
            $stmt->execute([$_SESSION['id']]);
            foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tasks){
                echo "<div class='task'>";
                echo "<h3>".$tasks['task_name']."</h3>";
                echo "<p>".$tasks['description']."</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Task Management</p>
    </footer>
    <script>
        document.querySelector(".out").addEventListener("click",(e)=>{
            window.location.href="out.php";
        })
    </script>
</body>
</html>
