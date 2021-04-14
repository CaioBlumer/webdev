-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 05, 2021 at 08:30 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avii_desenvweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `mad_appointment`
--

DROP TABLE IF EXISTS `mad_appointment`;
CREATE TABLE IF NOT EXISTS `mad_appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pacient` varchar(128) NOT NULL,
  `consult_date` datetime NOT NULL,
  `type` varchar(128) NOT NULL,
  `comment` varchar(128) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mad_appointment`
--

INSERT INTO `mad_appointment` (`id`, `pacient`, `consult_date`, `type`, `comment`, `doctor_id`, `user_id`) VALUES
(22, 'Claudio', '2021-04-22 17:22:00', 'retorno', 'exames', 1, 12),
(20, 'Adriano', '2021-04-15 20:24:00', 'retorno', 'coraÃ§Ã£o', 1, 10),
(21, 'Bruna', '2021-05-20 17:22:00', 'consulta', 'Gripe', 1, 11),
(23, 'David', '2021-06-23 17:28:00', 'retorno', 'dores', 9, 13),
(24, 'Eduardo', '2021-04-30 17:24:00', 'retorno', 'gripe', 9, 14),
(25, 'Eduardo', '2021-05-27 17:24:00', 'retorno', 'retorno', 9, 14),
(26, 'Fabio', '2021-05-19 17:24:00', 'retorno', 'exames', 9, 15);

-- --------------------------------------------------------

--
-- Table structure for table `mad_users`
--

DROP TABLE IF EXISTS `mad_users`;
CREATE TABLE IF NOT EXISTS `mad_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `is_doctor` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mad_users`
--

INSERT INTO `mad_users` (`id`, `name`, `email`, `password`, `birth_date`, `is_doctor`) VALUES
(1, 'Caio Blumer', 'caio@email.com', '$2y$10$mW1ZhDq8hj/6PpOLXcEa7OEyHsaFFwbv9SeiCK4jRbNArpzdPZZwO', '1997-01-20', 1),
(10, 'Adriano', 'adriano@email.com', '$2y$10$CKAcHBMDrhpms0sjENF9vep0Sk6EifBUpdp2QArlek8b2Pb4Mo7Ve', '2021-04-22', 0),
(9, 'Alecs', 'alecs@email.com', '$2y$10$mW1ZhDq8hj/6PpOLXcEa7OEyHsaFFwbv9SeiCK4jRbNArpzdPZZwO', '1997-01-14', 1),
(11, 'Bruna', 'bruna@email.com', '$2y$10$l284fNevj1Vzs1D/iCxwXemuf2mbBhFxQXraFsSmDXy31cFbJncrO', '2021-03-31', 0),
(12, 'Claudio', 'claudio@email.com', '$2y$10$TLY/gRNF7GuzmdNBPRwOpO9P9G2lhCnEBRv9pXXA3XENSVLrvNJme', '2021-04-23', 0),
(13, 'David', 'david@email.com', '$2y$10$hdHOEdCLWXXO32PyTsgwq.bAIePzBTAaXWbg/IVvu/6gV0Gdnfxam', '2021-04-01', 0),
(14, 'Eduardo', 'eduardo@email.com', '$2y$10$bjwjQB0dMY9fZGUxXXrgCe95HrJ3rUUBs04dxDAiflijkQSUA6gpe', '2021-04-22', 0),
(15, 'Fabio', 'fabio@email.com', '$2y$10$IFigLCVGD0SmSWWAthlYp.iPlz9rY29FhPVLSkW4I/XxWT4LEYeTi', '2021-04-23', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
