-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия на сървъра:            10.1.38-MariaDB - mariadb.org binary distribution
-- ОС на сървъра:                Win64
-- HeidiSQL Версия:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дъмп на структурата на БД xs_library
CREATE DATABASE IF NOT EXISTS `xs_library` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `xs_library`;

-- Дъмп структура за таблица xs_library.books
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_books_user_id__users_id` (`user_id`),
  CONSTRAINT `FK_books_user_id__users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Дъмп данни за таблица xs_library.books: ~3 rows (приблизително)
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
/*!40000 ALTER TABLE `books` ENABLE KEYS */;

-- Дъмп структура за таблица xs_library.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `is_admin` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Дъмп данни за таблица xs_library.users: ~4 rows (приблизително)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `active`, `is_admin`) VALUES
	(29, 'admin', 'admin', 'admin@abv.bg', '$argon2i$v=19$m=1024,t=2,p=2$b0NWZTkzSUdGNkJhcmkvQQ$qcPYS/LdSb++v7VfzhyiC1TJOB1a2vVxCaKX2IyQTTg', 1, 1),
	(30, 'user', 'user', 'user@abv.bg', '$argon2i$v=19$m=1024,t=2,p=2$QjBhQ2NTb0l5ZXY5TS96ag$5zfEelM9JHl8aG9Ww2u2mw9xL/KyW94K56LpQNEC7ZA', 1, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Дъмп структура за таблица xs_library.users_books
CREATE TABLE IF NOT EXISTS `users_books` (
  `book_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  KEY `FK1_users_books_book_id__books_id` (`book_id`),
  KEY `FK2_users_books_user_id__users_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Дъмп данни за таблица xs_library.users_books: ~4 rows (приблизително)
/*!40000 ALTER TABLE `users_books` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_books` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
