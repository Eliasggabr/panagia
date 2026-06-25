<?php
session_start();
require_once 'config/conexao.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(); // pega o resultado da consulta e guarda na variavel $user

    if ($user && senhaConfere($pdo, $user, $senha)) { // se o usuario existir e a senha for correta, cria a sessao e redireciona
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

function senhaConfere(PDO $pdo, array $user, string $senha): bool
{
    if (password_verify($senha, $user['senha'])) {
        return true;
    }

    if (password_get_info($user['senha'])['algo']) {
        return false;
    }

    if (!hash_equals($user['senha'], $senha)) {
        return false;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
    $stmt->execute([$senhaHash, $user['id']]);

    return true;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Login - Panagia</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-stone-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow border w-full max-w-md">
        <h2 class="text-2xl font-serif font-bold text-amber-800 text-center mb-6">Acesso ao Portal</h2>
        <?php if($erro): ?> <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm text-center"><?= htmlspecialchars($erro) ?></div> <?php endif; ?> <!-- se tiver uma mensagem de erro, mostra a mensagem -->
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-stone-700">E-mail</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-amber-600 outline-none">
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