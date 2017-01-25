-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: incidencias_app
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `incidencias`
--

DROP TABLE IF EXISTS `incidencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incidencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `student` varchar(150) NOT NULL,
  `date` datetime NOT NULL,
  `idType` int(11) NOT NULL,
  `idCreator` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idTipo` (`idType`),
  KEY `fk_idCreador` (`idCreator`),
  CONSTRAINT `fk_idTipo` FOREIGN KEY (`idType`) REFERENCES `tipoIncidencias` (`id`),
  CONSTRAINT `fk_UsuariosIncidencias` FOREIGN KEY (`idCreator`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencias`
--

LOCK TABLES `incidencias` WRITE;
/*!40000 ALTER TABLE `incidencias` DISABLE KEYS */;
INSERT INTO `incidencias` VALUES (19,'Le apaga el ordenador a Enrique Casielles','Jaime','2017-01-25 16:38:45',2,4),(20,'Falta a DEINT','David Primenko','2017-01-25 16:41:20',3,7),(21,'No sincroniza los metodos de la seccion critica','David Primenko','2017-01-25 16:43:51',2,11),(23,'No entrega la tarea 7: Interfaz avanzada','Andres Espino','2017-01-15 00:00:00',4,7),(24,'Saca un 10 en Unity','Daniel Acedo','2017-01-18 00:00:00',2,9),(26,'No calcula el escrutinio de la quiniela','Amador Fernandez','2017-01-26 00:00:00',4,12),(27,'No usa volley para cargar los links de las imagenes del servidor','Joselu Gallardo','2017-01-26 00:00:00',2,12),(28,'Sigue sin ir al dia con ManagerProducts','David Primenko','2017-01-21 00:00:00',4,7),(29,'Me dice que mis enunciados no hay por donde cogerlos, no lo entiendo...','Amador Fernandez','2017-01-17 00:00:00',2,12),(30,'Se retrasa a clase y encima no me invita al cafe que llevaba con el','David Primenko','2017-01-20 00:00:00',2,7);
/*!40000 ALTER TABLE `incidencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoIncidencias`
--

DROP TABLE IF EXISTS `tipoIncidencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoIncidencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoIncidencias`
--

LOCK TABLES `tipoIncidencias` WRITE;
/*!40000 ALTER TABLE `tipoIncidencias` DISABLE KEYS */;
INSERT INTO `tipoIncidencias` VALUES (1,'Retraso','El alumno llegó tarde a la lección.'),(2,'Falta respeto','Falta al respeto de algún alumno o profesor'),(3,'Falta a clase','Falta a alguna lección'),(4,'Ejercicios no entregados','No presenta la tarea que se le manda');
/*!40000 ALTER TABLE `tipoIncidencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (4,'root','16ff504b76e7521ce35600a80e14680a611b97b5','Superuser'),(7,'moronlu','15e28283a18c27e48625f9dcedafd207bc8d3034','Lourdes Rodriguez'),(9,'smillan','a7ccd6ab343741b327dafef52a9fefd00d2731b7','Sebastian Millan'),(11,'emoreno','ebec420aa058c3d5fb7ba835a619d3b936c5ae89','Eliseo Moreno'),(12,'pacog','48aad8b30efa19a774405d456395b1779f450257','Paquillo');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-25 17:08:18
