# CasaShop

Progetto per la verifica informatica: Backend, autenticazione e gestione utenti.

**Autore:** Christian Schito

## Descrizione

CasaShop è un'applicazione web PHP per la gestione di un catalogo di accessori per la casa con sistema di autenticazione e pannello amministrativo.

## Funzionalità

- ✅ **Autenticazione utenti** con email e password
- ✅ **Sistema di ruoli e autorizzazioni** (Admin, Data Entry, Marketing)
- ✅ **Gestione prodotti** per categoria
- ✅ **Pannello amministrativo** con attività autorizzate per ruolo
- ✅ **Sessioni PHP** sicure
- ✅ **Query centralizzate** in file separato

## Struttura del Progetto

```
casashop/
├── index.php                 # Pagina principale (catalogo prodotti)
├── account.php               # Gestione account (admin only)
├── .gitignore                # File da ignorare in Git
├── README.md                 # Questo file
├── css/
│   └── style.css             # Stili globali
├── db/
│   ├── casashop.sql          # Dump del database
│   └── inserisci_account.sql # Script per aggiungere account di test
├── js/
│   └── (file JavaScript)
└── php/
    ├── connessione.php              # Connessione al database (NOT versionata)
    ├── connessione.example.php      # Esempio di configurazione
    ├── autentica.php                # Elaborazione login
    ├── logout.php                   # Logout
    ├── gestione.php                 # Pannello admin
    ├── queries.php                  # Query centralizzate
    └── (altri file PHP)
```

## Installazione

### 1. Clonare il repository
```bash
git clone https://github.com/Chrxstxqn/casashop.git
cd casashop
```

### 2. Configurare il database
```bash
mysql -u root < db/casashop.sql
mysql -u root casashop < db/inserisci_account.sql
```

### 3. Configurare la connessione
```bash
cp php/connessione.example.php php/connessione.php
```

Modifica `php/connessione.php` con i tuoi parametri MySQL:
```php
$host = 'localhost';
$user = 'root';        // Il tuo utente MySQL
$password = '';        // La tua password MySQL
$database = 'casashop';
```

### 4. Avviare il server
```bash
php -S localhost:8000
```

Accedi a: `http://localhost:8000`

## Credenziali di Test

Dopo aver eseguito `inserisci_account.sql`, puoi usare:

| Email | Password | Ruolo |
|-------|----------|-------|
| admin@shopcasa.com | admin123 | Admin |
| user@shopcasa.com | password123 | Marketing |
| user@gmail.com | password123 | Nessuno |

## Utilizzo

### 1. Accedi al negozio
- Visita `http://localhost:8000`
- Compila il form di login

### 2. Visualizza il pannello admin
- Se loggato: clicca su "Gestione"
- Vedrai le attività autorizzate al tuo ruolo

### 3. Gestione account (admin only)
- Accedi come admin (`admin@shopcasa.com`) 
- Visita `account.php` per vedere tutti gli account

## Tecnologie

- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3
- **Versioning:** Git

## Sicurezza

⚠️ **Note importanti:**
- Le password sono salvate in chiaro
- Il file `php/connessione.php` è escluso da Git (contiene credenziali)

## API Disponibili

### Query centralizzate (in `php/queries.php`)

```php
getAttivitaByEmail($conn, $email)      // Attività autorizzate per utente
getProdotti($conn, $categoria)         // Prodotti per categoria
getCategorie($conn)                    // Tutte le categorie
getAccount($conn)                      // Tutti gli account
```

## Licenza

Progetto scolastico - Verifica informatica

## Contatti

Autore: Christian Schito

---

**Ultima modifica:** Dicembre 2025
