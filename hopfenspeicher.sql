-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 09. Mai 2019 um 11:46
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
DROP DATABASE IF EXISTS `hopfenspeicher`;
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
--
-- Datenbank: `phpmyadmin`
--
DROP DATABASE IF EXISTS `phpmyadmin`;
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__bookmark`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__bookmark`;
CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

--
-- RELATIONEN DER TABELLE `pma__bookmark`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__central_columns`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__central_columns`;
CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

--
-- RELATIONEN DER TABELLE `pma__central_columns`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__column_info`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__column_info`;
CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

--
-- RELATIONEN DER TABELLE `pma__column_info`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__designer_settings`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__designer_settings`;
CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

--
-- RELATIONEN DER TABELLE `pma__designer_settings`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__export_templates`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__export_templates`;
CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

--
-- RELATIONEN DER TABELLE `pma__export_templates`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__favorite`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__favorite`;
CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

--
-- RELATIONEN DER TABELLE `pma__favorite`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__history`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__history`;
CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

--
-- RELATIONEN DER TABELLE `pma__history`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__navigationhiding`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__navigationhiding`;
CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

--
-- RELATIONEN DER TABELLE `pma__navigationhiding`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__pdf_pages`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__pdf_pages`;
CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

--
-- RELATIONEN DER TABELLE `pma__pdf_pages`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__recent`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__recent`;
CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- RELATIONEN DER TABELLE `pma__recent`:
--

--
-- Daten für Tabelle `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"hopfenspeicher\",\"table\":\"users\"},{\"db\":\"sicherheit\",\"table\":\"post\"},{\"db\":\"sicherheit\",\"table\":\"benutzer\"},{\"db\":\"sicherheit\",\"table\":\"Post\"},{\"db\":\"sicherheit\",\"table\":\"Benutzer\"},{\"db\":\"hopfenspeicher\",\"table\":\"beers\"},{\"db\":\"hopfenspeicher\",\"table\":\"ingredients\"},{\"db\":\"hopfenspeicher\",\"table\":\"beers_ingredients\"},{\"db\":\"hopfenspeicher\",\"table\":\"images\"},{\"db\":\"hopfenspeicher\",\"table\":\"beers_igredients\"}]');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__relation`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__relation`;
CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

--
-- RELATIONEN DER TABELLE `pma__relation`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__savedsearches`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__savedsearches`;
CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

--
-- RELATIONEN DER TABELLE `pma__savedsearches`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__table_coords`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__table_coords`;
CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

--
-- RELATIONEN DER TABELLE `pma__table_coords`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__table_info`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__table_info`;
CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

--
-- RELATIONEN DER TABELLE `pma__table_info`:
--

--
-- Daten für Tabelle `pma__table_info`
--

INSERT INTO `pma__table_info` (`db_name`, `table_name`, `display_field`) VALUES
('hopfenspeicher', 'beers', 'name'),
('sicherheit', 'post', 'Inhalt');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__table_uiprefs`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__table_uiprefs`;
CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- RELATIONEN DER TABELLE `pma__table_uiprefs`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__tracking`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__tracking`;
CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

--
-- RELATIONEN DER TABELLE `pma__tracking`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__userconfig`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__userconfig`;
CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- RELATIONEN DER TABELLE `pma__userconfig`:
--

--
-- Daten für Tabelle `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2019-05-09 09:43:36', '{\"lang\":\"de\",\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__usergroups`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__usergroups`;
CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

--
-- RELATIONEN DER TABELLE `pma__usergroups`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pma__users`
--
-- Erstellt am: 06. Apr 2019 um 12:07
--

DROP TABLE IF EXISTS `pma__users`;
CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- RELATIONEN DER TABELLE `pma__users`:
--

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indizes für die Tabelle `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indizes für die Tabelle `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indizes für die Tabelle `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indizes für die Tabelle `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indizes für die Tabelle `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indizes für die Tabelle `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indizes für die Tabelle `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indizes für die Tabelle `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indizes für die Tabelle `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indizes für die Tabelle `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indizes für die Tabelle `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indizes für die Tabelle `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indizes für die Tabelle `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indizes für die Tabelle `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indizes für die Tabelle `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indizes für die Tabelle `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indizes für die Tabelle `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Datenbank: `sicherheit`
--
DROP DATABASE IF EXISTS `sicherheit`;
CREATE DATABASE IF NOT EXISTS `sicherheit` DEFAULT CHARACTER SET utf8 COLLATE utf8_german2_ci;
USE `sicherheit`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--
-- Erstellt am: 04. Mai 2019 um 10:22
--

DROP TABLE IF EXISTS `benutzer`;
CREATE TABLE `benutzer` (
  `Benutzer-ID` int(11) NOT NULL,
  `Benutzername` varchar(30) COLLATE utf8_german2_ci NOT NULL,
  `Passwort` varchar(15) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `benutzer`:
--

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`Benutzer-ID`, `Benutzername`, `Passwort`) VALUES
(1, 'DerHenne', '123'),
(2, 'Hönnes', '123'),
(3, 'Admin', 'root'),
(4, 'testboi', '1234');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `post`
--
-- Erstellt am: 04. Mai 2019 um 10:24
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `Post-ID` int(11) NOT NULL,
  `Inhalt` varchar(225) COLLATE utf8_german2_ci NOT NULL,
  `Benutzer-ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `post`:
--   `Benutzer-ID`
--       `benutzer` -> `Benutzer-ID`
--

--
-- Daten für Tabelle `post`
--

INSERT INTO `post` (`Post-ID`, `Inhalt`, `Benutzer-ID`) VALUES
(1, 'Hallo I bims, 1 Spasst vong der Seinheit her', 1),
(2, 'Ich mag Kekse', 1),
(3, 'Henrik stink', 1),
(4, 'Test123', 3),
(5, 'Wer das liest ist doof und nicht berechtigt', 3),
(6, 'Ich mag Pömmes!', 2),
(7, 'Hilfe!!! Ich bin gefangen im Internet!', 4),
(8, 'Der VIrenscanner verfolgt mich!', 4),
(9, 'Spaaaaaaß, bin einfach hart auf Drogen', 4);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`Benutzer-ID`);

--
-- Indizes für die Tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`Post-ID`),
  ADD KEY `Constraint-Benutzer-ID` (`Benutzer-ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `Benutzer-ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `post`
--
ALTER TABLE `post`
  MODIFY `Post-ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `Constraint-Benutzer-ID` FOREIGN KEY (`Benutzer-ID`) REFERENCES `benutzer` (`Benutzer-ID`);
--
-- Datenbank: `test`
--
DROP DATABASE IF EXISTS `test`;
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
