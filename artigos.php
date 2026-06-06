<?php 
require_once 'config/conexao.php'; 
include 'includes/header.php'; 
?>

<main class="max-w-6xl mx-auto px-4 py-8 flex-grow w-full">
    <h1 class="text-3xl font-serif font-bold text-amber-950 mb-8 border-b pb-2">Artigos e Ensinamentos</h1>
    
    <div class="space-y-6">
        <?php 
        $stmt = $pdo->query("SELECT * FROM artigos ORDER BY criado_em DESC");
        $artigos = $stmt->fetchAll();

        if (count($artigos) === 0): 
        ?>
            <p class="text-stone-500 italic">Nenhum artigo publicado ainda.</p>
        <?php else: ?>
            <?php foreach($artigos as $art): ?>
                <article class="bg-white p-6 rounded shadow border border-stone-200">
                    <h2 class="text-2xl font-serif font-bold text-amber-900 mb-1"><?= htmlspecialchars($art['titulo']) ?></h2>
                    <div class="text-xs text-stone-400 mb-4">
                        Publicado em: <?= date('d/m/Y', strtotime($art['criado_em'])) ?> | Autor: <?= htmlspecialchars($art['autor']) ?>
                    </div>
                    <p class="text-stone-700 whitespace-pre-line leading-relaxed"><?= htmlspecialchars($art['conteudo']) ?></p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>