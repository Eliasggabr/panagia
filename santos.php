<?php 
require_once 'config/conexao.php'; 
include 'includes/header.php'; 
?>

<main class="max-w-6xl mx-auto px-4 py-8 flex-grow w-full">
    <h1 class="text-3xl font-serif font-bold text-amber-950 mb-8 border-b pb-2">Sinaxário - Santos Padres</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php 
        $stmt = $pdo->query("SELECT * FROM santos ORDER BY nome ASC");
        $santos = $stmt->fetchAll();

        if (count($santos) === 0): 
        ?>
            <p class="text-stone-500 italic col-span-2">Nenhum santo cadastrado ainda.</p>
        <?php else: ?>
            <?php foreach($santos as $santo): ?>
                <div class="bg-white p-6 rounded shadow border border-stone-200 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-2xl font-serif font-bold text-amber-900"><?= htmlspecialchars($santo['nome']) ?></h2>
                            <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded font-bold whitespace-nowrap ml-2">
                                Festa: <?= htmlspecialchars($santo['dia_festa']) ?>
                            </span>
                        </div>
                        <p class="text-stone-700 text-sm whitespace-pre-line mt-4 leading-relaxed"><?= htmlspecialchars($santo['biografia']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>