<!-- 
    Autore: Schito Christian
-->
<?php
    function getDbConnection() {

        // ---- PARAMETRI DI CONNESSIONE AL DATABASE ----
        $host = 'localhost';           // Host del database
        $user = 'root';                // Utente MySQL
        $password = '';                // Password MySQL
        $database = 'casashop';        // Nome del database
        // -----------------------------------------------

        // Crea l'oggetto connessione
        $conn = mysqli_connect($host, $user, $password, $database);

        if (mysqli_connect_errno()) {
            error_log("Errore di connessione al database: " . mysqli_connect_error());
            return null; 
        }
        return $conn;
    }
    
    // Crea la connessione globale
    $conn = getDbConnection();
?>
