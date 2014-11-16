# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.49)
# Database: gran_reserva
# Generation Time: 2011-11-04 14:08:38 +0100
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table administradores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `administradores`;

CREATE TABLE `administradores` (
  `lugar` int(11) NOT NULL,
  `administrador` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`lugar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;

INSERT INTO `administradores` (`lugar`, `administrador`)
VALUES
	(1,'e109338789f'),
	(2,'e109338789f');

/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table horarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `horarios`;

CREATE TABLE `horarios` (
  `id_horario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `nombre` char(50) NOT NULL DEFAULT '',
  `tiempo` int(11) NOT NULL,
  PRIMARY KEY (`id_horario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `horarios` WRITE;
/*!40000 ALTER TABLE `horarios` DISABLE KEYS */;

INSERT INTO `horarios` (`id_horario`, `hora_inicio`, `hora_fin`, `nombre`, `tiempo`)
VALUES
	(1,'09:00:00','21:00:00','Ciencias',60),
	(2,'10:00:00','15:00:00','STIC',30);

/*!40000 ALTER TABLE `horarios` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lugares
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lugares`;

CREATE TABLE `lugares` (
  `id_lugar` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `facultad` char(100) NOT NULL DEFAULT '',
  `descripcion` text,
  PRIMARY KEY (`id_lugar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `lugares` WRITE;
/*!40000 ALTER TABLE `lugares` DISABLE KEYS */;

INSERT INTO `lugares` (`id_lugar`, `facultad`, `descripcion`)
VALUES
	(1,'Ciencias','Facultad de Ciencas'),
	(2,'STIC','Servicio de Tecnologias y blablabla'),
	(3,'Santa Cruz','Palacio de Santa Cruz y blablabla');

/*!40000 ALTER TABLE `lugares` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reservas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reservas`;

CREATE TABLE `reservas` (
  `id_reserva` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `inicio` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `persona` char(11) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `sala` int(11) DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`id_reserva`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;

INSERT INTO `reservas` (`id_reserva`, `inicio`, `fin`, `persona`, `confirmado`, `sala`, `descripcion`)
VALUES
	(1,'2011-10-10 09:00:00','2011-10-10 09:30:00','e09338789f',0,1,'1'),
	(2,'2011-09-10 09:00:00','2011-09-30 09:00:00','e09338789f',0,1,'2'),
	(3,'2011-09-27 09:00:00','2011-09-27 10:00:00','e09338789f',0,1,'3'),
	(4,'2011-10-05 11:00:00','2011-10-05 12:00:00','e09338789f',0,1,'4'),
	(5,'2011-10-06 11:00:00','2011-10-06 13:00:00','e09338789f',0,1,'5'),
	(18,'2011-10-10 11:00:00','2011-10-10 12:00:00','e09338789f',0,1,'6'),
	(17,'2011-10-09 17:00:00','2011-10-09 18:00:00','e09338789f',0,1,'7'),
	(16,'2011-10-12 09:00:00','2011-10-12 10:00:00','e09338789f',0,1,'8'),
	(45,'2011-11-02 13:00:00','2011-11-02 14:00:00','e09338789f',0,4,'turututuuuuuutuuu'),
	(35,'2011-10-24 11:00:00','2011-10-24 12:00:00','e09338789f',0,3,'Esto es una reserva en otro sitio'),
	(36,'2011-10-25 14:00:00','2011-10-25 15:00:00','e09338789f',0,1,'Esto es un test'),
	(38,'2011-10-27 12:00:00','2011-10-27 17:00:00','e09338789f',0,1,'This is a test'),
	(37,'2011-10-27 12:00:00','2011-10-27 13:00:00','e09338789f',0,3,'Cacafuti'),
	(39,'2011-11-02 11:00:00','2011-11-02 15:00:00','e09338789f',0,1,'Test222'),
	(40,'2011-11-04 13:00:00','2011-11-04 14:00:00','e09338789f',0,1,'Test 2'),
	(41,'2011-11-02 09:00:00','2011-11-02 10:00:00','e09338789f',0,1,'Test que se cierra solo'),
	(42,'2011-11-01 12:00:00','2011-11-01 23:00:00','e09338789f',0,3,'Cacafuti'),
	(43,'2011-11-03 11:00:00','2011-11-03 14:00:00','e09338789f',0,4,'Cacafutiiiiiiiiirl'),
	(19,'2011-10-13 12:00:00','2011-10-13 15:00:00','e09338789f',0,1,'9'),
	(20,'2011-10-15 09:00:00','2011-10-15 11:00:00','e09338789f',0,1,'1'),
	(21,'2011-10-14 13:00:00','2011-10-14 16:00:00','e09338789f',0,1,'2222'),
	(23,'2011-10-18 13:00:00','2011-10-18 16:00:00','e09338789f',0,1,'3'),
	(24,'2011-10-19 09:00:00','2011-10-19 11:00:00','e09338789f',0,1,'4'),
	(33,'2011-10-24 10:00:00','2011-10-24 11:00:00','e09338789f',0,1,'5'),
	(34,'2011-10-24 15:00:00','2011-10-24 18:00:00','e09338789f',0,1,'123'),
	(30,'2011-10-19 15:00:00','2011-10-19 16:00:00','e09338789f',0,1,'Nulla eget lacus ut turpis laoreet rutrum. Proin id leo sed libero condimentum varius eget vel neque. Maecenas vitae risus ac nibh elementum pharetra a a quam. Aenean volutpat massa sed ipsum facilisis quis euismod augue egestas. Curabitur quis imperdiet nibh. Maecenas nec urna non orci scelerisque elementum. Praesent facilisis nunc sed felis interdum cursus. Phasellus a dolor vel velit volutpat porttitor.\n\nMaecenas non massa elit, sit amet ornare orci. Aenean quis ante urna, hendrerit vehicula justo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam et lacus et nulla pharetra dictum. Morbi suscipit consectetur dui. Maecenas consequat dapibus purus quis varius. Pellentesque vehicula neque eu sapien aliquet a placerat lorem congue.');

/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table salas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `salas`;

CREATE TABLE `salas` (
  `id_sala` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` char(50) NOT NULL DEFAULT '',
  `lugar` int(11) NOT NULL,
  `descripcion` text,
  `gestion` tinyint(1) NOT NULL,
  `responsable` int(11) NOT NULL,
  `precio` int(11) DEFAULT NULL,
  `horario` int(11) NOT NULL,
  PRIMARY KEY (`id_sala`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `salas` WRITE;
/*!40000 ALTER TABLE `salas` DISABLE KEYS */;

INSERT INTO `salas` (`id_sala`, `nombre`, `lugar`, `descripcion`, `gestion`, `responsable`, `precio`, `horario`)
VALUES
	(1,'Salon grande 1333',1,'Esto es una prueba',0,1,0,1),
	(2,'Zona de quedar',2,'Esto es una habitacion redonda que se encuentra otra por la calle y dicen \"pum\"',0,1,0,1),
	(3,'Habitacion 1',3,'Habitacion 1',0,1,500,2),
	(4,'Habitacion 2',3,'Habitacion 2',0,1,500,2);

/*!40000 ALTER TABLE `salas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
