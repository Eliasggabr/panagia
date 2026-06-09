<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); } // começa a sessão se não tiver sido iniciada
if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') { // se não estiver logado ou n for admin, é mandado pra login.php
    header('Location: ../login.php'); exit;
}
require_once '../config/conexao.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list'; // pega a ação da URL, se não tiver, é list


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save') { // se o método for post e a ação for salvar, executa a criação ou edição dos santos
    $nome      = trim($_POST['nome']);
    $dia_festa = trim($_POST['dia_festa']);
    $biografia = trim($_POST['biografia']);
    $id        = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if (!empty($nome) && !empty($biografia)) { // se o nome e a biografia não estiverem vazios, executa a criação ou edição do santo
        if ($id > 0) { // se o id for maior que 0, é edição, se for 0, é criação
            
            $stmt = $pdo->prepare("UPDATE santos SET nome = ?, dia_festa = ?, biografia = ? WHERE id = ?"); // prepara o comando sql de editar
            $stmt->execute([$nome, $dia_festa, $biografia, $id]); // executa o comando
        } else {
            
            $stmt = $pdo->prepare("INSERT INTO santos (nome, dia_festa, biografia) VALUES (?, ?, ?)"); // prepara o comando sql de criar
            $stmt->execute([$nome, $dia_festa, $biografia]); // executa o comando
        }
    }
    header('Location: santos.php'); exit; // depois de salvar, manda pra santos.php
}

if ($action === 'delete' && isset($_GET['id'])) { // se a ação for delete e tiver o id na URL, executa a exclusão do santo
    $id = intval($_GET['id']); // armazena o id como número inteiro 
    $stmt = $pdo->prepare("DELETE FROM santos WHERE id = ?"); // prepara o comando sql de deletar 
    $stmt->execute([$id]); // executa 
    header('Location: santos.php'); exit; // depois de excluir, manda para santos.php
}

$santo_editar = null;
if ($action === 'edit' && isset($_GET['id'])) { // se a ação for edit e tiver o id na URL, busca os dados do santo
    $id = intval($_GET['id']); // armazena o id como número inteiro
    $stmt = $pdo->prepare("SELECT * FROM santos WHERE id = ?"); // prepara o comando sql de selecionar o santo pelo id
    $stmt->execute([$id]); // executa o comando
    $santo_editar = $stmt->fetch(PDO::FETCH_ASSOC); // armazena os dados do santo em uma lista 
}

