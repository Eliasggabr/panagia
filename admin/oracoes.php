<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: ../login.php'); exit;
}
require_once '../config/conexao.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Livro de Orações - Panagia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 text-stone-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-lg shadow-xl border border-amber-900/15 max-w-4xl w-full">
        
        <div class="flex flex-col sm:flex-row justify-between items-center border-b border-stone-200 pb-6 mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-serif font-bold tracking-wide text-amber-950">Livro de Orações</h1>
                <p class="text-sm text-stone-500 font-serif italic mt-1">Organizar e prover as santas preces por categorias.</p>
            </div>
            <div class="flex items-center space-x-3 w-full sm:w-auto justify-end">
                <a href="index.php" class="border border-amber-900/30 text-amber-950 px-4 py-2 rounded font-medium text-sm hover:bg-stone-50 transition text-center">
                    Voltar ao Painel
                </a>
                <?php if ($action === 'list'): ?>
                    <a href="oracoes.php?action=create" class="bg-[#030712] text-stone-100 px-4 py-2 rounded font-medium text-sm hover:bg-slate-900 transition shadow-sm text-center">
                        Nova Oração
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($action === 'create' || $action === 'edit'): ?>
            <form action="oracoes.php?action=save" method="POST" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Título da Oração</label>
                        <input type="text" name="titulo" required class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-2.5 text-stone-900 focus:outline-none focus:border-amber-700 transition font-serif text-lg" placeholder="Ex: Oração de Jesus">
                    </div>
                    <div>
                        <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Categoria</label>
                        <input type="text" name="categoria" class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-2.5 text-stone-900 focus:outline-none focus:border-amber-700 transition" placeholder="Ex: Matinais, Hesicasmo">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Texto Sagrado da Prece</label>
                    <textarea name="texto" rows="8" required class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-3 text-stone-900 focus:outline-none focus:border-amber-700 transition leading-relaxed italic font-serif text-base" placeholder="Senhor Jesus Cristo, Filho de Deus, tem piedade de mim, pecador..."></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-2">
                    <a href="oracoes.php" class="bg-stone-200 text-stone-700 px-5 py-2 rounded font-medium text-sm hover:bg-stone-300 transition">Cancelar</a>
                    <button type="submit" class="bg-amber-800 text-white px-6 py-2 rounded font-medium text-sm hover:bg-amber-700 transition shadow-md">Eternizar Prece</button>
                </div>
            </form>

        <?php else: ?>
            <div class="overflow-x-auto rounded-lg border border-amber-900/10">
                <table class="w-full text-left border-collapse bg-stone-50/40">
                    <thead>
                        <tr class="bg-[#030712] text-amber-100 font-serif border-b border-amber-900/20">
                            <th class="p-4 font-bold tracking-wide">Título da Prece</th>
                            <th class="p-4 font-bold tracking-wide">Categoria</th>
                            <th class="p-4 font-bold tracking-wide text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200/80">
                        <tr class="hover:bg-amber-50/20 transition">
                            <td class="p-4 font-serif font-medium text-amber-950">Triságio (Santo Deus)</td>
                            <td class="p-4 text-stone-600 text-sm"><span class="bg-amber-900/10 text-amber-950 px-2 py-1 rounded text-xs font-semibold">Preces Iniciais</span></td>
                            <td class="p-4 text-center space-x-2">
                                <a href="oracoes.php?action=edit&id=1" class="text-amber-800 hover:text-amber-600 font-medium text-sm transition">Editar</a>
                                <span class="text-stone-300">|</span>
                                <a href="oracoes.php?action=delete&id=1" onclick="return confirm('Deseja arquivar e apagar esta santa prece?')" class="text-red-700 hover:text-red-500 font-medium text-sm transition">Excluir</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>