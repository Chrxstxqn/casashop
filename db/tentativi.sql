-- 1. Aggiunge la colonna 'attivo' se non esiste
ALTER TABLE `account`
    ADD COLUMN `attivo` TINYINT(1) NOT NULL DEFAULT 1;

-- 2. Aggiunge la colonna 'tentativi'
ALTER TABLE `account`
    ADD COLUMN `tentativi` INT NOT NULL DEFAULT 0 AFTER `attivo`;

-- 3. Inizializza i tentativi a 0 (per sicurezza)
UPDATE `account`
    SET `tentativi` = 0;
