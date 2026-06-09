<?php
session_start(); // inicia a sessão
session_destroy(); // a sessão vai de f (desloga o usuário)
header('Location: index.php'); // taca o caba pro index.php
exit;