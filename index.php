<!-- 
    Autore: Schito Christian
-->
<?php
session_start();
require 'php/connessione.php';

$categoria = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;

if ($categoria > 0) {
    $sql_prodotti = "SELECT p.id, p.nome, p.prezzo_listino AS prezzo_originale, p.prezzo_scontato, 
                 p.giacenza AS disponibilita, p.`new` AS nuovo, p.url_foto AS immagine, c.nome AS categoria_nome
             FROM prodotti p
             JOIN categorie c ON p.id_categoria = c.id
             WHERE p.id_categoria = $categoria
             ORDER BY p.id";
} else {
    $sql_prodotti = "SELECT p.id, p.nome, p.prezzo_listino AS prezzo_originale, p.prezzo_scontato, 
                 p.giacenza AS disponibilita, p.`new` AS nuovo, p.url_foto AS immagine, c.nome AS categoria_nome
             FROM prodotti p
             JOIN categorie c ON p.id_categoria = c.id
             ORDER BY p.id";
}

$result = $conn->query($sql_prodotti);
$prodotti = [];
while ($row = $result->fetch_assoc()) {
    $prodotti[] = $row;
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
            <?php foreach ($categorie as $cat): ?>
                <li><a href="?categoria=<?php echo $cat['id']; ?>"><?php echo $cat['nome']; ?></a></li>
            <?php endforeach; ?>
            <li class="user">utente</li>
        </ul>
    </nav>

    <!-- esito ricerca -->
    <div class="risultati">
        <?php echo $totale_prodotti; ?> prodotto<?php echo ($totale_prodotti != 1) ? 'i' : ''; ?> trovato<?php echo ($totale_prodotti != 1) ? 'i' : ''; ?>
    </div>

    <!-- MAIN CONTENT -->
    <main class="products">
        <?php foreach ($prodotti as $prod): ?>
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
                    <button class="add-btn">Aggiungi al carrello</button>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

</body>
</html>

<?php $conn->close(); ?>
