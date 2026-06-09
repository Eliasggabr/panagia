<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); } // se a sessão não tiver sido iniciada, inicia a sessão

if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') { // se não estiver logado ou n for admin, é mandado pra login.php
    header('Location: /login.php');
    exit;
}