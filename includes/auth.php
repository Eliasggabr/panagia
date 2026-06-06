<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: /panagia/login.php');
    exit;
}