<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); } // verifica se a sessão já foi iniciada, se não, inicia a sessão

if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') { // esse é o código porteiro, que verifica se o usuário está logado e se é do tipo admin, se não, te taca pra página de login
    header('Location: ../login.php'); exit;
}
require_once '../config/conexao.php'; // pega o pdo lá

$action = isset($_GET['action']) ? $_GET['action'] : 'list'; // pega o action da url com o valor dela, se ela n tiver o valor, ela pega list pra listar os arquivos


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save') { // verifica se o método é post e se o action é save, se for, ele salva ou edita o artigo
    $titulo   = trim($_POST['titulo']); // pega os valores enviados do formulário, o trim é pra tirar os espaços em branco no começo e no final
    $autor    = trim($_POST['autor']);
    $conteudo = trim($_POST['conteudo']);
    $id       = isset($_POST['id']) ? intval($_POST['id']) : 0; //verifica se foi enviado um id, se foi, converte pra número inteiro, se não, atribui 0, o id é usado pra saber se é pra editar ou criar um novo artigo

    if (!empty($titulo) && !empty($conteudo)) { // verifica se o título e o conteúdo não estão vazios
        if ($id > 0) { // se o id for maior que 0, significa que é pra editar um artigo, se for 0, é pra criar um novo artigo
            
            $stmt = $pdo->prepare("UPDATE artigos SET titulo = ?, autor = ?, conteudo = ? WHERE id = ?"); // prepara comando sql para modificar um artigo, usando o id para identificar qual é o artigo
            $stmt->execute([$titulo, $autor, $conteudo, $id]); // executa o comando e envia os dados pra substituir os pontinhos de interrogação
        } else { // se o id for 0, é pra criar um artigo
            
            $stmt = $pdo->prepare("INSERT INTO artigos (titulo, autor, conteudo) VALUES (?, ?, ?)"); // merma coisa do anterior, mas pra criar um artigo
            $stmt->execute([$titulo, $autor, $conteudo]); //merma coisa pt 2
        }
    }
    header('Location: artigos.php'); exit; // se estiverem vazios ele joga pra página de artigos sem salvar 
}

if ($action === 'delete' && isset($_GET['id'])) { // se a pessoa clicar pra deletar, o action é delete e o id é enviado via get
    $id = intval($_GET['id']); // transforma o id em número inteiro
    $stmt = $pdo->prepare("DELETE FROM artigos WHERE id = ?"); // prepara o comando sql pra deletar um artigo
    $stmt->execute([$id]); // executa o comando
    header('Location: artigos.php'); exit; // manda pra página de artigos
}

$artigo_editar = null;
if ($action === 'edit' && isset($_GET['id'])) { // se a ação for editar e existir o id
    $id = intval($_GET['id']); // armazena o id transformado em número inteiro
    $stmt = $pdo->prepare("SELECT * FROM artigos WHERE id = ?"); // prepara o comando sql pra selecionar o artigo que tem o id enviado
    $stmt->execute([$id]); //executa o comando de busca do artigo
    $artigo_editar = $stmt->fetch(PDO::FETCH_ASSOC); // pega só uma linha (artigo) do banco 
}

