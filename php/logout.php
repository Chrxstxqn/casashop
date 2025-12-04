<!-- 
    Autore: Schito Christian
-->
<?php
session_start();


session_unset(); // rimuove tutte le variabili di sessione

session_destroy(); // ristrugge la sessione

header('Location: ../index.php');
exit;