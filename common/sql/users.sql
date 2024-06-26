CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT 'NOT NULL UNIQUE',
  `password` varchar(255) NOT NULL DEFAULT 'NOT NULL',
  `name` varchar(100) DEFAULT NULL,
  `imageURL` varchar(255) DEFAULT NULL,
  `type` int NOT NULL COMMENT 'user: 0, admin: 1',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);