-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 09. Mai 2019 um 11:54
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `hopfenspeicher`
--
CREATE DATABASE IF NOT EXISTS `hopfenspeicher` DEFAULT CHARACTER SET utf8 COLLATE utf8_german2_ci;
USE `hopfenspeicher`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beers`
--
-- Erstellt am: 04. Mai 2019 um 08:20
--

DROP TABLE IF EXISTS `beers`;
CREATE TABLE `beers` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_german2_ci NOT NULL,
  `brewery_id` int(11) NOT NULL,
  `description` text COLLATE utf8_german2_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `alcstrength` decimal(4,2) NOT NULL,
  `image` varchar(255) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `beers`:
--   `brewery_id`
--       `brewerys` -> `id`
--   `type_id`
--       `types` -> `id`
--

--
-- Daten für Tabelle `beers`
--

INSERT INTO `beers` (`id`, `name`, `brewery_id`, `description`, `type_id`, `alcstrength`, `image`) VALUES
(1, 'Bitburger Premium Pils', 7, 'Vollendeter hopfenbetonter Pilsgenuss kombiniert mit Leichtigkeit und Eleganz, dazu ein kristallklares, sonniges Strohgelb und ein anhaltender, feinporiger Schaum: Seit fast zwei Jahrhunderten nur aus besten Rohstoffen nach deutschem Reinheitsgebot gebraut, überzeugt unser Bitburger Premium Pils nicht ohne Grund als das meistgezapfte Bier Deutschlands. Sein fassfrischer Geschmack macht unser Premium Bier so beliebt. ', 1, '4.80', 'bitburger.png'),
(2, 'Bitburger Leichtes', 7, 'Gleiche Rezeptur, bewährter Geschmack: Bitburger Light heißt jetzt Bitburger Leichtes. Das frische Schankbier überzeugt mit der Fruchtigkeit, Würze sowie dem einzigartigen Geschmack der Bitburger Premium Biere. 30 % weniger Kalorien und 40 % weniger Alkohol als ein herkömmliches Pilsener mit 4,8 % vol, dafür mit 100 % vollmundigem Biergeschmack: Genuss kann so leicht sein.', 1, '2.80', 'bitburgerleicht.png'),
(3, 'Veltins Pilsener', 1, 'Der Duft verspricht ein erfrischendes und geschmackvolles Erlebnis', 1, '4.80', 'veltinspils.png'),
(4, 'Oettinger Pils', 3, 'OETTINGER Pils schmeckt feinherb und sortentypisch - wie ein Pils eben. NULL EXTRAS. Ganz klassisch. Bier nach Pilsener Brauart ist ein untergäriges Bier. Es ist etwas stärker gehopft und damit ein wenig herber als andere Vollbiere. Vielleicht ist es deshalb die beliebteste Biersorte in Deutschland.', 1, '4.70', 'oetti.jpg'),
(5, 'Veltins V+ BERRY-X', 1, 'V+ Berry-X ist der Biermix, dessen Geschmack sich an die trendigen Fruity-Energydrinks anlehnt', 3, '2.50', '03e9f8c18ee4f992b839272b0b7fbba3cc88fa78-veltinsvberry.png'),
(6, 'Oettinger Alkoholfrei', 3, 'Durst wird durch Bier erst schön, sagt ein Sprichwort. Toll, wenn beim Löschen weder Alkohol noch Kalorien eine Rolle spielen. Das OETTINGER Alkoholfrei ist ein feinherbes Schankbier mit geringerem Kaloriengehalt. Gut gekühlt, erfrischt es bei vollem Aroma und verlässlicher Schaumkrone.\r\nGepflegter Biergenuss. NULL GRUPPENZWANG.', 6, '0.00', '4f552d20fc6ae93102903ba5108302a70d046d8c-oettialkoholfrei.jpg'),
(7, 'Weißbier-Zitrone Naturtrüb', 8, 'Als \"RUSS\" hat dieser klassische Durstlöscher im bayerischen Biergarten schon lange seinen Stammplatz. Jetzt gibt es ihn fertig gemischt im genau richtigen Verhältnis von bestem Paulaner Hefe-Weißbier und natürlicher Zitronenlimonade. Naturtrüb, mattgolden, zitronig herb-süßlich mit einem Hauch Mandarine. Man nehme Tradition, Genuss und Leichtigkeit - und schon erhält man das Lieblingsgetränk des Sommers. Eine herrliche Erfrischung und dabei vollkommen natürlich.', 2, '2.70', 'e5cabc070cdd2589a44de26b441292c0fbe752de-weifbier-zitrone-naturtrueb_web_1000x1550px.png'),
(8, 'Asahi Super Dry', 10, 'Ein süffiges Lagerbier aus Japan mit einem feinen Schaum und einem blumigen Duft. Hergestellt von der gleichnamigen Brauerei.', 7, '5.00', 'fe138262937c3bd2739f0aa20ed1ce20b58fb441-asahi.png'),
(9, 'Krombacher naturtrübes Kellerbier', 2, 'Die natürliche Trübung verleiht dieser besonderen Bier-Spezialität ihren vollmundigen Geschmack und den ursprünglich kräftigen und unverwechselbaren bierigen Charakter für besondere Genussmomente.', 4, '5.10', 'fefbf2b54031ada3815d0ded0dea8e6b9d4ecb05-krombacherkeller.jpg'),
(10, 'Krombacher Radler', 2, 'Feinherber Pilsgeschmack und spritzige Zitronenlimonade ergänzen sich perfekt zu einem erfrischenden Geschmackserlebnis.', 3, '2.50', '74993d6918056bf4154bd15be8f8c7694202c66e-krombacherradler.png'),
(11, 'Oettinger Export', 3, 'Warum in die Ferne schweifen? Export kann man auch gut zuhause trinken. Unser Untergäriges ist vollmundig und kräftig im Geschmack. Das liegt an den großzügig bemessenen Inhaltsstoffen. Streng kontrolliert, selbstverständlich. Bereits unsere Vorfahren haben Bier exportiert. Damit es unterwegs ohne Kühlung haltbar blieb, braute man es mit einem höheren Malzgehalt stärker ein. NULL RISIKO. 100% transporttauglich.\r\nWir Bierbrauer waren eben schon immer sehr erfinderisch.', 8, '5.40', '2c7203e8e6ab896e5cbcfe550b1965372ef1259b-oettiexport.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beers_ingredients`
--
-- Erstellt am: 04. Mai 2019 um 08:20
--

