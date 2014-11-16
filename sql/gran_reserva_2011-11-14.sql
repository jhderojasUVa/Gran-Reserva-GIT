# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.49)
# Database: gran_reserva
# Generation Time: 2011-11-14 12:22:56 +0100
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
  `administrador` char(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;

INSERT INTO `administradores` (`lugar`, `administrador`)
VALUES
	(1,'e09338789f'),
	(2,'e09338789f'),
	(3,'e09338789f'),
	(5,'e09338789f'),
	(2,'e71124293j'),
	(5,'e71124293j');

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
	(2,'10:00:00','15:00:00','STIC',30),
	(3,'06:00:00','20:00:00','Habitacion',3600);

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


# Dump of table recursos_salas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `recursos_salas`;

CREATE TABLE `recursos_salas` (
  `id_sala` int(11) NOT NULL,
  `recurso` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `recursos_salas` WRITE;
/*!40000 ALTER TABLE `recursos_salas` DISABLE KEYS */;

INSERT INTO `recursos_salas` (`id_sala`, `recurso`)
VALUES
	(1,'Esta sala dispone de 500 butacas'),
	(1,'Incorpora video-conferencia'),
	(1,'Conexion WIFI'),
	(2,'Conexion WIFI'),
	(2,'Conexion WiMAX'),
	(2,'Video Conferencia'),
	(3,'Habitación doble para uso individual'),
	(4,'Habitación doble');

/*!40000 ALTER TABLE `recursos_salas` ENABLE KEYS */;
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
	(1,'2011-10-10 09:00:00','2011-10-10 09:30:00','e09338789f',1,1,'Conferencia inaugural'),
	(2,'2011-09-10 09:00:00','2011-09-30 09:00:00','e09338789f',1,1,'Curso de termodinamica aplicada a los metales'),
	(3,'2011-09-27 09:00:00','2011-09-27 10:00:00','e09338789f',1,1,'Ponencia sobre polimeros'),
	(56,'2011-11-08 10:00:00','2011-11-08 11:00:00','e09338789f',1,1,'Conferencia abierta a todos'),
	(57,'2011-11-08 10:00:00','2011-11-08 11:00:00','e09338789f',1,1,'Reunión de Fisica I'),
	(58,'2011-11-08 11:00:00','2011-11-08 12:00:00','e09338789f',1,1,'Exposición neutra'),
	(59,'2011-11-08 13:00:00','2011-11-08 14:00:00','e09338789f',1,2,'Reunión Web'),
	(60,'2011-11-09 13:00:00','2011-11-09 14:00:00','e09338789f',1,1,'Presentación del doctorado sobre mecanica cuantica I'),
	(61,'2011-11-09 12:00:00','2011-11-09 13:00:00','e09338789f',1,1,'Presentación del doctorado sobre Grados Moleculares Sencillos'),
	(62,'2011-11-10 09:00:00','2011-11-10 18:00:00','e09338789f',1,1,'Petición de aula'),
	(63,'2011-11-09 10:00:00','2011-11-09 11:00:00','e09338789f',1,1,'Charla/Conferencia sobre movimientos terrestres aplicados'),
	(64,'2011-11-11 09:00:00','2011-11-11 10:00:00','e09338789f',1,1,'Charla del Honoris Causa en Cristalografía'),
	(65,'2011-11-11 11:00:00','2011-11-11 12:00:00','e09338789f',1,1,'Gestación de un sistema hibrido molecular complejo'),
	(48,'2011-11-17 10:00:00','2011-11-17 20:00:00','e09338789f',1,1,'Conferencias RED-IRIS IPV6'),
	(49,'2011-11-20 14:00:00','2011-11-20 15:00:00','e09338789f',1,1,'Tertulia acerca de la crisis economica'),
	(50,'2011-11-10 09:00:00','2011-11-10 10:00:00','e09338789f',1,1,'Presentación de un sistema binomio de cortes triangulares en carton'),
	(51,'2011-12-25 09:00:00','2011-12-25 19:00:00','e09338789f',1,1,'Honoris Causa Literatura Clásica contemporanea'),
	(52,'2011-12-24 09:00:00','2011-12-24 21:00:00','e09338789f',1,1,'Realización de parada y arranque de servicios básicos'),
	(54,'2011-11-09 14:00:00','2011-11-09 15:00:00','e09338789f',1,1,'Concierto Jingles Navideños'),
	(55,'2011-11-08 15:00:00','2011-11-08 18:00:00','e09338789f',1,1,'Presentación de mecanica cuantica y bucles cuanticos'),
	(4,'2011-10-05 11:00:00','2011-10-05 12:00:00','e09338789f',1,1,'Curso de interes artistico por el barro'),
	(5,'2011-10-06 11:00:00','2011-10-06 13:00:00','e09338789f',1,1,'Comite interdisciplinar del resultado de la almendra'),
	(18,'2011-10-10 11:00:00','2011-10-10 12:00:00','e09338789f',1,1,'Reunión sobre microgravedad en entornos controlados'),
	(17,'2011-10-09 17:00:00','2011-10-09 18:00:00','e09338789f',1,1,'Microcirugia vascular en entornos complicados'),
	(16,'2011-10-12 09:00:00','2011-10-12 10:00:00','e09338789f',1,1,'Reunión de administración agropecuaria'),
	(45,'2011-11-02 13:00:00','2011-11-02 14:00:00','e09338789f',1,4,'Tutoria sobre crecimiento básico de estructuras a altas presiones'),
	(35,'2011-10-24 11:00:00','2011-10-24 12:00:00','e09338789f',1,3,'Seminario de coloración interna en camellos'),
	(36,'2011-10-25 14:00:00','2011-10-25 15:00:00','e09338789f',1,1,'Tutoria Metodos Matematicos III'),
	(38,'2011-10-27 12:00:00','2011-10-27 17:00:00','e09338789f',1,1,'Tutoria de Diseño en Programación de automatas'),
	(37,'2011-10-27 12:00:00','2011-10-27 13:00:00','e09338789f',1,3,'Reunión interdisciplinar de analisis sintactico'),
	(75,'2011-11-14 12:00:00','2011-11-14 13:00:00','e09338789f',1,1,'Analisis cuantico en fechas criticas II'),
	(68,'2011-11-11 13:00:00','2011-11-11 14:00:00','e09338789f',1,1,'Curso de programación en Motion 101'),
	(71,'2011-11-12 09:00:00','2011-11-12 10:00:00','e09338789f',1,1,'Revisión de examenes por la junta de gobierno'),
	(42,'2011-11-01 12:00:00','2011-11-01 23:00:00','e09338789f',1,3,'Conferencia/Charla sobre gravedad e impulsos electromagneticos'),
	(43,'2011-11-03 11:00:00','2011-11-03 14:00:00','e09338789f',1,4,'Charla acerca de generador WARP de impulsos'),
	(69,'2011-11-12 09:00:00','2011-11-12 12:00:00','e09338789f',1,1,'Laser y analisis de frases hechas'),
	(19,'2011-10-13 12:00:00','2011-10-13 15:00:00','e09338789f',1,1,'Fotografia de la camara oscura'),
	(77,'2011-11-14 16:00:00','2011-11-14 22:00:00','e09338789f',0,1,'Creación de un sistema de abaratamiento de costes reales'),
	(76,'2011-11-14 14:00:00','2011-11-14 15:00:00','e09338789f',1,1,'Animalario de uso para Photoshop CS5');

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
  `privada` int(11) DEFAULT '0',
  PRIMARY KEY (`id_sala`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `salas` WRITE;
/*!40000 ALTER TABLE `salas` DISABLE KEYS */;

INSERT INTO `salas` (`id_sala`, `nombre`, `lugar`, `descripcion`, `gestion`, `responsable`, `precio`, `horario`, `privada`)
VALUES
	(1,'Salon de Grados',1,'Salon con capacidad para 500 personas',1,1,0,1,0),
	(2,'Biblioteca',2,'Biblioteca del STIC',0,1,0,2,0),
	(3,'Habitacion 1',3,'Habitación doble. Puede ser usada para uso individual.<br>\nCon acceso WIFI.<br>\nDesayuno de 8:00 a 11:00<br>\nComida de 12:00 a 14:00<br>\nCena de 18:00 a 21:00<br>\n',1,1,29,3,0),
	(4,'Habitacion 2',3,'Habitación individual.<br>\nCon acceso WIFI.<br>\nDesayuno de 8:00 a 11:00<br>\nComida de 12:00 a 14:00<br>\nCena de 18:00 a 21:00<br>',1,1,40,3,0),
	(5,'Habitacion 3',3,'Habitación privada',1,1,39,3,1);

/*!40000 ALTER TABLE `salas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
