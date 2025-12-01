<?php
/**
 * File delle query
 * Autore: Schito Christian
 */

// query per ottenere le attività autorizzate per un utente
function getAttivitaByEmail($conn, $email) {
    $sql = "SELECT attivita.descrizione AS attivita, attivita.pagina AS destinazione, attivita.id
            FROM utenti, ruoli, autorizzazioni, attivita
            WHERE utenti.id_ruolo=ruoli.id 
                AND ruoli.id=autorizzazioni.id_ruolo 
                AND autorizzazioni.id_attivita=attivita.id
                AND utenti.email=?";
    
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

?>
