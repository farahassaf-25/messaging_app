SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `unique_id` int(255),
  `status` varchar(255),
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `name` varchar(100),
  `lname` varchar(100),
  `imageURL` varchar(255),
  `type` int NOT NULL DEFAULT 0
    COMMENT 'user: 0, admin: 1',
  `createdAt` timestamp NOT NULL DEFAULT NOW(),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `email`, `password`, `name`, `imageURL`, `type`, `createdAt`) VALUES
(1, 'admin@gmail.com', '$2y$10$Alx08vO.7NgAzuqHw6tXwOnfAAW4sD0jzczZwpkXBcdSG8lydxZBy', 'admin', NULL, 1, '2024-06-14 12:39:15'),
(2, 'user@gmail.com', '$2y$10$rVlAuGQd0.9PfiW5bpT.sOwGhJTU7pohJI8y6uVjgOtc13qGWahhC', 'user', NULL, 0, '2024-06-14 12:53:48'),
(3, 'usertwo@gmail.com', '$2y$10$JMl0nOgCaVZisb9QcU5hlOalJmGVaugvx81zV5MgUu2VDyKY0G1Dy', 'usertwo', NULL, 0, '2024-06-14 12:55:36');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

--- Dummy data if needed:
INSERT INTO users(email, password, name, imageURL, type) VALUES
('john.doe@example.com', 'password123', 'John Doe', 'https://cataas.com/cat?bust=963.2623511955723&width=64&height=64', 0),
('jane.smith@example.com', 'pass456', 'Jane Smith', 'https://cataas.com/cat?bust=349.22812259684144&width=64&height=64', 0),
('bob.johnson@example.com', 'letmein', 'Bob Johnson', 'https://cataas.com/cat?bust=856.3535901311353&width=64&height=64', 0),
('emily.davis@example.com', 'qwerty', 'Emily Davis', 'https://cataas.com/cat?bust=234.08361359879711&width=64&height=64', 0),
('michael.wilson@example.com', 'ilovecats', 'Michael Wilson', 'https://cataas.com/cat?bust=601.3573283342247&width=64&height=64', 0),
('susan.anderson@example.com', 'catsrule', 'Susan Anderson', 'https://cataas.com/cat?bust=304.53583160837724&width=64&height=64', 0),
('david.thomas@example.com', 'catlover', 'David Thomas', 'https://cataas.com/cat?bust=718.607203772857&width=64&height=64', 0),
('lisa.jackson@example.com', 'meow123', 'Lisa Jackson', 'https://cataas.com/cat?bust=679.4285547727985&width=64&height=64', 0),
('steve.white@example.com', 'catlady', 'Steve White', 'https://cataas.com/cat?bust=241.3211932790663&width=64&height=64', 0),
('amanda.martin@example.com', 'kittycat', 'Amanda Martin', 'https://cataas.com/cat?bust=168.32033281058105&width=64&height=64', 1),
('kevin.garcia@example.com', 'purrfect', 'Kevin Garcia', 'https://cataas.com/cat?bust=117.63811494935128&width=64&height=64', 0),
('olivia.miller@example.com', 'catnip', 'Olivia Miller', 'https://cataas.com/cat?bust=83.22960704865828&width=64&height=64', 1),
('ryan.wilson@example.com', 'felinefan', 'Ryan Wilson', 'https://cataas.com/cat?bust=63.23372112888258&width=64&height=64', 0),
('elizabeth.moore@example.com', 'whiskers', 'Elizabeth Moore', 'https://cataas.com/cat?bust=66.47981523208303&width=64&height=64', 0),
('daniel.taylor@example.com', 'meowmeow', 'Daniel Taylor', 'https://cataas.com/cat?bust=142.6979435074124&width=64&height=64', 0),
('sophia.anderson@example.com', 'pawsome', 'Sophia Anderson', 'https://cataas.com/cat?bust=514.0503025744579&width=64&height=64', 1),
('matthew.thomas@example.com', 'catwhisperer', 'Matthew Thomas', 'https://cataas.com/cat?bust=142.15771308369722&width=64&height=64', 0),
('emma.johnson@example.com', 'catalicious', 'Emma Johnson', 'https://cataas.com/cat?bust=168.63768842875743&width=64&height=64', 0),
('jacob.wilson@example.com', 'furball', 'Jacob Wilson', 'https://cataas.com/cat?bust=416.71533362634045&width=64&height=64', 0),
('olivia.davis@example.com', 'meowmix', 'Olivia Davis', 'https://cataas.com/cat?bust=577.663633579075&width=64&height=64', 0);