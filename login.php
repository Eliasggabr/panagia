<?php
session_start();
require_once 'config/conexao.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['logado'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['tipo'] = $user['tipo'];

        if ($user['tipo'] === 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $erro = "E-mail ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Login - Panagia</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-stone-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow border w-full max-w-md">
        <h2 class="text-2xl font-serif font-bold text-amber-800 text-center mb-6">Acesso ao Portal</h2>
        <?php if($erro): ?> <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm text-center"><?= $erro ?></div> <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-stone-700">E-mail</label>
                <input type="email" name="email" required class="w-full p-2 border rounded focus:ring-2 focus:ring-amber-600 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-stone-700">Senha</label>
                <input type="password" name="senha" required class="w-full p-2 border rounded focus:ring-2 focus:ring-amber-600 outline-none">
            </div>
            <button type="submit" class="w-full bg-amber-800 text-white p-2 rounded font-bold hover:bg-amber-900">Entrar</button>
            <div class="flex justify-between items-center text-sm text-stone-500 mt-4">
                <a href="cadastro.php" class="text-amber-800 hover:underline">Criar uma conta</a>
                <a href="index.php" class="hover:underline">Voltar ao site</a>
            </div>
        </form>
    </div>
</body>
</html>