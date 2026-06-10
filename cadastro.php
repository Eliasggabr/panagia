<?php
require_once 'config/conexao.php';
$msg = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); 
    $senha = $_POST['senha'];

    if (!empty($nome) && !empty($email) && !empty($senha)) { 
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'leitor')"); 
            $stmt->execute([$nome, $email, $senha_hash]); 
            $msg = "Conta criada com sucesso! Faça seu login.";
            $sucesso = true;
        } catch (\PDOException $e) { 
            $msg = "Este e-mail já está cadastrado.";
        }
    } else { 
        $msg = "Preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Criar Conta - Panagia</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-stone-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow border w-full max-w-md">
        <h2 class="text-2xl font-serif font-bold text-amber-800 text-center mb-6">Criar Conta no Panagia</h2>
        
        <?php if($msg): ?> 
            <div class="<?= $sucesso ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?> p-2 rounded mb-4 text-sm text-center"><?= $msg ?></div> 
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-stone-700">Nome Completo</label>
                <input type="text" name="nome" required class="w-full p-2 border rounded focus:ring-2 focus:ring-amber-600 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-stone-700">E-mail</label>
                <input type="email" name="email" required class="w-full p-2 border rounded focus:ring-2 focus:ring-amber-600 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-stone-700">Senha</label>
                <input type="password" name="senha" required class="w-full p-2 border rounded focus:ring-2 focus:ring-amber-600 outline-none">
            </div>
            <button type="submit" class="w-full bg-amber-800 text-white p-2 rounded font-bold hover:bg-amber-900 transition">Cadastrar</button>
            <div class="text-center text-sm text-stone-500 mt-4">
                Já tem conta? <a href="login.php" class="text-amber-800 hover:underline">Entre aqui</a>
            </div>
        </form>
    </div>
</body>
</html>