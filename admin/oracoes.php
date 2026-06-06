<?php
require_once '../includes/auth.php';
require_once '../config/conexao.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];
    $categoria = $_POST['categoria'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE oracoes SET titulo = ?, texto = ?, categoria = ? WHERE id = ?");
        $stmt->execute([$titulo, $texto, $categoria, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO oracoes (titulo, texto, categoria) VALUES (?, ?, ?)");
        $stmt->execute([$titulo, $texto, $categoria]);
    }
    header('Location: oracoes.php'); exit;
}

if ($action === 'delete' && $id) {
    $pdo->prepare("DELETE FROM oracoes WHERE id = ?")->execute([$id]);
    header('Location: oracoes.php'); exit;
}

$item = null;
if ($id && ($action === 'edit')) {
    $stmt = $pdo->prepare("SELECT * FROM oracoes WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>CRUD Orações</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-stone-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-serif font-bold text-amber-900">Gerenciar Livro de Orações</h1>
            <div>
                <a href="index.php" class="text-stone-500 mr-4 hover:underline">Voltar</a>
                <a href="oracoes.php?action=create" class="bg-emerald-600 text-white px-4 py-2 rounded">Nova Oração</a>
            </div>
        </div>

        <?php if ($action === 'create' || $action === 'edit'): ?>
            <form method="POST" class="space-y-4">
                <div><label class="block font-bold">Título</label><input type="text" name="titulo" value="<?= $item['titulo'] ?? '' ?>" required class="w-full p-2 border rounded"></div>
                <div><label class="block font-bold">Categoria</label><input type="text" name="categoria" value="<?= $item['categoria'] ?? '' ?>" placeholder="Ex: Matinais" class="w-full p-2 border rounded"></div>
                <div><label class="block font-bold">Texto</label><textarea name="texto" rows="8" required class="w-full p-2 border rounded"><?= $item['texto'] ?? '' ?></textarea></div>
                <button type="submit" class="bg-amber-800 text-white px-4 py-2 rounded">Salvar</button>
                <a href="oracoes.php" class="bg-stone-300 px-4 py-2 rounded ml-2">Cancelar</a>
            </form>
        <?php else: ?>
            <table class="w-full text-left border-collapse">
                <thead><tr class="bg-stone-100"><th class="p-2 border">Título</th><th class="p-2 border">Categoria</th><th class="p-2 border">Ações</th></tr></thead>
                <tbody>
                    <?php foreach($pdo->query("SELECT * FROM oracoes ORDER BY id DESC") as $r): ?>
                    <tr>
                        <td class="p-2 border font-medium"><?= htmlspecialchars($r['titulo']) ?></td>
                        <td class="p-2 border text-sm text-stone-600"><?= htmlspecialchars($r['categoria']) ?></td>
                        <td class="p-2 border">
                            <a href="oracoes.php?action=edit&id=<?= $r['id'] ?>" class="text-blue-600 mr-2">Editar</a>
                            <a href="oracoes.php?action=delete&id=<?= $r['id'] ?>" onclick="return confirm('Excluir?')" class="text-red-600">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>