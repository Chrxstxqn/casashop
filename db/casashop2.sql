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

-- Dump dei dati della tabella casashop.account: ~24 rows (circa)
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` (`email`, `password`) VALUES
	('bello.lorenzo@itismaglie.it', '111'),
	('blanco.mattia@itismaglie.it', '222'),
	('bolognese.pierpaolo@itismaglie.it', '333'),
	('botrugno.moreno@itismaglie.it', '444'),
	('costantini.luca@itismaglie.it', '555'),
	('depascali.riccardo@itismaglie.it', '666'),
	('dimitri.lucapio@itismaglie.it', '777'),
	('giuseppe.degiorgi@shopcasa.com', '11111'),
	('greco.antonio@itismaglie.it', '888'),
	('ketta.antonio@itismaglie.it', '999'),
	('leucci.alessio@itismaglie.it', '101010'),
	('licci.federico@itismaglie.it', '111111'),
	('lici.klevis@itismaglie.it', '121212'),
	('ligori.sofia@itismaglie.it', '131313'),
	('maggiulli.glaucoangelo@itismaglie.it', '141414'),
	('montagna.fernando@itismaglie.it', '151515'),
	('nunzio.galati@shopcasa.com', '00000'),
	('palumbo.lorenzo@itismaglie.it', '161616'),
	('pulimeno.tommaso@itismaglie.it', '171717'),
	('romano.enea@itismaglie.it', '181818'),
	('ruggeri.emanuele@itismaglie.it', '191919'),
	('schito.christian@itismaglie.it', '202020'),
	('totaro.mariaelena@itismaglie.it', '212121'),
	('ventura.mattiapio@itismaglie.it', '222222');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;

-- Dump della struttura di tabella casashop.attivita
CREATE TABLE IF NOT EXISTS `attivita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descrizione` varchar(100) NOT NULL,
  `pagina` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.attivita: ~18 rows (circa)
/*!40000 ALTER TABLE `attivita` DISABLE KEYS */;
INSERT INTO `attivita` (`id`, `descrizione`, `pagina`) VALUES
	(1, 'Invia ordine', 'inviaordine.php'),
	(2, 'gestione novità', 'gestionenovita.php'),
	(3, 'Cronologia acquisti', 'cronologiaacquisti.php'),
	(4, 'Sblocca account', 'sbloccaaccount.php'),
	(10, 'Aggiungi nuovo prodotto', 'nuovoprodotto.php'),
	(11, 'Visualizza giacenze', 'visualizzagiacenze.php'),
	(12, 'Reset password utente', 'resetpassword.php'),
	(13, 'Statistiche', 'statistiche.php'),
	(16, 'Crea nuovo account ', 'creaaccount.php'),
	(17, 'Elimina prodotto dal catalogo', 'eliminaprodotto.php'),
	(18, 'Modifica dati prodotto', 'modificaprodotto.php'),
	(19, 'Reset password', 'resettapassword.php'),
	(20, 'Visualizza novità', 'visualizzanew.php'),
	(21, 'Aggiorna novità', 'aggiornanew.php'),
	(22, 'Effettua ordine', 'effettuaordine.php'),
	(23, 'Banna account', 'bannaaccount.php'),
	(24, 'Crea nuova categoria', 'creacategoria.php'),
	(25, 'Elimina categoria', 'eliminacategoria.php'),
	(26, 'Cambia nome categoria', 'cambianomecategoria.php'),
	(27, 'Applica sconto prodotto', 'applicascontoprodotto.php'),
	(28, 'Visualizza prodotti scontati', 'visualizzaprodottiscontati.php'),
	(29, 'Aggiungi attività', 'aggiungiattivita.php'),
	(30, 'Associa nuova attività ad un ruolo', 'associaattivitaruolo.php'),
	(31, 'Crea nuovo utente', 'creautente.php'),
	(32, 'Detemina valore magazzino', 'valoremagazzino.php');
/*!40000 ALTER TABLE `attivita` ENABLE KEYS */;

-- Dump della struttura di tabella casashop.autorizzazioni
CREATE TABLE IF NOT EXISTS `autorizzazioni` (
  `id_ruolo` int(11) NOT NULL,
  `id_attivita` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_attivita`,`id_ruolo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.autorizzazioni: ~11 rows (circa)
/*!40000 ALTER TABLE `autorizzazioni` DISABLE KEYS */;
INSERT INTO `autorizzazioni` (`id_ruolo`, `id_attivita`) VALUES
	(99, 1),
	(99, 2),
	(99, 3),
	(99, 4),
	(55, 10),
	(55, 11),
	(55, 12),
	(55, 13),
	(55, 14),
	(55, 15),
	(55, 16),
	(55, 17),
	(55, 18),
	(55, 19),
	(55, 20),
	(55, 21),
	(55, 22),
	(55, 23),
	(55, 24),
	(55, 25),
	(55, 26),
	(55, 27),
	(55, 28),
	(55, 29),
	(55, 30),
	(55, 31),
	(55, 32);
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
  `id_categoria` int(11) DEFAULT NULL,
  `giacenza` int(11) NOT NULL,
  `prezzo_listino` float NOT NULL,
  `prezzo_scontato` float NOT NULL,
  `url_foto` varchar(150) DEFAULT NULL COMMENT 'https://res.cloudinary.com/ddjdxpkki/image/upload/',
  `new` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_prodotti_categorie` (`id_categoria`),
  CONSTRAINT `FK_prodotti_categorie` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella casashop.ruoli: ~5 rows (circa)
