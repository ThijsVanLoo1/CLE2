-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 17 jan 2025 om 13:34
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
  `week_id` int NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reservations`
--

INSERT INTO `reservations` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `comment`, `user_id`, `week_id`, `date`, `start_time`, `end_time`) VALUES
(8, 'Thijs', 'van Loo', 'thijs30042002@gmail.com', '0614139781', 'Hey Jordi, alles kits achter die rits?', 1, 1, '2025-01-14', '14:10:00', '14:20:00'),
(9, 'Thijs', 'van Loo', 'thijs30042002@gmail.com', '0614139781', 'Hey Jordi, alles kits achter die rits? Ik ga nu een tweede verhaal schrijven, want als het goed is wordt deze tekst nu wel correct ingevoegd zonder dat de flexbox aan de rechterkant door de hele pagina worden geyeet. Hopelijk werkt dit wel, maar als je dit leest werkt het dus anders laat ik het niet zien aan je. Succes vandaag!', 4, 1, '2025-01-14', '14:00:00', '14:10:00'),
(10, 'Jordi', 'Biever', '1102000@hr.nl', '0682510263', 'Yoo', 1, 1, '2025-01-21', '12:50:00', '13:00:00'),
(11, 'Sjoerd', 'Vroegindeweij', 'sjoerd2000XD@hr.nl', '0642042069', 'Waddup', 4, 1, '2025-02-05', '14:10:00', '14:20:00'),
(12, 'Henk', '3de', 'l@l.nl', '061215151', 'k', 1, 1, '2025-02-03', '14:30:00', '14:40:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `admin_key` tinyint(1) NOT NULL,
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
(4, 0, 'jordi', 'biever', '$2y$10$p0H5dQRNBM5aRV0eCI1j.uDfA6/Yo.i6zBCXPNroUEymm.fSlJNRS', 'jordi1030@outlook.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_reservation`
--

CREATE TABLE `user_reservation` (
  `user_id` int NOT NULL,
  `reservation_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user_reservation`
--

INSERT INTO `user_reservation` (`user_id`, `reservation_id`) VALUES
(4, 11),
(1, 12);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `weeks`
--

CREATE TABLE `weeks` (
  `id` int NOT NULL,
  `week_number` int NOT NULL,
  `day_1` date NOT NULL,
  `day_2` date NOT NULL,
  `day_3` date NOT NULL,
  `day_4` date NOT NULL,
  `day_5` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `weeks`
--

INSERT INTO `weeks` (`id`, `week_number`, `day_1`, `day_2`, `day_3`, `day_4`, `day_5`) VALUES
(1, 6, '2025-02-03', '2025-02-04', '2025-02-05', '2025-02-06', '2025-02-07'),
(2, 13, '2025-03-24', '2025-03-25', '2025-03-26', '2025-03-27', '2025-03-28'),
(3, 27, '2025-06-30', '2025-07-01', '2025-07-02', '2025-07-03', '2025-07-04'),
(4, 28, '2025-07-07', '2025-07-08', '2025-07-09', '2025-07-10', '2025-07-11');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `week_id` (`week_id`) USING BTREE;

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `weeks`
--
ALTER TABLE `weeks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `id` FOREIGN KEY (`week_id`) REFERENCES `weeks` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Beperkingen voor tabel `user_reservation`
--
ALTER TABLE `user_reservation`
  ADD CONSTRAINT `user_reservation_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_reservation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
