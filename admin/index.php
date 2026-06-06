<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
// Proteção simples: se não for admin, chuta de volta para o login ou index
if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Panagia - Administração</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 text-stone-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-lg shadow-xl border border-amber-900/15 max-w-4xl w-full">
        
        <div class="flex flex-col sm:flex-row justify-between items-center border-b border-stone-200 pb-6 mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-serif font-bold tracking-wide text-amber-950 flex items-center gap-2">
                    Painel Panagia
                </h1>
                <p class="text-sm text-stone-500 font-serif italic mt-1">
                    Bem-vindo ao controle de Tradições, <span class="text-amber-900 font-sans font-bold not-italic"><?= htmlspecialchars($_SESSION['nome']) ?></span>.
                </p>
            </div>
            
            <div class="flex items-center space-x-3 w-full sm:w-auto justify-end">
                <a href="../index.php" class="bg-[#030712] text-stone-100 px-4 py-2 rounded font-medium text-sm hover:bg-slate-900 transition shadow-sm text-center w-full sm:w-auto">
                    Ver Site Público
                </a>
                
                <a href="../logout.php" class="bg-red-800 text-white px-4 py-2 rounded font-medium text-sm hover:bg-red-700 transition shadow-sm text-center w-full sm:w-auto">
                    Sair
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <a href="artigos.php" class="group bg-stone-50/60 p-6 rounded-lg border border-amber-900/10 shadow-sm hover:border-amber-700 hover:bg-amber-50/30 transition flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-serif font-bold text-amber-950 group-hover:text-amber-800 transition">
                        Artigos
                    </h2>
                    <p class="text-stone-600 text-sm mt-2 leading-relaxed">
                        Publicar textos teológicos, homilias e estudos patrísticos.
                    </p>
                </div>
                <div class="text-xs font-bold text-amber-800 uppercase tracking-wider mt-4 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Gerenciar &rarr;
                </div>
            </a>
            
            <a href="santos.php" class="group bg-stone-50/60 p-6 rounded-lg border border-amber-900/10 shadow-sm hover:border-amber-700 hover:bg-amber-50/30 transition flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-serif font-bold text-amber-950 group-hover:text-amber-800 transition">
                        Santos
                    </h2>
                    <p class="text-stone-600 text-sm mt-2 leading-relaxed">
                        Alimentar o Sinaxário, biografias e datas de festas litúrgicas.
                    </p>
                </div>
                <div class="text-xs font-bold text-amber-800 uppercase tracking-wider mt-4 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Gerenciar &rarr;
                </div>
            </a>

            <a href="oracoes.php" class="group bg-stone-50/60 p-6 rounded-lg border border-amber-900/10 shadow-sm hover:border-amber-700 hover:bg-amber-50/30 transition flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-serif font-bold text-amber-950 group-hover:text-amber-800 transition">
                        Orações
                    </h2>
                    <p class="text-stone-600 text-sm mt-2 leading-relaxed">
                        Organizar as santas preces por categorias e títulos.
                    </p>
                </div>
                <div class="text-xs font-bold text-amber-800 uppercase tracking-wider mt-4 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Gerenciar &rarr;
                </div>
            </a>
            
        </div>

    </div>

</body>
</html>