$stmt_lista = $pdo->query("SELECT * FROM artigos ORDER BY id DESC"); // pega os artigos do mais novo para o o mais velho para listar
$artigos = $stmt_lista->fetchAll(PDO::FETCH_ASSOC); // transforma o resultado em uma lista (pega todas as linhas)
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Artigos - Panagia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 text-stone-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-lg shadow-xl border border-amber-900/15 max-w-4xl w-full">
        
        <div class="flex flex-col sm:flex-row justify-between items-center border-b border-stone-200 pb-6 mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-serif font-bold tracking-wide text-amber-950">Gerenciar Artigos</h1>
                <p class="text-sm text-stone-500 font-serif italic mt-1">Textos teológicos, homilias e estudos patrísticos.</p>
            </div>
            <div class="flex items-center space-x-3 w-full sm:w-auto justify-end">
                <a href="index.php" class="border border-amber-900/30 text-amber-950 px-4 py-2 rounded font-medium text-sm hover:bg-stone-50 transition text-center w-full sm:w-auto">
                    Voltar ao Painel
                </a>
                <?php if ($action === 'list'): ?> // verifica se a ação é listar e abre um código HTML (:) para mostrar o botão de criar um novo artigo
                    <a href="artigos.php?action=create" class="bg-[#030712] text-stone-100 px-4 py-2 rounded font-medium text-sm hover:bg-slate-900 transition shadow-sm text-center w-full sm:w-auto">
                        Novo Artigo
                    </a>
                <?php endif; ?> //fecha o código HTML
            </div>
        </div>

        <?php if ($action === 'create' || $action === 'edit'): ?> // se a ação for criar ou editar, mostra o formulário de criação/edição 
            <form action="artigos.php?action=save" method="POST" class="space-y-5">
                <input type="hidden" name="id" value="<?= $artigo_editar ? $artigo_editar['id'] : '' ?>">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Título do Artigo</label>
                        <input type="text" name="titulo" required 
                               value="<?= $artigo_editar ? htmlspecialchars($artigo_editar['titulo']) : '' ?>" 
                               class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-2.5 text-stone-900 focus:outline-none focus:border-amber-700 transition font-serif text-lg" 
                               placeholder="Ex: Pela defesa do sacramento do Batismo">
                    </div>
                    <div>
                        <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Autor</label>
                        <input type="text" name="autor" 
                               value="<?= $artigo_editar ? htmlspecialchars($artigo_editar['autor']) : 'Admin - Elias' ?>" 
                               class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-2.5 text-stone-900 focus:outline-none focus:border-amber-700 transition" 
                               placeholder="Ex: Admin - Elias">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-serif font-bold text-amber-950 mb-1">Conteúdo Patrístico / Teológico</label>
                    <textarea name="conteudo" rows="12" required 
                              class="w-full bg-stone-50/60 border border-amber-900/20 rounded px-4 py-3 text-stone-900 focus:outline-none focus:border-amber-700 transition leading-relaxed font-serif text-base" 
                              placeholder="Escreva aqui o estudo, reflexão ou homilia..."><?= $artigo_editar ? htmlspecialchars($artigo_editar['conteudo']) : '' ?></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-2">
                    <a href="artigos.php" class="bg-stone-200 text-stone-700 px-5 py-2 rounded font-medium text-sm hover:bg-stone-300 transition">Cancelar</a>
                    <button type="submit" class="bg-amber-800 text-white px-6 py-2 rounded font-medium text-sm hover:bg-amber-700 transition shadow-md">
                        <?= $artigo_editar ? 'Atualizar Artigo' : 'Publicar Artigo' ?>
                    </button>
                </div>
            </form>

        <?php else: ?> // se a ação não for criar nem editar, mostra a lista de artigos com as opções de editar ou excluir cada um
            <div class="overflow-x-auto rounded-lg border border-amber-900/10">
                <table class="w-full text-left border-collapse bg-stone-50/40">
                    <thead>
                        <tr class="bg-[#030712] text-amber-100 font-serif border-b border-amber-900/20">
                            <th class="p-4 font-bold tracking-wide">Título</th>
                            <th class="p-4 font-bold tracking-wide">Autor</th>
                            <th class="p-4 font-bold tracking-wide text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200/80">
                        <?php if (empty($artigos)): ?> // verifica se tem artigos, se não tiver, diz que nenhum artigo foi publicado no momento
                            <tr>
                                <td colspan="3" class="p-4 text-center text-stone-500 font-serif italic">Nenhum artigo publicado no momento.</td>
                            </tr>
                        <?php else: ?> // se tiver, mostra cada um em uma linha da tabela, com as opções de editar ou excluir
                            <?php foreach ($artigos as $art): ?>
                                <tr class="hover:bg-amber-50/20 transition">
                                    <td class="p-4 font-serif font-medium text-amber-950"><?= htmlspecialchars($art['titulo']) ?></td>
                                    <td class="p-4 text-stone-600 text-sm font-medium"><?= htmlspecialchars($art['autor']) ?></td>
                                    <td class="p-4 text-center space-x-2">
                                        <a href="artigos.php?action=edit&id=<?= $art['id'] ?>" class="text-amber-800 hover:text-amber-600 font-medium text-sm transition">Editar</a>
                                        <span class="text-stone-300">|</span>
                                        <a href="artigos.php?action=delete&id=<?= $art['id'] ?>" 
                                           onclick="return confirm('Deseja realmente excluir este artigo teológico?')" 
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