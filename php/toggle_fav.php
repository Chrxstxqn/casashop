<?php
/* aggiunge o rimuove dalla tabella preferiti
   usa GET?id=... e richiede login. Ritorna alla pagina di provenienza.
*/
session_start();
require_once('connessione.php');
$conn = getDbConnection();
if (!$conn) {
    header('Location: ../index.php');
    exit;
}

if (!isset($_SESSION['utente_email'])) {
    // non loggato -> redirect
    header('Location: ../index.php');
    exit;
}

$email = $_SESSION['utente_email'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ../index.php');
    exit;
}

// controlla se esiste già
$sql_check = "SELECT 1 FROM preferiti WHERE email = ? AND id_prodotto = ? LIMIT 1";
$stmt = $conn->prepare($sql_check);
if ($stmt) {
    $stmt->bind_param('si', $email, $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $exists = (bool) $res->fetch_row();
    $stmt->close();

    if ($exists) {
        // rimuovi
        $sql_del = "DELETE FROM preferiti WHERE email = ? AND id_prodotto = ?";
        $s2 = $conn->prepare($sql_del);
        if ($s2) {
            $s2->bind_param('si', $email, $id);
            $s2->execute();
            $s2->close();
        }
    } else {
        // inserisci
        $sql_ins = "INSERT INTO preferiti (email, id_prodotto) VALUES (?, ?)";
        $s2 = $conn->prepare($sql_ins);
        if ($s2) {
            $s2->bind_param('si', $email, $id);
            $s2->execute();
            $s2->close();
        }
    }
}

$conn->close();

// redirect alla pagina precedente se disponibile
$back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
header('Location: ' . $back);
exit;
