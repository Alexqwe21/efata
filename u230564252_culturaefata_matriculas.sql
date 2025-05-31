-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: culturaefata.com.br    Database: u230564252_culturaefata
-- ------------------------------------------------------
-- Server version	5.5.5-10.11.10-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `matriculas`
--

DROP TABLE IF EXISTS `matriculas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matriculas` (
  `matricula_id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula_nome` varchar(150) NOT NULL,
  `matricula_cep` varchar(9) NOT NULL,
  `matricula_endereco` varchar(150) NOT NULL,
  `matricula_bairro` varchar(100) NOT NULL,
  `matricula_cidade` varchar(100) NOT NULL,
  `matricula_estado` varchar(2) NOT NULL,
  `matricula_pais` varchar(50) NOT NULL,
  `matricula_telefone` varchar(20) NOT NULL,
  `matricula_telefone_emergencia` varchar(20) DEFAULT NULL,
  `matricula_cpf` varchar(14) NOT NULL,
  `matricula_rg` varchar(20) NOT NULL,
  `matricula_data_nascimento` date NOT NULL,
  `matricula_email` varchar(100) NOT NULL,
  `matricula_problemas_saude` text DEFAULT NULL,
  `matricula_responsavel_nome` varchar(150) DEFAULT NULL,
  `matricula_responsavel_rg` varchar(20) DEFAULT NULL,
  `matricula_responsavel_cpf` varchar(14) DEFAULT NULL,
  `matricula_responsavel_qualidade` varchar(50) DEFAULT NULL,
  `matricula_menor_nome` varchar(150) DEFAULT NULL,
  `matricula_menor_rg` varchar(20) DEFAULT NULL,
  `matricula_menor_nascimento` date DEFAULT NULL,
  `matricula_atividade` varchar(100) NOT NULL,
  PRIMARY KEY (`matricula_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matriculas`
--

LOCK TABLES `matriculas` WRITE;
/*!40000 ALTER TABLE `matriculas` DISABLE KEYS */;
/*!40000 ALTER TABLE `matriculas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-27 15:18:34
