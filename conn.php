<?php
try {
    $conn = new PDO("mysql:host=localhost;port=3307;dbname=gestion_task", "root", "123456");
} catch (PDOException $e) {
    echo "Error de connexion =>" . $e->getMessage();
}
?>