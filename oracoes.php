<?php 
require_once 'config/conexao.php'; 
include 'includes/header.php'; 
?>

<main class="max-w-6xl mx-auto px-4 py-8 flex-grow w-full">
    <h1 class="text-3xl font-serif font-bold text-amber-950 mb-8 border-b pb-2">Livro de Orações</h1>
    
    <div class="space-y-8">
        <?php 
        $stmt = $pdo->query("SELECT * FROM oracoes ORDER BY categoria, titulo ASC"); 
        $oracoes = $stmt->fetchAll(); 

        if (count($oracoes) === 0):
        ?>
            <p class="text-stone-500 italic text-center">Nenhuma oração cadastrada ainda.</p>
        <?php else: ?>
            <?php foreach($oracoes as $oracao): ?> <!--para cada oração, mostra a categoria, o título e o texto da oração-->
                <div class="bg-stone-100/60 p-6 rounded-lg border border-amber-900/10 max-w-2xl mx-auto shadow-sm">
                    <div class="text-center mb-4">
                        <span class="text-xs uppercase tracking-wider font-bold text-amber-700 block mb-1">
                            [ <?= htmlspecialchars($oracao['categoria']) ?> ]
                        </span>
                        <h2 class="text-2xl font-serif font-bold text-amber-950 italic">"<?= htmlspecialchars($oracao['titulo']) ?>"</h2>
                    </div>
                    <p class="text-stone-800 font-serif leading-relaxed text-center whitespace-pre-line px-4 bg-white p-4 rounded shadow-inner border border-stone-200">
                        <?= htmlspecialchars($oracao['texto']) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>