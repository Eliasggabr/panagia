<?php

try {
    $pdo = new PDO("mysql:host=db;dbname=panagia;charset=utf8mb4", "adminPanagia", "EG13062009TY456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão sagrada: " . $e->getMessage());
}