/*!40000 ALTER TABLE `ruoli` DISABLE KEYS */;
INSERT INTO `ruoli` (`id`, `descrizione`) VALUES
	(1, 'cliente'),
	(2, 'responsabile marketing'),
	(3, 'incaricato data-entry'),
	(55, 'tirocinante'),
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

-- Dump dei dati della tabella casashop.utenti: ~24 rows (circa)
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` (`email`, `cognome`, `nome`, `id_ruolo`) VALUES
	('bello.lorenzo@itismaglie.it', 'Bello', 'Lorenzo', 55),
	('blanco.mattia@itismaglie.it', 'Blanco', 'Mattia', 55),
	('bolognese.pierpaolo@itismaglie.it', 'Bolognese', 'Pierpaolo', 55),
	('botrugno.moreno@itismaglie.it', 'Botrugno', 'Moreno', 55),
	('costantini.luca@itismaglie.it', 'Costantini', 'Luca', 55),
	('depascali.riccardo@itismaglie.it', 'De Pascali ', 'Riccardo', 55),
	('dimitri.lucapio@itismaglie.it', 'Dimitri', 'Luca Pio', 55),
	('giuseppe.degiorgi@shopcasa.com', 'De Giorgi', 'Giuseppe', 99),
	('greco.antonio@itismaglie.it', 'Greco', 'Antonio', 55),
	('ketta.antonio@itismaglie.it', 'Ketta', 'Antonio', 55),
	('leucci.alessio@itismaglie.it', 'Leucci', 'Alessio', 55),
	('licci.federico@itismaglie.it', 'Licci', 'Federico', 55),
	('lici.klevis@itismaglie.it', 'Lici', 'Klevis', 55),
	('ligori.sofia@itismaglie.it', 'Ligori', 'Sofia', 55),
	('maggiulli.glaucoangelo@itismaglie.it', 'Maggiulli', 'Glauco Angelo', 55),
	('montagna.fernando@itismaglie.it', 'Montagna', 'Fernando', 55),
	('nunzio.galati@shopcasa.com', 'Galati', 'Nunzio', 99),
	('palumbo.lorenzo@itismaglie.it', 'Palumbo', 'Lorenzo', 55),
	('pulimeno.tommaso@itismaglie.it', 'Pulimeno', 'Tommaso', 55),
	('romano.enea@itismaglie.it', 'Romano', 'Enea', 55),
	('ruggeri.emanuele@itismaglie.it', 'Ruggeri', 'Emanuele', 55),
	('schito.christian@itismaglie.it', 'Schito', 'Christian', 55),
	('totaro.mariaelena@itismaglie.it', 'Totaro', 'Maria Elena', 55),
	('ventura.mattiapio@itismaglie.it', 'Ventura', 'Mattia Pio', 55);
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;