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

// PRIMA QUERY: Verifica credenziali
$sql_account = "SELECT email, password 
                FROM account 
                WHERE email = ? AND password = ?";

$stmt = $conn->prepare($sql_account);
if (!$stmt) {
    $_SESSION['errore'] = 'Errore database: ' . $conn->error;
    $_SESSION['codice_errore'] = 0;
    header('Location: ../index.php');
    exit;
}

$stmt->bind_param('ss', $email, $password);
$stmt->execute();
$result = $stmt->get_result();
$utente = $result->fetch_assoc();

// Se l'account non esiste
if (!$utente) {
    $_SESSION['errore'] = 'Credenziali non valide';
    $_SESSION['codice_errore'] = 3;
    $_SESSION['tentativi'] = isset($_SESSION['tentativi']) ? $_SESSION['tentativi'] + 1 : 1;
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
unset($_SESSION['errore']);
unset($_SESSION['codice_errore']);
unset($_SESSION['tentativi']);

$stmt->close();
$stmt2->close();
$conn->close();

header('Location: ../index.php');
exit;