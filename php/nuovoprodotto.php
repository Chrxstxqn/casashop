<!-- 
    Autore: Schito Christian
-->

<?php
session_start();
require_once('connessione.php');
require_once('queries.php');
$conn = getDbConnection();
if (!$conn) {
    die('Connessione al database fallita.');
}

$categorie = getCategorie($conn);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $id_categoria = (int)($_POST['id_categoria'] ?? 0);
    $giacenza = (int)($_POST['giacenza'] ?? 0);
    $prezzo_listino = (float)($_POST['prezzo_listino'] ?? 0);
    $prezzo_scontato = (float)($_POST['prezzo_scontato'] ?? 0);
    $url_foto = trim($_POST['url_foto'] ?? '');
    $nuovo = isset($_POST['nuovo']) ? 1 : 0;

    if ($nome && $id_categoria > 0 && $giacenza >= 0 && $prezzo_listino >= 0 && $url_foto) {
        $sql = "INSERT INTO prodotti (nome, id_categoria, giacenza, prezzo_listino, prezzo_scontato, url_foto, `new`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('siiddsi', $nome, $id_categoria, $giacenza, $prezzo_listino, $prezzo_scontato, $url_foto, $nuovo);
            if ($stmt->execute()) {
                $msg = '<div class="success">Prodotto inserito</div>';
            } else {
                $msg = '<div class="error">Errore inserimento prodotto: ' . htmlspecialchars($stmt->error) . '</div>';
            }
            $stmt->close();
        } else {
            $msg = '<div class="error">Errore DB: ' . htmlspecialchars($conn->error) . '</div>';
        }
    } else {
        $msg = '<div class="error">Compila tutti i campi obbligatori.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Prodotto - CasaShop</title>
    <link rel="stylesheet" href="../css/gestione.css">
    <link rel="stylesheet" href="../css/nuovop.css">
</head>
<body>

    <header>
        <div class="logo">CasaShop</div>
        <div class="user-info">
            <span class="user-name"><?php echo htmlspecialchars($_SESSION['utente_nome'] . ' ' . $_SESSION['utente_cognome']); ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <nav style="position: sticky; top: 0; z-index: 999;">
        <ul class="menu">
            <li><a href="gestione.php">← Torna a gestione</a></li>
        </ul>
    </nav>

    <main>
        <h2 style="text-align:center;">Nuovo Prodotto</h2>
        <?php echo $msg; ?>
        <form class="form-nuovo-prodotto" method="POST" autocomplete="off">
            <label>Nome prodotto *</label>
            <input type="text" name="nome" required maxlength="50">

            <label>Categoria *</label>
            <select name="id_categoria" required>
                <option value="">-- Seleziona categoria --</option>
                <?php foreach ($categorie as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome']); ?></option>
                <?php endforeach; ?>
            </select>

            <div class="row">
                <div>
                    <label>Prezzo listino *</label>
                    <input type="number" name="prezzo_listino" min="0" step="0.01" required>
                </div>
                <div>
                    <label>Prezzo scontato</label>
                    <input type="number" name="prezzo_scontato" min="0" step="0.01">
                </div>
            </div>

            <div class="row">
                <div>
                    <label>Giacenza *</label>
                    <input type="number" name="giacenza" min="0" required>
                </div>
                <div>
                    <label>Nuovo</label>
                    <input type="checkbox" name="nuovo" value="1">
                </div>
            </div>

            <label>URL immagine *</label>
            <input type="url" name="url_foto" required maxlength="150">

            <button type="submit">Salva prodotto</button>
        </form>
    </main>

</body>
</html>

<?php $conn->close(); ?>