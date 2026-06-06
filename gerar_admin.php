<?php
// salvar como: gerar_admin.php
require_once 'config/conexao.php';

// O próprio PHP do seu servidor vai gerar o hash perfeito
$senha_limpa = 'EG13062009TY456'; 
$novo_hash = password_hash($senha_limpa, PASSWORD_DEFAULT);

try {
    // Remove o registro problemático atual para evitar duplicidade
    $pdo->exec("DELETE FROM usuarios WHERE email = 'admin@panagia.com'");
    
    // Insere o administrador com o hash perfeito gerado pelo próprio PHP
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('Admin Elias', 'admin@panagia.com', ?, 'admin')");
    $stmt->execute([$novo_hash]);
    
    echo "<h2>Admin criado com sucesso pelo PHP!</h2>";
    echo "<b>E-mail:</b> admin@panagia.com<br>";
    echo "<b>Senha:</b> EG13062009TY456<br>";
} catch (\PDOException $e) {
    echo "Erro ao criar: " . $e->getMessage();
}