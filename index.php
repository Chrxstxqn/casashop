<!-- 
    Autore: Schito Christian
    github: https://Chrxstxqn/casashop
-->
<?php
session_start();
require 'php/connessione.php';
require 'php/queries.php';

$categoria = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;
$solo_nuovi = isset($_GET['nuovi']) && (int)$_GET['nuovi'] === 1;
$filtro_preferiti = isset($_GET['filter']) && $_GET['filter'] === 'preferiti';

$condizioni = [];
if ($categoria > 0) {
    $condizioni[] = "p.id_categoria = $categoria";
}
if ($solo_nuovi) {
    $condizioni[] = "p.`new` = 1";
}


// Se filtro preferiti e utente loggato -> prendi solo i preferiti
$prodotti = [];
if ($filtro_preferiti && isset($_SESSION['utente_email'])) {
    $prodotti = getProdottiPreferiti($conn, $_SESSION['utente_email']);
} else {
    $where_clause = '';
    if (!empty($condizioni)) {
        $where_clause = 'WHERE ' . implode(' AND ', $condizioni);
    }

    $sql_prodotti = "SELECT p.id, p.nome, p.prezzo_listino AS prezzo_originale, p.prezzo_scontato, 
                 p.giacenza AS disponibilita, p.`new` AS nuovo, p.url_foto AS immagine, c.nome AS categoria_nome
             FROM prodotti p
             JOIN categorie c ON p.id_categoria = c.id
             $where_clause
             ORDER BY p.id";

    $result = $conn->query($sql_prodotti);
    while ($row = $result->fetch_assoc()) {
        $prodotti[] = $row;
    }
}

$sql_categorie = "SELECT id, nome FROM categorie ORDER BY id";
$result_cat = $conn->query($sql_categorie);
$categorie = [];
while ($row = $result_cat->fetch_assoc()) {
    $categorie[] = $row;
}

$totale_prodotti = count($prodotti);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CasaShop - Accessori per la casa - Arezzo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- HEADER -->
    <header>
        <div class="logo">CasaShop</div>

        <?php if (isset($_SESSION['utente_email'])): ?>
            <!-- Utente loggato -->
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['utente_nome'] . ' ' . $_SESSION['utente_cognome']); ?></span>
                <a href="php/gestione.php" class="gestione-btn">Gestione</a>
                <a href="php/logout.php" class="logout-btn">Logout</a>
            </div>
        <?php else: ?>
            <!-- Form di login -->
            <form class="login-form" action="php/autentica.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <?php if (isset($_SESSION['errore'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_SESSION['errore']); ?></div>
                <?php unset($_SESSION['errore']); ?>
            <?php endif; ?>
        <?php endif; ?>
    </header>

    <!-- NAV -->
    <nav style="position: sticky; top: 0; z-index: 999;">
        <ul class="menu">
            <li><a href="./" class="<?php echo (!$categoria && !$filtro_preferiti) ? 'active' : ''; ?>">Tutti</a></li>
            <?php foreach ($categorie as $cat): ?>
                <li><a href="?categoria=<?php echo $cat['id']; ?><?php echo $solo_nuovi ? '&nuovi=1' : ''; ?>" class="<?php echo ($categoria === (int)$cat['id']) ? 'active' : ''; ?>"><?php echo $cat['nome']; ?></a></li>
            <?php endforeach; ?>
            <li><a href="?nuovi=1<?php echo $categoria > 0 ? '&categoria=' . $categoria : ''; ?>" class="<?php echo $solo_nuovi ? 'active' : ''; ?>">Solo novità </a></li>
            <!-- <li class="user"><?php echo htmlspecialchars($_SESSION['utente_nome']); ?></li> -->
            <?php if (isset($_SESSION['utente_email'])): ?>
                <a href="?<?php echo $categoria > 0 ? 'categoria=' . $categoria . '&' : ''; ?>filter=preferiti" class="filter-pill <?php echo $filtro_preferiti ? 'active' : ''; ?>">Preferiti</a>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- FILTRI -->
    <div class="filters">
        <form class="filter-form" method="GET">
            <input type="hidden" name="categoria" value="<?php echo $categoria; ?>">
            <label class="checkbox-filter">
                <input type="checkbox" name="nuovi" value="1" <?php echo $solo_nuovi ? 'checked' : ''; ?>>
                Mostra solo prodotti nuovi
            </label>
            <button type="submit">Applica</button>


            <?php if ($solo_nuovi): ?>
                <a class="reset-filter" href="<?php echo $categoria > 0 ? '?categoria=' . $categoria : './'; ?>">Rimuovi filtro</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- esito ricerca -->
    <div class="risultati">
        <?php echo $totale_prodotti; ?> prodotto<?php echo ($totale_prodotti != 1) ? 'i' : ''; ?> trovato<?php echo ($totale_prodotti != 1) ? 'i' : ''; ?>
    </div>

    <!-- MAIN CONTENT -->
    <main class="products">
        <?php
        // se l'utente è loggato prendi la lista di preferiti per marcare le icone
        $preferiti_ids = [];
        if (isset($_SESSION['utente_email'])) {
            $preferiti_ids = getPreferitiIds($conn, $_SESSION['utente_email']);
        }
        foreach ($prodotti as $prod): ?>
            <div class="product-card">
                <?php if ($prod['nuovo']): ?>
                    <span class="badge new">NEW</span>
                <?php endif; ?>
                <img src="<?php echo $prod['immagine']; ?>" alt="<?php echo $prod['nome']; ?>">
                <div class="product-info">
                    <h3><?php echo $prod['nome']; ?></h3>
                    <p class="category"><?php echo $prod['categoria_nome']; ?></p>
                    <p class="qty">Disponibilità: <?php echo $prod['disponibilita']; ?></p>
                    <div class="price-box">
                        <?php if ($prod['prezzo_originale'] > 0): ?>
                            <span class="old-price">€ <?php echo number_format($prod['prezzo_originale'], 2, ',', '.'); ?></span>
                        <?php endif; ?>
                        <span class="new-price">€ <?php echo number_format($prod['prezzo_scontato'], 2, ',', '.'); ?></span>
                    </div>
                    <div style="margin-top:10px; display:flex; align-items:center; gap:10px;">
                        <button class="add-btn">Aggiungi al carrello</button>
                        <?php if (isset($_SESSION['utente_email'])): ?>
                            <?php $isFav = in_array((int)$prod['id'], $preferiti_ids); ?>
                            <a href="php/toggle_fav.php?id=<?php echo $prod['id']; ?>" class="fav-btn" title="<?php echo $isFav ? 'Rimuovi dai preferiti' : 'Aggiungi ai preferiti'; ?>" style="text-decoration:none;font-size:18px;">
                                <?php if ($isFav): ?>
                                    <span style="color:#e63946;">♥</span>
                                <?php else: ?>
                                    <span style="color:#777;">♡</span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

</body>
</html>

<?php $conn->close(); ?>
