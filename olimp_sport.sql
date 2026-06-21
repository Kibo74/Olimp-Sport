-- XAMPP-Lite
-- version 8.5.5
-- https://xampplite.sf.net/
--
-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 21, 2026 at 03:08 PM
-- Server version: 11.4.10-MariaDB-log
-- PHP Version: 8.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olimp_sport`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(32) NOT NULL,
  `prezime` varchar(32) NOT NULL,
  `korisnicko_ime` varchar(32) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'Admin', 'Adminovic', 'admin', '$2y$12$ifzQ/y/w34Mr52UHasitdunKVl.XOtsvI/cYUNW3.R4M4/EjSDWm6', 1),
(2, 'Pero', 'Peric', 'pero', '$2y$12$yi6RD/XsPb6k787rw6pkyOe/ccaqRG7..M2qtqX0u6GF.sihyixUW', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` varchar(32) NOT NULL,
  `naslov` varchar(64) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(64) NOT NULL,
  `kategorija` varchar(64) NOT NULL,
  `arhiva` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(1, '20.06.2026', 'Nogometna lopta Nike Strike', 'Profesionalna lopta velicine 5 za treninge i utakmice.', 'Nogometna lopta Nike Strike izradena je od izdrzljivog TPU materijala s ojacanim savovima koji osiguravaju stabilan let lopte. Velicina 5 odgovara standardu za seniorske natjecateljske utakmice. Teksturirana povrsina pruza bolji osjecaj kontrole pri dodiru, a dvoslojni mjehur zadrzava zrak duze vrijeme. Idealna za treninge na travi i umjetnim podlogama.', 'nogometna-lopta.jpg', 'nogomet', 0),
(2, '20.06.2026', 'Kopacke Adidas Predator', 'Kopacke za tvrde podloge s teksturiranim gornjistem za precizan udarac.', 'Kopacke Adidas Predator dizajnirane su za igrace koji zele maksimalnu kontrolu nad loptom. Gornjiste s gumiranim zonama poboljsava prijanjanje i preciznost dodavanja i udaraca. Lagani vanjski dio i anatomski uložak smanjuju umor tijekom duzih utakmica. Cijevasti ovratnik pruza dodatnu stabilnost gleznja. Dostupne u vise velicina.', 'kopacke.jpg', 'nogomet', 0),
(3, '20.06.2026', 'Golmanske rukavice Reusch', 'Vratarske rukavice s latex dlanom za pouzdano hvatanje lopte.', 'Golmanske rukavice Reusch opremljene su kvalitetnim latex dlanom debljine 4 mm koji osigurava izvrstan prianjanje u suhim i vlaznim uvjetima. Elasticni rucni dio s trakom na cicak pruza cvrst, ali udoban dosjed. Prozracni gornji dio odvodi vlagu, a ojacani prsti dodatno stite od ozljeda. Preporuceno za amaterske i poluprofesionalne vratare.', 'golmanske-rukavice.jpg', 'nogomet', 0),
(4, '20.06.2026', 'Kosarkaska lopta Spalding NBA', 'Sluzbena replika NBA lopte za dvoranu i vanjske terene.', 'Kosarkaska lopta Spalding NBA velicine 7 izradena je od kompozitne koze koja pruza mekan dodir i odlican balans. Duboki kanali olaksavaju kontrolu pri vodenju i sutiranju. Lopta je pogodna za igru u dvorani, a otporna povrsina podnosi i vanjske betonske terene. Isporucuje se djelomicno napuhana.', 'kosarkaska-lopta.jpg', 'kosarka', 0),
(5, '20.06.2026', 'Tenisice Nike LeBron', 'Kosarkaske tenisice s amortizacijom za brze promjene smjera.', 'Kosarkaske tenisice Nike LeBron nude visoku razinu amortizacije zahvaljujuci zracnom jastucenju u peti. Visoki ovratnik pruza podrsku gleznju kod skokova i doskoka. Vanjski potplat s uzorkom riblje kosti osigurava izvrsno prianjanje na parketu. Prozracni gornji dio drzi stopalo suhim tijekom intenzivne igre.', 'kosarkaske-tenisice.jpg', 'kosarka', 0),
(6, '20.06.2026', 'Kosarkaski dres Olimp', 'Lagani prozracni dres s tehnologijom odvodenja vlage.', 'Kosarkaski dres Olimp izraden je od laganog poliesterskog materijala koji odvodi znoj i brzo se susi. Mrezasti umetci na bocnim stranama dodatno poboljsavaju prozracnost. Ergonomski kroj omogucuje punu slobodu pokreta ruku. Dostupan u vise boja i velicina, idealan za klupske i rekreativne ekipe.', 'kosarkaski-dres.jpg', 'kosarka', 0),
(7, '20.06.2026', 'Set bucica 20 kg', 'Set podesivih bucica za trening snage kod kuce.', 'Set bucica ukupne tezine 20 kg sastoji se od dvije sipke i niza utega koje mozete kombinirati prema zeljenom opterecenju. Utezi su presvuceni gumom koja stiti pod i smanjuje buku. Navojni zatvaraci cvrsto drze utege na mjestu tijekom vjezbanja. Idealan izbor za kucnu teretanu i pocetnike u treningu snage.', 'bucice.jpg', 'fitness', 0),
(8, '20.06.2026', 'Podloga za vjezbanje', 'Protuklizna podloga za jogu, pilates i vjezbe istezanja.', 'Podloga za vjezbanje debljine 8 mm pruza udobnu amortizaciju za zglobove tijekom vjezbi na podu. Protuklizna povrsina s obje strane osigurava stabilnost pri vjezbama ravnoteze. Materijal bez stetnih tvari lako se cisti vlaznom krpom. Podloga se moze smotati i nositi pomocu prilozene trake za jednostavno spremanje.', 'podloga.jpg', 'fitness', 0),
(9, '20.06.2026', 'Traka za trcanje Olimp Run', 'Sklopiva traka za trcanje s programom treninga i LCD ekranom.', 'Traka za trcanje Olimp Run pokretana je tihim elektromotorom snage 2 KS i podrzava brzine do 14 km/h. LCD ekran prikazuje brzinu, vrijeme, prijedenu udaljenost i potrosnju kalorija. Nekoliko ugradenih programa treninga pomaze u postizanju ciljeva kondicije. Sklopiva konstrukcija stedi prostor, a sustav amortizacije rasterecuje koljena.', 'traka-za-trcanje.jpg', 'fitness', 0),
(10, '20.06.2026', 'Stari model tenisica (rasprodano)', 'Proizvod vise nije u ponudi - primjer arhiviranog zapisa.', 'Ovaj proizvod je arhiviran (arhiva = 1), pa se ne prikazuje na naslovnici niti na stranici kategorije, ali je i dalje pohranjen u bazi i vidljiv u administraciji.', 'kosarkaske-tenisice.jpg', 'kosarka', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`),
  ADD UNIQUE KEY `korisnicko_ime_2` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
