<?php require_once '../includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Painel Admin - Panagia</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-stone-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow border">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-serif text-amber-950 font-bold">Painel Panagia</h1>
            <div class="space-x-2">
                <a href="../index.php" class="bg-stone-500 text-white px-4 py-2 rounded hover:bg-stone-600">Ver Site Público</a>
                <a href="../logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Sair</a>
            </div>
        </div>
        <p class="mb-6 text-stone-600">Bem-vindo ao controle de Tradições, <b><?= htmlspecialchars($_SESSION['nome']) ?></b>.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="artigos.php" class="p-6 bg-amber-50 rounded-lg border border-amber-200 hover:bg-amber-100 block">
                <h3 class="text-xl font-bold text-amber-900 font-serif mb-2">📌 Artigos</h3>
                <p class="text-stone-600 text-sm">Publicar textos teológicos e homilias.</p>
            </a>
            <a href="santos.php" class="p-6 bg-amber-50 rounded-lg border border-amber-200 hover:bg-amber-100 block">
                <h3 class="text-xl font-bold text-amber-900 font-serif mb-2">⛪ Santos</h3>
                <p class="text-stone-600 text-sm">Alimentar o Sinaxário e festas.</p>
            </a>
            <a href="oracoes.php" class="p-6 bg-amber-50 rounded-lg border border-amber-200 hover:bg-amber-100 block">
                <h3 class="text-xl font-bold text-amber-900 font-serif mb-2">📜 Orações</h3>
                <p class="text-stone-600 text-sm">Gerenciar o livro de preces prontas.</p>
            </a>
        </div>
    </div>
</body>
</html>