DROP TABLE IF EXISTS `beers_ingredients`;
CREATE TABLE `beers_ingredients` (
  `beer_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `beers_ingredients`:
--   `beer_id`
--       `beers` -> `id`
--   `ingredient_id`
--       `ingredients` -> `id`
--

--
-- Daten für Tabelle `beers_ingredients`
--

INSERT INTO `beers_ingredients` (`beer_id`, `ingredient_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(3, 1),
(3, 2),
(3, 3),
(3, 5),
(4, 1),
(4, 2),
(4, 3),
(4, 5),
(5, 1),
(5, 2),
(5, 3),
(5, 5),
(5, 7),
(6, 1),
(6, 2),
(6, 3),
(6, 5),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 10),
(8, 1),
(8, 2),
(8, 3),
(8, 5),
(9, 1),
(9, 2),
(9, 3),
(9, 5),
(10, 1),
(10, 2),
(10, 3),
(10, 9),
(11, 1),
(11, 2),
(11, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `brewerys`
--
-- Erstellt am: 04. Mai 2019 um 08:20
--

DROP TABLE IF EXISTS `brewerys`;
CREATE TABLE `brewerys` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `brewerys`:
--

--
-- Daten für Tabelle `brewerys`
--

INSERT INTO `brewerys` (`id`, `name`) VALUES
(1, 'Veltins Brauerei'),
(2, 'Krombacher'),
(3, 'Oettinger'),
(4, 'Heineken N. V.'),
(5, 'Radeberger Gruppe'),
(6, 'Carlsberg A/S'),
(7, 'Bitburger Holding'),
(8, 'Paulaner Gruppe'),
(9, 'Warsteiner Brauerei'),
(10, 'Asahi Beer'),
(11, 'Franziskaner Brauerei');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `errors`
--
-- Erstellt am: 04. Mai 2019 um 08:20
--

DROP TABLE IF EXISTS `errors`;
CREATE TABLE `errors` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_german2_ci NOT NULL,
  `content` text COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `errors`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ingredients`
--
-- Erstellt am: 04. Mai 2019 um 08:20
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `ingredients`:
--

--
-- Daten für Tabelle `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`) VALUES
(1, 'Wasser'),
(2, 'Hopfen'),
(3, 'Gerstenmalz'),
(4, 'Zitrone'),
(5, 'Hefe'),
(6, 'Cola'),
(7, 'Energy'),
(8, 'Fanta'),
(9, 'Sprite'),
(10, 'Weizenmalz');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reviews`
--
-- Erstellt am: 04. Mai 2019 um 08:20
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `beer_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_german2_ci NOT NULL,
  `content` text COLLATE utf8_german2_ci NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rating` tinyint(4) NOT NULL,
  `hasChanged` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `reviews`:
--

--
-- Daten für Tabelle `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `beer_id`, `title`, `content`, `timestamp`, `rating`, `hasChanged`) VALUES
(1, 3, 2, 'Es hält was es verspricht', 'Da löppt der Lachs, aber er löppt nicht zu sehr.', '2019-05-03 18:44:30', 8, 0),
(2, 7, 4, '[MC Donald\'s Slogan]', 'Nur 9 Kronkorken, weil es immer so schnell leer ist.', '2019-05-03 15:30:13', 9, 0),
(3, 6, 3, 'Ein gutes DEUTSCHES Bier', 'Schön nach den Reinheitsgebot gebraut.', '2019-05-03 15:23:20', 10, 0),
(4, 1, 3, 'Was ein Müll', 'Oettinger ist viel besser', '2019-05-03 14:18:04', 1, 0),
(5, 2, 4, 'Das Beste!', 'Ich würde 11 Kronkorken geben wenn ich könnte!', '2019-05-03 14:47:42', 10, 0),
(6, 2, 3, 'Ganz okay', 'Ist gut, aber nicht mehr', '2019-05-03 14:48:17', 5, 0),
(8, 5, 3, 'Dufte', 'Ich mag diese Bier.', '2019-05-03 15:31:06', 10, 0),
(9, 4, 5, 'Ganz lecker', 'V+ erinnert mich immer an meine Jugend', '2019-05-03 15:17:01', 8, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `types`
--
-- Erstellt am: 04. Mai 2019 um 08:20
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `types`:
--

--
-- Daten für Tabelle `types`
--

INSERT INTO `types` (`id`, `name`) VALUES
(1, 'Pilsener'),
(2, 'Weizen'),
(3, 'Mischbier'),
(4, 'Kellerbier'),
(5, 'Altbier'),
(6, 'alkoholfreies Bier'),
(7, 'Lager'),
(8, 'Export');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--
-- Erstellt am: 04. Mai 2019 um 08:20
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_german2_ci NOT NULL,
  `username` varchar(32) COLLATE utf8_german2_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_german2_ci NOT NULL,
  `password` text COLLATE utf8_german2_ci NOT NULL,
  `firstname` varchar(64) COLLATE utf8_german2_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8_german2_ci NOT NULL,
  `description` text COLLATE utf8_german2_ci NOT NULL,
  `passwordcode` varchar(255) COLLATE utf8_german2_ci NOT NULL,
  `favbeer_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `users`:
--

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `image`, `username`, `email`, `password`, `firstname`, `lastname`, `description`, `passwordcode`, `favbeer_id`, `timestamp`) VALUES
(1, '8716ca621dbaf4b217ca6031b83678c0f0f58a89-im_hungry-wallpaper-1920x1080.jpg', 'JulianSchmidtke', 'julianschmidtke1998@gmail.com', '$2y$10$tZUkteLqMP2sPfQJd78JMeOYNEOSab1T7LwGeSVux8SsR.S3ReplC', 'Julian', 'Schmidtke', 'Ich bin der Julian und ich mag Bier', '', 3, '2019-05-02 07:11:29'),
(2, '6177d94c655852bcae8c93a98560ce73e2a38c08-game_of_thrones_season_8_2019_jon_snow___kit_harington-wallpaper-2880x1620.jpg', 'Deinfalt', 'dominik.einfalt@hsw-stud.de', '$2y$10$CD7TYvo7KdTZ6va/yq17yOLywOnl1mjwJG0WEPi1eukZ/VUSF.bqm', 'Dominik', 'Einfalt', 'Morgens, Mittags, Abends ich will saufen und pupsen!', '', 4, '2019-05-01 11:29:25'),
(3, '830ab8c961e5290b67e39928673b9dde8d93100e-henne.jpg', 'Henne', 'henne.diehenne@hsw-stud.de', '$2y$10$4GwiCgoy3K3ju3jmlK649OVJQRWfzSIX/Th9Rx3J9HeX4shuvEGKK', 'Henrik', 'Garitz', 'Ich hab kein Lieblingsbier. Ich mag Essacher Luft!', '', 0, '2019-05-02 16:24:17'),
(4, 'fef198f3a2f2a8abd8cafe62080225ff57f0daa9-ford_gt_yellow-wallpaper-3840x2160.jpg', 'Hännes', 'random@email.com', '$2y$10$oP4SuzQrOCvM6J99lvBJR.qhzNiVHzVvXlYbhriTIbZu81oudE4bO', 'Hannes', 'Keßling', 'Bier ist toll!', '', 0, '2019-05-02 16:24:57'),
(5, '6b9c04b4872e4b13d78da7664c708561aee3ffec-wanna_beer-wallpaper-3840x2160.jpg', 'Mäxchen', 'max@mustermann.info', '$2y$10$cwlaQmP9ePuTOW.IgxOHTOmBnwITMsxcVe1/qw2AbXGtvHv/ZJvhq', 'Max', 'Mustermann', '', '', 4, '2019-05-02 16:28:57'),
(6, '9d6493fdca41d8d4a4a8fb100d15c43b3adcdd69-german_woman_drinking_beer-wallpaper-2560x1440.jpg', 'Angi', 'angela.merkel@deutscher-bundestag.bnd', '$2y$10$mCPQFFdlwW.NnFM8MjmLquD8GJJWsAmRFu/Mgqif3q.H1K2U.IvCC', 'Angela ', 'Merkel', 'Das Internet ist für uns alle Neuland, aber mit Bier ist es ertrÃ¤glich.', '', 3, '2019-05-02 16:29:44'),
(7, '6e654b6e94f6856ea3d2666b2f696398521542d6-bierprof.jpg', 'DerDozent', 'der-dozent@hsw-prof.de', '$2y$10$QlIctVYJOQz0uUhrK3y0VO5mg.XLEqXXlmQAqhNpP829xYTDSHn2K', 'Nennis', 'Dolting', 'Ich bin der Prof', '', 4, '2019-05-03 15:24:58');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `beers`
--
ALTER TABLE `beers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Name` (`name`),
  ADD KEY `brewery_constraint` (`brewery_id`),
  ADD KEY `type_constraint` (`type_id`);

--
-- Indizes für die Tabelle `beers_ingredients`
--
ALTER TABLE `beers_ingredients`
  ADD PRIMARY KEY (`beer_id`,`ingredient_id`),
  ADD KEY `beer_constraint` (`beer_id`),
  ADD KEY `ingredient_constraint` (`ingredient_id`);

--
-- Indizes für die Tabelle `brewerys`
--
ALTER TABLE `brewerys`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `errors`
--
ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `beers`
--
ALTER TABLE `beers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `brewerys`
--
ALTER TABLE `brewerys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `errors`
--
ALTER TABLE `errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `beers`
--
ALTER TABLE `beers`
  ADD CONSTRAINT `brewery_constraint` FOREIGN KEY (`brewery_id`) REFERENCES `brewerys` (`id`),
  ADD CONSTRAINT `type_constraint` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

--
-- Constraints der Tabelle `beers_ingredients`
--
ALTER TABLE `beers_ingredients`
  ADD CONSTRAINT `beer_constraint` FOREIGN KEY (`beer_id`) REFERENCES `beers` (`id`),
  ADD CONSTRAINT `ingredient_constraint` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
