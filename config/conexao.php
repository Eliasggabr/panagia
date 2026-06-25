<?php

try {
    $pdo = new PDO("mysql:host=db;dbname=panagia;charset=utf8mb4", "adminPanagia", "EG13062009TY456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // configura o PDO para lancar excecoes em caso de erro
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    garantirSchema($pdo);
} catch (PDOException $e) { // se ocorrer um erro, exibe ele na tela
    die("Erro na conexao: " . $e->getMessage());
}

function garantirSchema(PDO $pdo): void
{
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            tipo VARCHAR(20) NOT NULL DEFAULT 'leitor',
            criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS artigos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            autor VARCHAR(100) NOT NULL DEFAULT 'admin',
            conteudo TEXT NOT NULL,
            criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS santos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            dia_festa VARCHAR(100) NOT NULL DEFAULT '',
            biografia TEXT NOT NULL,
            criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS oracoes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            categoria VARCHAR(100) NOT NULL DEFAULT '',
            texto TEXT NOT NULL,
            criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    adicionarColunaSeNaoExiste($pdo, 'usuarios', 'criado_em', "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
    adicionarColunaSeNaoExiste($pdo, 'artigos', 'criado_em', "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
    adicionarColunaSeNaoExiste($pdo, 'santos', 'dia_festa', "VARCHAR(100) NOT NULL DEFAULT ''");
    adicionarColunaSeNaoExiste($pdo, 'santos', 'criado_em', "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
    adicionarColunaSeNaoExiste($pdo, 'oracoes', 'categoria', "VARCHAR(100) NOT NULL DEFAULT ''");
    adicionarColunaSeNaoExiste($pdo, 'oracoes', 'texto', "TEXT NULL");
    adicionarColunaSeNaoExiste($pdo, 'oracoes', 'criado_em', "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
    ajustarOracoesLegadas($pdo);

    $adminSenha = password_hash('EG13062009TY456', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO usuarios (nome, email, senha, tipo)
        VALUES ('Admin - Elias', 'admin@panagia', ?, 'admin')
        ON DUPLICATE KEY UPDATE tipo = 'admin'
    ");
    $stmt->execute([$adminSenha]);

    $stmt = $pdo->prepare("SELECT id, senha FROM usuarios WHERE email = 'admin@panagia' LIMIT 1");
    $stmt->execute();
    $admin = $stmt->fetch();

    if ($admin && !password_get_info($admin['senha'])['algo']) {
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        $stmt->execute([$adminSenha, $admin['id']]);
    }
}

function adicionarColunaSeNaoExiste(PDO $pdo, string $tabela, string $coluna, string $definicao): void
{
    if (!colunaExiste($pdo, $tabela, $coluna)) {
        $pdo->exec("ALTER TABLE `$tabela` ADD `$coluna` $definicao");
    }
}

function ajustarOracoesLegadas(PDO $pdo): void
{
    if (!colunaExiste($pdo, 'oracoes', 'conteudo')) {
        return;
    }

    $pdo->exec("UPDATE oracoes SET texto = conteudo WHERE (texto IS NULL OR texto = '') AND conteudo IS NOT NULL");
    $pdo->exec("ALTER TABLE `oracoes` MODIFY `conteudo` TEXT NULL");
}

function colunaExiste(PDO $pdo, string $tabela, string $coluna): bool
{
    $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = ?
          AND COLUMN_NAME = ?
    ");
    $stmt->execute([$tabela, $coluna]);

    return (int) $stmt->fetchColumn() > 0;
}
