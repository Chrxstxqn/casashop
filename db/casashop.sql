-- --------------------------------------------------------
-- Host:                         localhost
-- Versione server:              10.4.18-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dump della struttura del database casashop
CREATE DATABASE IF NOT EXISTS `casashop` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `casashop`;

-- Dump della struttura di tabella casashop.account
CREATE TABLE IF NOT EXISTS `account` (
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.account: ~0 rows (circa)
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
/*!40000 ALTER TABLE `account` ENABLE KEYS */;

-- Dump della struttura di tabella casashop.attivita
CREATE TABLE IF NOT EXISTS `attivita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descrizione` varchar(100) NOT NULL,
  `pagina` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.attivita: ~8 rows (circa)
/*!40000 ALTER TABLE `attivita` DISABLE KEYS */;
INSERT INTO `attivita` (`id`, `descrizione`, `pagina`) VALUES
	(1, 'Aggiungi nuovo prodotto', 'nuovoprodotto.php'),
	(2, 'Elimina prodotto dal catalogo', 'eliminaprodotto.php'),
	(3, 'Modifica dati prodotto', 'modificaprodotto.php'),
	(9, 'Crea nuovo account ', 'creaaccount.php'),
	(10, 'Banna account', 'bannaaccount.php'),
	(11, 'Sblocca account', 'sbloccaaccount.php'),
	(12, 'Reset password utente', 'resetpassword.php'),
	(13, 'statistiche', 'statistiche.php'),
	(14, 'gestione novità', 'gestionenovita.php'),
	(15, 'Cronologia acquisti', 'cronologiaacquisti.php');
/*!40000 ALTER TABLE `attivita` ENABLE KEYS */;

-- Dump della struttura di tabella casashop.autorizzazioni
CREATE TABLE IF NOT EXISTS `autorizzazioni` (
  `id_ruolo` int(11) NOT NULL,
  `id_attivita` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_attivita`,`id_ruolo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.autorizzazioni: ~12 rows (circa)
/*!40000 ALTER TABLE `autorizzazioni` DISABLE KEYS */;
INSERT INTO `autorizzazioni` (`id_ruolo`, `id_attivita`) VALUES
	(3, 1),
	(99, 1),
	(3, 2),
	(99, 2),
	(3, 3),
	(99, 9),
	(99, 10),
	(99, 11),
	(99, 12),
	(2, 13),
	(2, 14),
	(1, 15);
/*!40000 ALTER TABLE `autorizzazioni` ENABLE KEYS */;

-- Dump della struttura di tabella casashop.categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.categorie: ~4 rows (circa)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `nome`) VALUES
	(1, 'Illuminazione'),
	(2, 'Tavoli'),
	(3, 'Specchi'),
	(4, 'Sedie');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Dump della struttura di tabella casashop.prodotti
CREATE TABLE IF NOT EXISTS `prodotti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `giacenza` int(11) NOT NULL,
  `prezzo_listino` float NOT NULL,
  `prezzo_scontato` float NOT NULL,
  `url_foto` varchar(150) NOT NULL COMMENT 'https://res.cloudinary.com/ddjdxpkki/image/upload/',
  `new` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.prodotti: ~11 rows (circa)
/*!40000 ALTER TABLE `prodotti` DISABLE KEYS */;
INSERT INTO `prodotti` (`id`, `nome`, `id_categoria`, `giacenza`, `prezzo_listino`, `prezzo_scontato`, `url_foto`, `new`) VALUES
	(1, 'Sedia scomodè', 4, 12, 34.99, 15, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763396969/sedia1_yncqps.webp', 1),
	(2, 'Specchio future', 3, 12, 34.99, 33, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763395854/specchio3_khf8uh.jpg', 0),
	(3, 'Tavolo panca', 2, 40, 7, 0, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763396501/tavolo2_ddy8bp.webp', 1),
	(4, 'Specchio vintage', 3, 8, 29.9, 0, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763395855/specchio4_ga0l9j.jpg', 0),
	(5, 'Specchio che rende belli', 3, 25, 12.5, 0, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763395854/specchio1_t01fpd.jpg', 0),
	(6, 'Lampada moderna', 1, 12, 99.99, 0, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763394333/lampada_xphc4u.jpg', 1),
	(7, 'Tavolo bello', 2, 1, 34.99, 0, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763393988/tavolo1_wd24e9.webp', 0),
	(8, 'Lampada rustica', 1, 22, 50.99, 0, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763394333/Lampada2_pqkp2l.jpg', 0),
	(9, 'Sedia modello barbiere', 4, 7, 33.99, 23.9, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763396969/sedia2_g5dctr.webp', 0),
	(10, 'Sedia manona', 4, 2, 115.5, 0, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763396970/sedia3_lneecw.webp', 1),
	(11, 'Lampada cobra', 1, 12, 28, 0, 'https://res.cloudinary.com/ddjdxpkki/image/upload/v1763397586/lampada3_zkpzd9.jpg', 1);
/*!40000 ALTER TABLE `prodotti` ENABLE KEYS */;

-- Dump della struttura di tabella casashop.ruoli
CREATE TABLE IF NOT EXISTS `ruoli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descrizione` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.ruoli: ~4 rows (circa)
/*!40000 ALTER TABLE `ruoli` DISABLE KEYS */;
INSERT INTO `ruoli` (`id`, `descrizione`) VALUES
	(2, 'responsabile marketing'),
	(3, 'incaricato data-entry'),
	(99, 'admin');
/*!40000 ALTER TABLE `ruoli` ENABLE KEYS */;

-- Dump della struttura di tabella casashop.utenti
CREATE TABLE IF NOT EXISTS `utenti` (
  `email` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `id_ruolo` int(11) DEFAULT NULL,
  PRIMARY KEY (`email`),
  KEY `FK_utenti_ruoli` (`id_ruolo`),
  CONSTRAINT `FK_utenti_ruoli` FOREIGN KEY (`id_ruolo`) REFERENCES `ruoli` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.utenti: ~6 rows (circa)
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` (`email`, `cognome`, `nome`, `id_ruolo`) VALUES
    ('schito.christian@shopcasa.com', 'Schito', 'Christian', NULL),
	('leuccialessio@shopcasa.com', 'Leucci', 'Alessio', 2),
	('montagna@gmail.com', 'Montagna', 'Fernando', NULL),
	('nunzio.galati@shopcasa.com', 'Galati', 'Nunzio', 99),
	('romano.enea@itismaglie.it', 'Romano', 'Enea', NULL),
	('tommaso.pulimeno@shopcasa.com', 'Pulimeno', 'Tommaso', 2);
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;