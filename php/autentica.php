<!-- 
    Autore: Schito Christian
-->
<?php
session_start();

require_once('connessione.php');
$conn = getDbConnection();
if(!$conn){
    die('Connessione fallita a MySQL !!!');
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validazione base
if (empty($email) || empty($password)) {
    $_SESSION['errore'] = 'Email e password obbligatorie';
    $_SESSION['codice_errore'] = 1;
    header('Location: ../index.php');
    exit;
}

// PRIMA QUERY: verifica credenziali ee tentativi
$sql_account = "SELECT email, password, attivo, tentativi 
                FROM account 
                WHERE email = ? LIMIT 1";

$stmtAcc = $conn->prepare($sql_account);
if (!$stmtAcc) {
    $_SESSION['errore'] = 'Errore database: ' . $conn->error;
    $_SESSION['codice_errore'] = 0;
    header('Location: ../index.php');
    exit;
}

$stmtAcc->bind_param('s', $email);
$stmtAcc->execute();
$resAcc = $stmtAcc->get_result();
$accountRow = $resAcc->fetch_assoc();
$stmtAcc->close();

// Se l'account non esiste (non rivelare troppo): messaggio generico
if (!$accountRow) {
    $_SESSION['errore'] = 'Credenziali non valide';
    $_SESSION['codice_errore'] = 3;
    header('Location: ../index.php');
    exit;
}

// se l'account esiste ma è bannato
if (isset($accountRow['attivo']) && intval($accountRow['attivo']) === 0) {
    $_SESSION['errore'] = 'Account sospeso: contatta l\'amministratore.';
    $_SESSION['codice_errore'] = 4; // codice per account bannato
    header('Location: ../index.php');
    exit;
}

// controllo password
if ($password === $accountRow['password']) {
    // login OK azzera i tentativi
    $sql_reset = "UPDATE account SET tentativi = 0 WHERE email = ?";
    $stmtReset = $conn->prepare($sql_reset);
    if ($stmtReset) {
        $stmtReset->bind_param('s', $email);
        $stmtReset->execute();
        $stmtReset->close();
    }

    // procedi con il login (recupero dati utente/ruolo)
} else {
    // password errata: incrementa contatore tentativi
    $current = intval($accountRow['tentativi'] ?? 0);
    $new = $current + 1;

    $sql_inc = "UPDATE account SET tentativi = ? WHERE email = ?";
    $stmtInc = $conn->prepare($sql_inc);
    if ($stmtInc) {
        $stmtInc->bind_param('is', $new, $email);
        $stmtInc->execute();
        $stmtInc->close();
    }

    // se abbiamo raggiunto la soglia, banna l'account
    if ($new >= 3) {
        $sql_ban = "UPDATE account SET attivo = 0 WHERE email = ?";
        $stmtBan = $conn->prepare($sql_ban);
        if ($stmtBan) {
            $stmtBan->bind_param('s', $email);
            $stmtBan->execute();
            $stmtBan->close();
        }
        $_SESSION['errore'] = 'Account sospeso per troppi tentativi non validi.';
        $_SESSION['codice_errore'] = 4;
        header('Location: ../index.php');
        exit;
    }

    // altrimenti mostra quanti tentativi rimangono
    $rimangono = 3 - $new;
    $_SESSION['errore'] = 'Credenziali non valide. Tentativi rimasti: ' . $rimangono;
    $_SESSION['codice_errore'] = 3;
    header('Location: ../index.php');
    exit;
}

// SECONDA QUERY: Recupera dati utente e ruolo
$sql_utente = "SELECT u.nome, u.cognome, u.id_ruolo, r.descrizione AS ruolo
               FROM utenti u
               LEFT JOIN ruoli r ON u.id_ruolo = r.id
               WHERE u.email = ?";

$stmt2 = $conn->prepare($sql_utente);
$stmt2->bind_param('s', $email);
$stmt2->execute();
$result2 = $stmt2->get_result();
$info = $result2->fetch_assoc();

// Salva i dati dell'utente in sessione
$_SESSION['utente_email'] = $email;
$_SESSION['utente_nome'] = $info['nome'] ?? '';
$_SESSION['utente_cognome'] = $info['cognome'] ?? '';
$_SESSION['utente_ruolo'] = $info['id_ruolo'] ?? null;
$_SESSION['utente_ruolo_desc'] = $info['ruolo'] ?? '';
$_SESSION['loggato'] = true;

// Elimina eventuali messaggi di errore e tentativi precedenti
$unset_session_vars = function() {
    unset($_SESSION['errore']);
    unset($_SESSION['codice_errore']);
    unset($_SESSION['tentativi']);
};

$unset_session_vars();

$stmt2->close();
$conn->close();

header('Location: ../index.php');
exit;