CREATE TABLE `reports` (
  `report_id` int PRIMARY KEY AUTO_INCREMENT,
  `reporter_id` int NOT NULL,
  `reported_id` int NOT NULL,
  `report` text,
  `created_at` timestamp NULL DEFAULT NOW(),
  KEY `reporter_id` (`reporter_id`),
  KEY `reported_id` (`reported_id`),
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`),
  CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`reported_id`) REFERENCES `users` (`id`)
);
