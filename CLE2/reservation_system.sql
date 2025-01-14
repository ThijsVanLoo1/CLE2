-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 14 jan 2025 om 08:49
-- Serverversie: 8.4.2
-- PHP-versie: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservation_system`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reservations`
--

CREATE TABLE `reservations` (
                                `id` int NOT NULL,
                                `first_name` varchar(50) NOT NULL,
                                `last_name` varchar(50) NOT NULL,
                                `email` varchar(256) NOT NULL,
                                `phone_number` varchar(20) NOT NULL,
                                `comment` varchar(1000) NOT NULL,
                                `user_id` int NOT NULL,
                                `date` date NOT NULL,
                                `time_slot` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reservations`
--

INSERT INTO `reservations` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `comment`, `user_id`, `date`, `time_slot`) VALUES
                                                                                                                                     (1, 'Henk', 'Worst', 'henk@worst.nl', '0812456359', 'henk', 4, '2025-04-01', '14:45:00'),
                                                                                                                                     (2, 'Henk', 'Worst', 'henk@worst.nl', '0812456359', 'henk', 1, '2025-04-01', '14:45:00'),
                                                                                                                                     (3, 'Pete', 'Worst', 'Pete@worst.nl', '0812456358', 'Pete', 4, '2025-04-01', '15:00:00'),
                                                                                                                                     (4, 'j', 'j', 'j@j.nl', '08133333', 'j', 1, '2025-01-10', '20:00:00'),
                                                                                                                                     (5, 'j', 'b', 'j@j.nl', '081222222', 'j', 1, '2025-02-11', '20:00:00'),
                                                                                                                                     (6, 'j', 'b', 'j@j.nl', '09', 'k', 1, '2025-01-10', '20:00:00'),
                                                                                                                                     (7, 'j', 'b', 'j@j.nl', '09', 'k', 1, '2025-01-10', '20:00:00'),
                                                                                                                                     (8, 'Chayenne', 'Rademaker', 'chayenneisabela@gmail.com', '112', 'pelippers zijn lief', 1, '2025-02-12', '20:00:00'),
                                                                                                                                     (9, 'j', 'j', 'jordi1030@outlook.com', '6', '2', 4, '2025-02-10', '20:00:00'),
                                                                                                                                     (10, 'j', 'b', 'L@l.nl', '5646588', 'henk', 1, '2025-01-10', '20:00:00'),
                                                                                                                                     (11, 'j', 'b', 'j@j.nl', '5', 'j', 1, '2025-01-10', '20:00:00'),
                                                                                                                                     (12, 'j', 'lk', 'l@l.nl', '5', 'j', 1, '2025-02-11', '20:00:00'),
                                                                                                                                     (13, 'j', 'b', 'j@j.nl', '2', '2', 1, '2025-01-11', '20:00:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
                         `id` int NOT NULL,
                         `admin_key` tinyint(1) DEFAULT NULL,
                         `first_name` varchar(50) NOT NULL,
                         `last_name` varchar(50) NOT NULL,
                         `password` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                         `email` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `admin_key`, `first_name`, `last_name`, `password`, `email`) VALUES
                                                                                            (1, 1, 'Thijs', 'van Loo', '$2y$10$GzNgwLhDH7rrzo4G/IIVdex1XlmTYcE21daHWLoZ5LIqK9qxs2Ig6', '1101318@hr.nl'),
                                                                                            (4, NULL, 'jordi', 'biever', '$2y$10$p0H5dQRNBM5aRV0eCI1j.uDfA6/Yo.i6zBCXPNroUEymm.fSlJNRS', 'jordi1030@outlook.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_reservation`
--

CREATE TABLE `user_reservation` (
                                    `user_id` int NOT NULL,
                                    `reservation_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `weeks`
--

CREATE TABLE `weeks` (
                         `week_id` int NOT NULL,
                         `day_1` date NOT NULL,
                         `day_2` date NOT NULL,
                         `day_3` date NOT NULL,
                         `day_4` date NOT NULL,
                         `day_5` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `weeks`
--

INSERT INTO `weeks` (`week_id`, `day_1`, `day_2`, `day_3`, `day_4`, `day_5`) VALUES
                                                                                 (1, '2025-01-10', '2025-01-11', '2025-01-12', '2025-01-13', '2025-01-14'),
                                                                                 (2, '2025-02-10', '2025-02-11', '2025-02-12', '2025-02-13', '2025-02-14'),
                                                                                 (3, '2025-03-10', '2025-03-11', '2025-03-12', '2025-03-13', '2025-03-14'),
                                                                                 (4, '2025-04-10', '2025-04-11', '2025-04-12', '2025-04-13', '2025-04-14');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `week_reservation`
--

CREATE TABLE `week_reservation` (
                                    `week_id` int NOT NULL,
                                    `reservation_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `reservations`
--
ALTER TABLE `reservations`
    ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user_reservation`
--
ALTER TABLE `user_reservation`
    ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `weeks`
--
ALTER TABLE `weeks`
    ADD PRIMARY KEY (`week_id`);

--
-- Indexen voor tabel `week_reservation`
--
ALTER TABLE `week_reservation`
    ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `week_id` (`week_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `reservations`
--
ALTER TABLE `reservations`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `weeks`
--
ALTER TABLE `weeks`
    MODIFY `week_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `user_reservation`
--
ALTER TABLE `user_reservation`
    ADD CONSTRAINT `user_reservation_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_reservation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Beperkingen voor tabel `week_reservation`
--
ALTER TABLE `week_reservation`
    ADD CONSTRAINT `week_reservation_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `week_reservation_ibfk_2` FOREIGN KEY (`week_id`) REFERENCES `weeks` (`week_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
