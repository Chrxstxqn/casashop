<?php
/* Autore: Schito Christian */
session_start();
require_once('connessione.php');

// Controllo admin
if (!isset($_SESSION['utente_email']) || ($_SESSION['utente_ruolo'] ?? 0) != 99) {
    header('Location: ../index.php');
    exit;
}

$email = isset($_GET['email']) ? trim($_GET['email']) : '';
if (empty($email)) {
    header('Location: account.php');
    exit;
}

$sql = "UPDATE account SET attivo = 0 WHERE email = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header('Location: account.php');
exit;
