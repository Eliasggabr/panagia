<?php

try {
    $pdo = new PDO("mysql:host=db;dbname=panagia;charset=utf8mb4", "adminPanagia", "EG13062009TY456"); // conecta ao banco de dados usando PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // configura o PDO para lançar exceções em caso de erro
} catch (PDOException $e) { // se ocorrer um erro, exibe ele na tela
    die("Erro na conexão: " . $e->getMessage());
}
