-- Crea la tabella dei preferiti per associare account -> prodotti
CREATE TABLE IF NOT EXISTS `preferiti` (
  `email` varchar(50) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  PRIMARY KEY (`email`,`id_prodotto`),
  KEY `FK_preferiti_prodotti` (`id_prodotto`),
  CONSTRAINT `FK_preferiti_utenti` FOREIGN KEY (`email`) REFERENCES `account` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
