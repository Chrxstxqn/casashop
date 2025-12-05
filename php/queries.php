<?php
/**
 * File delle query
 * Autore: Schito Christian
 */

// query per ottenere le attività autorizzate per un utente
function getAttivitaByEmail($conn, $email) {
    $sql = "SELECT DISTINCT attivita.descrizione AS attivita, attivita.id, attivita.pagina
            FROM utenti
            JOIN ruoli ON utenti.id_ruolo = ruoli.id
            JOIN autorizzazioni ON ruoli.id = autorizzazioni.id_ruolo
            JOIN attivita ON autorizzazioni.id_attivita = attivita.id
            WHERE utenti.email = ?
            ORDER BY attivita.id";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return null;
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $attivita = [];
    while ($row = $result->fetch_assoc()) {
        $attivita[] = $row;
    }

    $stmt->close();
    return $attivita;
}

// query per ottenere tutti i prodotti
function getProdotti($conn, $categoria = 0) {
    if ($categoria > 0) {
        $sql = "SELECT p.id, p.nome, p.prezzo_listino AS prezzo_originale, p.prezzo_scontato, 
                     p.giacenza AS disponibilita, p.`new` AS nuovo, p.url_foto AS immagine, c.nome AS categoria_nome
                 FROM prodotti p
                 JOIN categorie c ON p.id_categoria = c.id
                 WHERE p.id_categoria = ?
                 ORDER BY p.id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $categoria);
    } else {
        $sql = "SELECT p.id, p.nome, p.prezzo_listino AS prezzo_originale, p.prezzo_scontato, 
                     p.giacenza AS disponibilita, p.`new` AS nuovo, p.url_foto AS immagine, c.nome AS categoria_nome
                 FROM prodotti p
                 JOIN categorie c ON p.id_categoria = c.id
                 ORDER BY p.id";
        
        $stmt = $conn->prepare($sql);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $prodotti = [];
    while ($row = $result->fetch_assoc()) {
        $prodotti[] = $row;
    }
    
    $stmt->close();
    return $prodotti;
}

// query per ottenere tutte le categorie
function getCategorie($conn) {
    $sql = "SELECT id, nome FROM categorie ORDER BY id";
    $result = $conn->query($sql);
    
    $categorie = [];
    while ($row = $result->fetch_assoc()) {
        $categorie[] = $row;
    }
    
    return $categorie;
}

// query per ottenere tutti gli account
function getAccount($conn) {
    $sql = "SELECT a.email, a.password, u.nome, u.cognome, u.id_ruolo 
            FROM account a
            LEFT JOIN utenti u ON a.email = u.email
            ORDER BY a.email";
    
    $result = $conn->query($sql);
    
    $account = [];
    while ($row = $result->fetch_assoc()) {
        $account[] = $row;
    }
    
    return $account;
}

// Ottieni gli id dei prodotti preferiti per un utente
function getPreferitiIds($conn, $email) {
    $sql = "SELECT id_prodotto FROM preferiti WHERE email = ? ORDER BY id_prodotto";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $ids = [];
    while ($row = $result->fetch_assoc()) {
        $ids[] = (int)$row['id_prodotto'];
    }
    $stmt->close();
    return $ids;
}

// Ottieni i prodotti preferiti (dettagli) per un utente
function getProdottiPreferiti($conn, $email) {
    $sql = "SELECT p.id, p.nome, p.prezzo_listino AS prezzo_originale, p.prezzo_scontato, 
                   p.giacenza AS disponibilita, p.`new` AS nuovo, p.url_foto AS immagine, c.nome AS categoria_nome
            FROM prodotti p
            JOIN categorie c ON p.id_categoria = c.id
            JOIN preferiti f ON p.id = f.id_prodotto
            WHERE f.email = ?
            ORDER BY p.id";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $prodotti = [];
    while ($row = $result->fetch_assoc()) {
        $prodotti[] = $row;
    }
    $stmt->close();
    return $prodotti;
}

/**
 * Gestione reindirizzamenti delle azioni
 * Array centrale per mappare le azioni ai file
 * Modifica questo array per gestire i reindirizzamenti
 */
// function getAzioniMap() {
//     return [
//         1 => [
//             'descrizione' => 'Aggiungi nuovo prodotto',
//             'file' => 'nuovoprodotto.php'
//         ],
//         2 => [
//             'descrizione' => 'Elimina prodotto dal catalogo',
//             'file' => 'eliminaprodotto.php'
//         ],
//         3 => [
//             'descrizione' => 'Modifica dati prodotto',
//             'file' => 'modificaprodotto.php'
//         ],
//         9 => [
//             'descrizione' => 'Crea nuovo account',
//             'file' => 'creaaccount.php'
//         ],
//         10 => [
//             'descrizione' => 'Banna account',
//             'file' => 'bannaaccount.php'
//         ],
//         11 => [
//             'descrizione' => 'Sblocca account',
//             'file' => 'sbloccaaccount.php'
//         ],
//         12 => [
//             'descrizione' => 'Reset password utente',
//             'file' => 'resetpassword.php'
//         ],
//         13 => [
//             'descrizione' => 'statistiche',
//             'file' => 'statistiche.php'
//         ],
//         14 => [
//             'descrizione' => 'gestione novità',
//             'file' => 'gestionenovita.php'
//         ],
//         15 => [
//             'descrizione' => 'Cronologia acquisti',
//             'file' => 'cronologiaacquisti.php'
//         ]
//     ];
// }

// /**
//  * Ottieni il percorso del file per un'azione
//  * @param int $id_attivita ID dell'attività
//  * @return string Path del file
//  */
// function getFileFromAzione($id_attivita) {
//     $azioni = getAzioniMap();
//     return isset($azioni[$id_attivita]) ? $azioni[$id_attivita]['file'] : '#';
// }

?>

