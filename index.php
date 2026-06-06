<?php 
require_once 'config/conexao.php';
include 'includes/header.php'; 
?>

<div class="w-full relative bg-cover bg-center h-[600px] flex items-center justify-center text-center shadow-lg mb-12" 
     style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1594990375715-2d008aaaa31b?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
    
    <div class="max-w-3xl px-6 relative z-10">
        <h1 class="text-4xl md:text-6xl font-serif font-bold text-amber-100 tracking-wide mb-4 drop-shadow-lg">
            Portal Ortodoxo Panagia
        </h1>
        <div class="w-32 h-0.5 bg-amber-500 mx-auto mb-6"></div>
        <p class="text-lg md:text-2xl text-stone-200 font-serif font-light leading-relaxed drop-shadow-md">
            Bem-vindo à nossa comunidade digital ortodoxa dedicada às Sagradas Tradições, à vida dos Santos e às Orações.
        </p>
    </div>
</div>

<main class="max-w-6xl mx-auto px-4 pb-12 flex-grow w-full">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded shadow border border-stone-200">
            <h2 class="text-xl font-serif font-bold text-amber-900 border-b border-stone-100 pb-2 mb-4">Últimos Artigos</h2>
            <?php foreach($pdo->query("SELECT * FROM artigos ORDER BY id DESC LIMIT 3") as $a): ?>
                <div class="mb-3">
                    <a href="artigos.php" class="font-bold text-stone-800 hover:text-amber-800 hover:underline block transition"><?= htmlspecialchars($a['titulo']) ?></a>
                    <span class="text-xs text-stone-400">Por: <?= htmlspecialchars($a['autor']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="bg-white p-6 rounded shadow border border-stone-200">
            <h2 class="text-xl font-serif font-bold text-amber-900 border-b border-stone-100 pb-2 mb-4">Santos Celebrados</h2>
            <?php foreach($pdo->query("SELECT * FROM santos ORDER BY id DESC LIMIT 3") as $s): ?>
                <div class="mb-3">
                    <a href="santos.php" class="font-bold text-stone-800 hover:text-amber-800 hover:underline block transition"><?= htmlspecialchars($s['nome']) ?></a>
                    <span class="bg-amber-100 text-amber-900 text-xs px-2 py-0.5 rounded font-medium inline-block mt-1">Festa: <?= htmlspecialchars($s['dia_festa']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="bg-white p-6 rounded shadow border border-stone-200">
            <h2 class="text-xl font-serif font-bold text-amber-900 border-b border-stone-100 pb-2 mb-4">Espaço de orações</h2>
            <?php foreach($pdo->query("SELECT * FROM oracoes ORDER BY id DESC LIMIT 3") as $o): ?>
                <div class="mb-3">
                    <a href="oracoes.php" class="font-bold text-stone-800 hover:text-amber-800 hover:underline block italic transition">"<?= htmlspecialchars($o['titulo']) ?>"</a>
                    <span class="text-xs text-stone-500">Seção: <?= htmlspecialchars($o['categoria']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</main>

<?php include 'includes/footer.php'; ?>