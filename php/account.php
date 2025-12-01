<?php
session_start();
require 'php/connessione.php';

if (!isset($_SESSION['utente_email']) || $_SESSION['utente_ruolo'] != 99) {
    header('Location: index.php');
    exit;
}
// tutti gli account
$sql = "SELECT a.email, a.password, u.nome, u.cognome, u.id_ruolo 
        FROM account a
        LEFT JOIN utenti u ON a.email = u.email
        ORDER BY a.email";

$result = $conn->query($sql);
$account = [];
while ($row = $result->fetch_assoc()) {
    $account[] = $row;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Account - CasaShop</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .account-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .account-table th, .account-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .account-table th {
            background: #333;
            color: white;
        }
        .account-table tr:hover {
            background: #f5f5f5;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">CasaShop</div>
        <div class="user-info">
            <span class="user-name"><?php echo htmlspecialchars($_SESSION['utente_nome'] . ' ' . $_SESSION['utente_cognome']); ?></span>
            <a href="php/logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <nav style="position: sticky; top: 0; z-index: 999;">
        <ul class="menu">
            <li><a href="gestione.php">← Torna a gestione</a></li>
        </ul>
    </nav>

    <main style="padding: 30px; max-width: 1000px; margin: 0 auto;">
        <h2>Gestione Account</h2>
        
        <table class="account-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Ruolo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($account as $acc): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($acc['email']); ?></td>
                        <td><code><?php echo htmlspecialchars($acc['password']); ?></code></td>
                        <td><?php echo htmlspecialchars($acc['nome'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($acc['cognome'] ?? '-'); ?></td>
                        <td><?php echo $acc['id_ruolo'] ?? '-'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>
</html>

<?php $conn->close(); ?>