$stmt_lista = $pdo->query("SELECT * FROM santos ORDER BY id DESC"); // prepara o comando sql de selecionar todos os santos pelo id do mais recente para o mais antigo
$santos = $stmt_lista->fetchAll(PDO::FETCH_ASSOC); // pega o resultado do comando e armazena em uma lista
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Santos - Panagia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 text-stone-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-lg shadow-xl border border-amber-900/15 max-w-4xl w-full">
        
        <div class="flex flex-col sm:flex-row justify-between items-center border-b border-stone-200 pb-6 mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-serif font-bold tracking-wide text-amber-950">Gerenciar Sinaxário</h1>
                <p class="text-sm text-stone-500 font-serif italic mt-1">Alimentar memórias, biografias e memórias litúrgicas.</p>
            </div>
            <div class="flex items-center space-x-3 w-full sm:w-auto justify-end">
                <a href="index.php" class="border border-amber-900/30 text-amber-950 px-4 py-2 rounded font-medium text-sm hover:bg-stone-50 transition text-center w-full sm:w-auto">
                    Voltar ao Painel
                </a>
                <?php if ($action === 'list'): ?> // se a ação for list, mostra o botão de criar novo santo
                    <a href="santos.php?action=create" class="bg-[#030712] text-stone-100 px-4 py-2 rounded font-medium text-sm hover:bg-slate-900 transition shadow-sm text-center w-full sm:w-auto">
                        Novo Santo
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($action === 'create' || $action === 'edit'): ?> // se a ação for criar ou editar, mostra o formulário de criação/edição
            <form action="santos.php?action=save" method="POST" class="space-y-5">
                <input type="hidden" name="id" value="<?= $santo_editar ? $santo_editar['id'] : '' ?>">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Nome do Santo / Justo</label>
                        <input type="text" name="nome" required 
                               value="<?= $santo_editar ? htmlspecialchars($santo_editar['nome']) : '' ?>" 
                               class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-2.5 text-stone-900 focus:outline-none focus:border-amber-700 transition font-serif text-lg" 
                               placeholder="Ex: São João Crisóstomo">
                    </div>
                    <div>
                        <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Festa Litúrgica</label>
                        <input type="text" name="dia_festa" required 
                               value="<?= $santo_editar ? htmlspecialchars($santo_editar['dia_festa']) : '' ?>" 
                               class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-2.5 text-stone-900 focus:outline-none focus:border-amber-700 transition" 
                               placeholder="Ex: 13 de Novembro">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Santa Biografia / Vida</label>
                    <textarea name="biografia" rows="8" required 
                              class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-3 text-stone-900 focus:outline-none focus:border-amber-700 transition leading-relaxed" 
                              placeholder="Relate aqui os milagres, martírio e a santa jornada espiritual..."><?= $santo_editar ? htmlspecialchars($santo_editar['biografia']) : '' ?></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-2">
                    <a href="santos.php" class="bg-stone-200 text-stone-700 px-5 py-2 rounded font-medium text-sm hover:bg-stone-300 transition">Cancelar</a>
                    <button type="submit" class="bg-amber-800 text-white px-6 py-2 rounded font-medium text-sm hover:bg-amber-700 transition shadow-md">
                        <?= $santo_editar ? 'Atualizar no Livro' : 'Gravar no Livro' ?>
                    </button>
                </div>
            </form>

        <?php else: ?> // se a ação não for criar e nem editar, mostra a lista de santos com as opções de editar ou excluir
            <div class="overflow-x-auto rounded-lg border border-amber-900/10">
                <table class="w-full text-left border-collapse bg-stone-50/40">
                    <thead>
                        <tr class="bg-[#030712] text-amber-100 font-serif border-b border-amber-900/20">
                            <th class="p-4 font-bold tracking-wide">Nome Venerável</th>
                            <th class="p-4 font-bold tracking-wide">Festa Litúrgica</th>
                            <th class="p-4 font-bold tracking-wide text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200/80">
                        <?php if (empty($santos)): ?> // se não tiver santos cadastrados, mostra a mensagem de q n tem nenhum santo registrado ainda
                            <tr>
                                <td colspan="3" class="p-4 text-center text-stone-500 font-serif italic">Nenhum santo registrado no momento.</td>
                            </tr>
                        <?php else: ?> // se tiver, mostra a lista dos santos com suas opções (editar/excluir)
                            <?php foreach ($santos as $snt): ?> // percorre a lista de santos e a mostra com as opções de editar ou excluir
                                <tr class="hover:bg-amber-50/20 transition">
                                    <td class="p-4 font-serif font-medium text-amber-950"><?= htmlspecialchars($snt['nome']) ?></td>
                                    <td class="p-4 text-amber-900 text-sm font-medium"><?= htmlspecialchars($snt['dia_festa']) ?></td>
                                    <td class="p-4 text-center space-x-2">
                                        <a href="santos.php?action=edit&id=<?= $snt['id'] ?>" class="text-amber-800 hover:text-amber-600 font-medium text-sm transition">Editar</a>
                                        <span class="text-stone-300">|</span>
                                        <a href="santos.php?action=delete&id=<?= $snt['id'] ?>" 
                                           onclick="return confirm('Deseja retirar este santo do Sinaxário ativo?')" 
                                           class="text-red-700 hover:text-red-500 font-medium text-sm transition">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>