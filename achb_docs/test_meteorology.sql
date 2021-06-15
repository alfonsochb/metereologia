

CREATE DATABASE IF NOT EXISTS `test_meteorology`;
USE test_meteorology;


DROP TABLE IF EXISTS weather;


CREATE TABLE `weather` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `city_id` bigint(20) unsigned NOT NULL,
    `name` varchar(50) NOT NULL,
    `country` varchar(50) NOT NULL,
    `timezone` varchar(50) NOT NULL,
    `latitud` varchar(50) NOT NULL,
    `longitud` varchar(50) NOT NULL,
    `forecast` varchar(50) NOT NULL,
    `description` varchar(50) NOT NULL,
    `icon` varchar(50) NOT NULL,
    `temp` varchar(50) NOT NULL,
    `feels_like` varchar(50) NOT NULL,
    `temp_min` varchar(50) NOT NULL,
    `temp_max` varchar(50) NOT NULL,
    `pressure` varchar(50) NOT NULL,
    `humidity` varchar(50) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;