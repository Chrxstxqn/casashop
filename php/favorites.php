<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['preferiti']) || !is_array($_SESSION['preferiti'])) {
    $_SESSION['preferiti'] = [];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metodo non valido']);
    exit;
}

$id = isset($_POST['prodotto_id']) ? (int)$_POST['prodotto_id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID prodotto non valido']);
    exit;
}

$preferiti = $_SESSION['preferiti'];

if (in_array($id, $preferiti)) {
    // rimuovi
    $preferiti = array_values(array_filter($preferiti, function($p) use ($id) {
        return (int)$p !== $id;
    }));
    $favorito = false;
} else {
    // aggiungi
    $preferiti[] = $id;
    $favorito = true;
}

$_SESSION['preferiti'] = $preferiti;

echo json_encode([
    'success' => true,
    'favorito' => $favorito,
    'lista' => $preferiti
]);
