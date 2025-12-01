<?php
session_start();

require_once('connessione_database.php');
$conn = getDbConnection();
if(!$conn){
    die('Connessione fallita a MySQL !!!');
}

$email = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT email, psw, attivo AS account_attivo 
          FROM account 
          WHERE email = ? AND psw = ? ";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$utente = mysqli_fetch_array($result);

if(!$utente || $utente['account_attivo'] == 0){
    $_SESSION['loggato'] = false;
    $_SESSION['codice_errore'] = 3;
    header('location: ../index.php');
    exit;
}

//se esiste ma le password non coincidono
if ($password !== $utente['psw']) {    
    $_SESSION['loggato'] = false;
    $_SESSION['tentativi']++;
    $_SESSION['codice_errore'] = 2;
    //torna alla pagina di login con un messaggio di errore passato in una variabile session che gestirà la pagina di login (frontend)
    header('location: ../index.php'); 
    exit;
}

// ---- SECONDA QUERY ----
$query_utente = "SELECT nome, cognome, ruoli.descrizione AS ruolo
                 FROM utenti, ruoli 
                 WHERE  id_ruolo = ruoli.id 
                 AND email = ?";
                 
$stmt2 = mysqli_prepare($conn, $query_utente);
mysqli_stmt_bind_param($stmt2, "s", $email);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
$info = mysqli_fetch_array($result2);

$_SESSION['nome'] = $info['nome'];
$_SESSION['cognome'] = $info['cognome'];
$_SESSION['email'] = $email;
$_SESSION['ruolo'] = $info['ruolo'];
$_SESSION['loggato'] = true;


header('location: area_riservata.php');
exit;