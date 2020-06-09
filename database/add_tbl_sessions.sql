CREATE TABLE IF NOT EXISTS `tbl_s_sessions` (
        `id` VARCHAR(128) NOT NULL,
        `ip_address` VARCHAR(45) NOT NULL,
        `timestamp` INT(10) UNSIGNED DEFAULT 0 NOT NULL,
        `data` BLOB NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
);

ALTER TABLE tbl_s_sessions ADD PRIMARY KEY (id, ip_address);