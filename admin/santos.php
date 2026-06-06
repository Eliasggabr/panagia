<?php
require_once '../includes/auth.php';
require_once '../config/conexao.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $biografia = $_POST['biografia'];
    $dia_festa = $_POST['dia_festa'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE santos SET nome = ?, biografia = ?, dia_festa = ? WHERE id = ?");
        $stmt->execute([$nome, $biografia, $dia_festa, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO santos (nome, biografia, dia_festa) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $biografia, $dia_festa]);
    }
    header('Location: santos.php'); exit;
}

if ($action === 'delete' && $id) {
    $pdo->prepare("DELETE FROM santos WHERE id = ?")->execute([$id]);
    header('Location: santos.php'); exit;
}

$item = null;
if ($id && ($action === 'edit')) {
    $stmt = $pdo->prepare("SELECT * FROM santos WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>CRUD Santos</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-stone-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-serif font-bold text-amber-900">Gerenciar Santos</h1>
            <div>
                <a href="index.php" class="text-stone-500 mr-4 hover:underline">Voltar</a>
                <a href="santos.php?action=create" class="bg-emerald-600 text-white px-4 py-2 rounded">Novo Santo</a>
            </div>
        </div>

        <?php if ($action === 'create' || $action === 'edit'): ?>
            <form method="POST" class="space-y-4">
                <div><label class="block font-bold">Nome do Santo</label><input type="text" name="nome" value="<?= $item['nome'] ?? '' ?>" required class="w-full p-2 border rounded"></div>
                <div><label class="block font-bold">Festa Litúrgica</label><input type="text" name="dia_festa" value="<?= $item['dia_festa'] ?? '' ?>" placeholder="Ex: 25 de Março" class="w-full p-2 border rounded"></div>
                <div><label class="block font-bold">Biografia</label><textarea name="biografia" rows="6" required class="w-full p-2 border rounded"><?= $item['biografia'] ?? '' ?></textarea></div>
                <button type="submit" class="bg-amber-800 text-white px-4 py-2 rounded">Salvar</button>
                <a href="santos.php" class="bg-stone-300 px-4 py-2 rounded ml-2">Cancelar</a>
            </form>
        <?php else: ?>
            <table class="w-full text-left border-collapse">
                <thead><tr class="bg-stone-100"><th class="p-2 border">Nome</th><th class="p-2 border">Festa</th><th class="p-2 border">Ações</th></tr></thead>
                <tbody>
                    <?php foreach($pdo->query("SELECT * FROM santos ORDER BY id DESC") as $r): ?>
                    <tr>
                        <td class="p-2 border"><?= htmlspecialchars($r['nome']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($r['dia_festa']) ?></td>
                        <td class="p-2 border">
                            <a href="santos.php?action=edit&id=<?= $r['id'] ?>" class="text-blue-600 mr-2">Editar</a>
                            <a href="santos.php?action=delete&id=<?= $r['id'] ?>" onclick="return confirm('Excluir?')" class="text-red-600">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>