<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panagia - Portal Ortodoxo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-stone-900 flex flex-col min-h-screen justify-between">
    <nav class="bg-amber-800 text-amber-50 shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/panagia/index.php" class="text-2xl font-serif font-bold tracking-wide">PANAGIA</a>
            <div class="space-x-6 font-medium flex items-center">
                <a href="/panagia/artigos.php" class="hover:text-amber-200 transition">Artigos</a>
                <a href="/panagia/santos.php" class="hover:text-amber-200 transition">Santos</a>
                <a href="/panagia/oracoes.php" class="hover:text-amber-200 transition">Orações</a>
                
                <?php if (isset($_SESSION['logado'])): ?>
                    <?php if ($_SESSION['tipo'] === 'admin'): ?>
                        <a href="/panagia/admin/index.php" class="bg-amber-950 px-3 py-1.5 rounded text-sm hover:bg-amber-900 transition">Painel Admin</a>
                    <?php endif; ?>
                    <span class="text-xs text-amber-200">Olá, <?= htmlspecialchars($_SESSION['nome']) ?></span>
                    <a href="/panagia/logout.php" class="text-xs bg-red-700 px-2 py-1 rounded hover:bg-red-800">Sair</a>
                <?php else: ?>
                    <a href="/panagia/login.php" class="text-sm border border-amber-300 px-3 py-1 rounded hover:bg-amber-700 transition">Entrar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="max-w-6xl mx-auto px-4 py-8 flex-grow w-full"></main>