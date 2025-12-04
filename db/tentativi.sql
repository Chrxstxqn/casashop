-- aggiunge la colonna 'tentativi' alla tabella account per tracciare i tentativi di login falliti
ALTER TABLE `account`
    ADD COLUMN `tentativi` INT NOT NULL DEFAULT 0 AFTER `attivo`;

UPDATE `account` SET `tentativi` = 0;
