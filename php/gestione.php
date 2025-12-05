<!-- 
    Autore: Schito Christian
-->
<?php
session_start();
require 'connessione.php';
require 'queries.php';

if (!isset($_SESSION['utente_email'])) {
    header('Location: ../index.php');
    exit;
}

//attività autorizzate per l'utente loggato
$email_utente = $_SESSION['utente_email'];
$attivita_disponibili = getAttivitaByEmail($conn, $email_utente);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CasaShop - Accessori per la casa - Arezzo</title>
    <link rel="stylesheet" href="../css/gestione.css">
</head>
<body>

    <!-- HEADER -->
    <header>
        <div class="logo">CasaShop</div>

        <?php if (isset($_SESSION['utente_email'])): ?>
            <!-- Utente loggato -->
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['utente_nome'] . ' ' . $_SESSION['utente_cognome']); ?></span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        <?php else: ?>
            <!-- Form di login -->
            <form class="login-form" action="autentica.php" method="POST">
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
            <li><a href="../index.php">← Torna al negozio</a></li>
            <li class="user"><?php echo htmlspecialchars($_SESSION['utente_nome']); ?></li>
        </ul>
    </nav>

    <!-- MAIN CONTENT - Attività disponibili -->
    <main class="admin-panel">
        <h2>Pannello di Gestione</h2>
        
        <?php if (count($attivita_disponibili) > 0): ?>
            <div class="attivita-list">
                <?php foreach ($attivita_disponibili as $att): ?>
                    <div class="attivita-card">
                        <h3><?php echo htmlspecialchars($att['attivita']); ?></h3>
                        <?php echo $att['attivita'].' '.$att['pagina']?>
                        <a href="<?php echo htmlspecialchars($att['pagina']); ?>" class="action-link">
                            Accedi →
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-attivita">
                <p>Non hai attività autorizzate.</p>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>

<?php $conn->close(); ?>