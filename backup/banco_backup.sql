-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
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
  `matricula_data_cadastro` datetime DEFAULT current_timestamp(),
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

--
-- Table structure for table `questionario_saude`
--

DROP TABLE IF EXISTS `questionario_saude`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questionario_saude` (
  `questionario_saude_id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula_id` int(11) DEFAULT NULL,
  `questionario_saude_problemas` text DEFAULT NULL,
  `questionario_saude_outros` varchar(255) DEFAULT NULL,
  `questionario_medicamentos` enum('Sim','Não') DEFAULT NULL,
  `questionario_medicamentos_quais` varchar(255) DEFAULT NULL,
  `questionario_lesao` enum('Sim','Não') DEFAULT NULL,
  `questionario_lesao_qual` varchar(255) DEFAULT NULL,
  `questionario_acompanhamento` enum('Sim','Não') DEFAULT NULL,
  `questionario_acompanhamento_especialidade` varchar(255) DEFAULT NULL,
  `questionario_alergias` enum('Sim','Não') DEFAULT NULL,
  `questionario_alergias_quais` varchar(255) DEFAULT NULL,
  `questionario_atividade_fisica` enum('Sim','Não') DEFAULT NULL,
  `questionario_atividade_fisica_quais` varchar(255) DEFAULT NULL,
  `questionario_sono` enum('Sempre','Às vezes','Raramente') DEFAULT NULL,
  `questionario_alimentacao` enum('Sim','Não') DEFAULT NULL,
  `questionario_apto` enum('Sim','Não','Não sei') DEFAULT NULL,
  `questionario_avaliacao_medica` enum('Sim','Não') DEFAULT NULL,
  `questionario_avaliacao_medica_quem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`questionario_saude_id`),
  KEY `matricula_id` (`matricula_id`),
  CONSTRAINT `questionario_saude_ibfk_1` FOREIGN KEY (`matricula_id`) REFERENCES `matriculas` (`matricula_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionario_saude`
--

LOCK TABLES `questionario_saude` WRITE;
/*!40000 ALTER TABLE `questionario_saude` DISABLE KEYS */;
INSERT INTO `questionario_saude` VALUES (1,1,'Doença cardíaca,Problemas articulares','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(2,2,'Doença cardíaca','nao','Não','nao','Não','nao','Não','nao','Não','nao','Não','nao','Às vezes','Não','Não','Não','nao fiz'),(3,3,'Epilepsia','1111111111','Sim','11111111111111111111111','Sim','11111111111111111','Sim','111111111111111','Sim','111111111111111','Sim','11111111111111111111','Sempre','Sim','Sim','Sim','11111111111111111111111111111111111'),(4,4,'Doença cardíaca,Pressão alta,Diabetes,Asma,Problemas articulares,Epilepsia','111111111111111111111','Sim','111111111111','Sim','111111111111111','Sim','11111111111','Sim','11111111111111','Sim','1111111111111111','Sempre','Sim','Sim','Sim','1111111111111111111'),(5,5,'Doença cardíaca','','','','','','','','','','','','','','','',''),(6,6,'Doença cardíaca','','Não','','Não','','Não','','Não','','Não','','Sempre','Sim','Sim','Não',''),(7,7,'Doença cardíaca','','Sim','11111111111111111111111','Sim','11111111111111111','Sim','nao','Sim','111111111111111','Sim','11111111111111111111','Às vezes','Sim','Não','Não','aaa'),(8,8,'Doença cardíaca','','Não','','Não','','Não','','Não','','Não','','Sempre','Não','Não','Não',''),(9,9,'Nenhum','','Não','','Sim','','Não','','Sim','','Não','','Às vezes','Não','Não','Não',''),(10,10,'Nenhum','nao','Não','nao','Não','nao','Não','nao','Não','nao','Não','nao','Às vezes','Não','Não','Não','nao'),(11,11,'Asma','','Não','nao','Não','nao','Não','nao','Não','nao','Não','nao','Sempre','Sim','Não','Não','nao fiz'),(12,12,'Nenhum','nao','Não','nao','Não','nao','Não','nao','Não','nao','Não','nao','Às vezes','Não','Não','Não','nao fiz'),(13,13,'Nenhum','nao tenho','Não','nao','Não','nao','Não','nao','Não','nao','Não','nao','Às vezes','Não','Não','Não','nao fiz'),(14,14,'Nenhum','nao','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não sei','Não',''),(15,15,'Nenhum','1111111111','Não','nao','Não','nao','Não','nao','Não','nao','Não','nao','Às vezes','Não','Não','Não','nao fiz'),(16,16,'Nenhum','nao','Não','nao','Não','nao','Não','nao','Não','nao','Não','nao','Às vezes','Não','Não','Não','nao fiz'),(17,17,'Nenhum','nao','Não','nao','Não','nao','Não','nao','Não','nao','Não','nao','Às vezes','Sim','Sim','Não','nao fiz'),(18,18,'Nenhum','Nao','Não','Nao','Não','','Não','Nao','Não','Nao','Não','Nao','Às vezes','Não','Sim','Não','Nao'),(19,19,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(20,20,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(21,21,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Sempre','Não','Não','Não',''),(22,22,'Doença cardíaca','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(23,23,'Pressão alta','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(24,24,'Epilepsia','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(25,25,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não',''),(26,26,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(27,27,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não',''),(28,28,'Doença cardíaca','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(29,29,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(30,30,'Asma','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Sim','Não',''),(31,31,'Asma','','Não','','Não','','Não','','Não','','Não','','Sempre','Não','Não','Não',''),(32,32,'Diabetes','Nao','Não','Nao','Não','nao','Não','Nao','Não','Não','Não','Não','Às vezes','Não','Não','Não','Não'),(33,33,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não',''),(34,34,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não',''),(35,35,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não',''),(36,36,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(37,37,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(38,38,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(39,39,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(40,40,'Nenhum','','Não','','Não','','Não','','Sim','A leite','Sim','Ando de Bike, 8km por dia','Às vezes','Sim','Sim','Não',''),(41,41,'Nenhum','','Não','','Não','','Sim','','Não','','Sim','Cross','Às vezes','Sim','Sim','Sim',''),(42,42,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(43,43,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não',''),(44,44,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não',''),(45,45,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(46,46,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não',''),(47,47,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Às vezes','Não','Não','Não',''),(48,48,'Nenhum','','Não','','Não','','Não','','Não','','Não','','Raramente','Não','Não','Não','');
/*!40000 ALTER TABLE `questionario_saude` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-28 18:15:07
