SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `groups` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `imageURL` varchar(255),
  `createdAt` datetime NOT NULL DEFAULT NOW(),
  `updatedAt` datetime NOT NULL DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `groups` AUTO_INCREMENT=12;

COMMIT;