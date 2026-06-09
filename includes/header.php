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
    <nav class="bg-[#030712] text-stone-100 shadow-md border-b border-amber-950/40">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/index.php" class="text-2xl font-serif font-bold tracking-wide text-amber-100 hover:text-amber-200 transition">PANAGIA</a>
            <div class="space-x-6 font-medium flex items-center">
                <a href="/artigos.php" class="hover:text-amber-200 text-sm md:text-base transition">Artigos</a>
                <a href="/santos.php" class="hover:text-amber-200 text-sm md:text-base transition">Santos</a>
                <a href="/oracoes.php" class="hover:text-amber-200 text-sm md:text-base transition">Orações</a>
                
                <?php if (isset($_SESSION['logado'])): ?> <!-- se o usuário estiver logado, mostra o nome dele e a opção de sair -->
                    <?php if ($_SESSION['tipo'] === 'admin'): ?> <!-- se o usuário for admin, mostra o link para o painel admin -->
                        <a href="/admin/index.php" class="bg-amber-700 px-4 py-2 rounded text-sm font-semibold text-white hover:bg-amber-600 shadow-sm transition">Painel Admin</a>
                    <?php endif; ?>
                    
                    <span class="text-sm md:text-base text-white font-sans font-bold tracking-wide">Olá, <?= htmlspecialchars($_SESSION['nome']) ?></span>
                    
                    <a href="/logout.php" class="text-sm md:text-base bg-red-800 px-3 py-1.5 rounded font-medium text-white hover:bg-red-700 shadow-sm transition">Sair</a>
                <?php else: ?> <!-- se n tiver logado, mostra a opção de entrar -->
                    <a href="/login.php" class="text-sm border border-amber-400 px-3 py-1 rounded text-amber-100 hover:bg-stone-900 transition">Entrar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>