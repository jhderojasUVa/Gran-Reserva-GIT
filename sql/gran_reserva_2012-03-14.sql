# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.49)
# Database: gran_reserva
# Generation Time: 2012-03-14 13:23:06 +0100
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
	(5,'e71124293j'),
	(3,'e12355137c'),
	(11,'e12355137c'),
	(4,'e12355137c'),
	(5,'e12355137c'),
	(8,'e12355137c'),
	(9,'e12355137c'),
	(10,'e12355137c'),
	(13,'e12355137c'),
	(14,'e12355137c');

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
	(2,'STIC','Servicio de Tecnologias, de la Informatica y las Comunicaciones'),
	(3,'Santa Cruz','Palacio de Santa Cruz'),
	(4,'Facultad de Derecho','Facultad de Derecho');

/*!40000 ALTER TABLE `lugares` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table observaciones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `observaciones`;

CREATE TABLE `observaciones` (
  `usuario` int(11) unsigned NOT NULL,
  `observaciones` text NOT NULL,
  PRIMARY KEY (`usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table recursos_salas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `recursos_salas`;

CREATE TABLE `recursos_salas` (
  `id_recurso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sala` int(11) NOT NULL,
  `recurso` text NOT NULL,
  PRIMARY KEY (`id_recurso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `recursos_salas` WRITE;
/*!40000 ALTER TABLE `recursos_salas` DISABLE KEYS */;

INSERT INTO `recursos_salas` (`id_recurso`, `id_sala`, `recurso`)
VALUES
	(1,1,'Butacas'),
	(2,1,'Video-conferencia'),
	(3,1,'Conexion WIFI'),
	(4,2,'Conexion WIFI'),
	(5,2,'Conexion WiMAX'),
	(6,2,'Video Conferencia'),
	(7,3,'Habitación doble para uso individual'),
	(8,4,'Habitación doble');

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
  `contacto` text,
  `confirmado` tinyint(1) DEFAULT NULL,
  `sala` int(11) DEFAULT NULL,
  `descripcion` text,
  `recursos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_reserva`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;

INSERT INTO `reservas` (`id_reserva`, `inicio`, `fin`, `persona`, `contacto`, `confirmado`, `sala`, `descripcion`, `recursos`)
VALUES
	(1,'2011-10-10 09:00:00','2011-10-10 09:30:00','e09338789f',NULL,1,1,'Conferencia inaugural',NULL),
	(2,'2011-09-10 09:00:00','2011-09-30 09:00:00','e09338789f',NULL,1,1,'Curso de termodinamica aplicada a los metales',NULL),
	(3,'2011-09-27 09:00:00','2011-09-27 10:00:00','e09338789f',NULL,1,1,'Ponencia sobre polimeros',NULL),
	(56,'2011-11-08 10:00:00','2011-11-08 11:00:00','e09338789f',NULL,1,1,'Conferencia abierta a todos',NULL),
	(57,'2011-11-08 10:00:00','2011-11-08 11:00:00','e09338789f',NULL,1,1,'Reunión de Fisica I',NULL),
	(58,'2011-11-08 11:00:00','2011-11-08 12:00:00','e09338789f',NULL,1,1,'Exposición neutra',NULL),
	(59,'2011-11-08 13:00:00','2011-11-08 14:00:00','e09338789f',NULL,1,2,'Reunión Web',NULL),
	(60,'2011-11-09 13:00:00','2011-11-09 14:00:00','e09338789f',NULL,1,1,'Presentación del doctorado sobre mecanica cuantica I',NULL),
	(61,'2011-11-09 12:00:00','2011-11-09 13:00:00','e09338789f',NULL,1,1,'Presentación del doctorado sobre Grados Moleculares Sencillos',NULL),
	(62,'2011-11-10 09:00:00','2011-11-10 18:00:00','e09338789f',NULL,1,1,'Petición de aula',NULL),
	(63,'2011-11-09 10:00:00','2011-11-09 11:00:00','e09338789f',NULL,1,1,'Charla/Conferencia sobre movimientos terrestres aplicados',NULL),
	(64,'2011-11-11 09:00:00','2011-11-11 10:00:00','e09338789f',NULL,1,1,'Charla del Honoris Causa en Cristalografía',NULL),
	(65,'2011-11-11 11:00:00','2011-11-11 12:00:00','e09338789f',NULL,1,1,'Gestación de un sistema hibrido molecular complejo',NULL),
	(48,'2011-11-17 10:00:00','2011-11-17 20:00:00','e09338789f','12345',1,1,'Conferencias RED-IRIS IPV6',NULL),
	(49,'2011-11-20 14:00:00','2011-11-20 15:00:00','e09338789f',NULL,1,1,'Tertulia acerca de la crisis economica',NULL),
	(50,'2011-11-10 09:00:00','2011-11-10 10:00:00','e09338789f',NULL,1,1,'Presentación de un sistema binomio de cortes triangulares en carton',NULL),
	(91,'2011-11-17 10:00:00','2011-11-17 11:00:00','e09338789f','47474747',1,2,'HOLA',NULL),
	(89,'2011-11-16 09:00:00','2011-11-16 12:00:00','e09338789f','555612612',1,1,'Reunión Asimetrica de objetos',NULL),
	(54,'2011-11-09 14:00:00','2011-11-09 15:00:00','e09338789f',NULL,1,1,'Concierto Jingles Navideños',NULL),
	(55,'2011-11-08 15:00:00','2011-11-08 18:00:00','e09338789f',NULL,1,1,'Presentación de mecanica cuantica y bucles cuanticos',NULL),
	(4,'2011-10-05 11:00:00','2011-10-05 12:00:00','e09338789f',NULL,1,1,'Curso de interes artistico por el barro',NULL),
	(5,'2011-10-06 11:00:00','2011-10-06 13:00:00','e09338789f',NULL,1,1,'Comite interdisciplinar del resultado de la almendra',NULL),
	(18,'2011-10-10 11:00:00','2011-10-10 12:00:00','e09338789f',NULL,1,1,'Reunión sobre microgravedad en entornos controlados',NULL),
	(17,'2011-10-09 17:00:00','2011-10-09 18:00:00','e09338789f',NULL,1,1,'Microcirugia vascular en entornos complicados',NULL),
	(16,'2011-10-12 09:00:00','2011-10-12 10:00:00','e09338789f',NULL,1,1,'Reunión de administración agropecuaria',NULL),
	(45,'2011-11-02 13:00:00','2011-11-02 14:00:00','e09338789f',NULL,1,4,'Tutoria sobre crecimiento básico de estructuras a altas presiones',NULL),
	(35,'2011-10-24 11:00:00','2011-10-24 12:00:00','e09338789f',NULL,1,3,'Seminario de coloración interna en camellos',NULL),
	(36,'2011-10-25 14:00:00','2011-10-25 15:00:00','e09338789f',NULL,1,1,'Tutoria Metodos Matematicos III',NULL),
	(38,'2011-10-27 12:00:00','2011-10-27 17:00:00','e09338789f',NULL,1,1,'Tutoria de Diseño en Programación de automatas',NULL),
	(37,'2011-10-27 12:00:00','2011-10-27 13:00:00','e09338789f',NULL,1,3,'Reunión interdisciplinar de analisis sintactico',NULL),
	(75,'2011-11-14 12:00:00','2011-11-14 13:00:00','e09338789f',NULL,1,1,'Analisis cuantico en fechas criticas II',NULL),
	(68,'2011-11-11 13:00:00','2011-11-11 14:00:00','e09338789f',NULL,1,1,'Curso de programación en Motion 101',NULL),
	(71,'2011-11-12 09:00:00','2011-11-12 10:00:00','e09338789f',NULL,1,1,'Revisión de examenes por la junta de gobierno',NULL),
	(42,'2011-11-01 12:00:00','2011-11-01 23:00:00','e09338789f',NULL,1,3,'Conferencia/Charla sobre gravedad e impulsos electromagneticos',NULL),
	(43,'2011-11-03 11:00:00','2011-11-03 14:00:00','e09338789f',NULL,1,4,'Charla acerca de generador WARP de impulsos',NULL),
	(69,'2011-11-12 09:00:00','2011-11-12 12:00:00','e09338789f',NULL,1,1,'Laser y analisis de frases hechas',NULL),
	(19,'2011-10-13 12:00:00','2011-10-13 15:00:00','e09338789f',NULL,1,1,'Fotografia de la camara oscura',NULL),
	(76,'2011-11-14 14:00:00','2011-11-14 15:00:00','e09338789f',NULL,1,1,'Animalario de uso para Photoshop CS5',NULL),
	(90,'2011-11-16 12:00:00','2011-11-16 16:00:00','e09338789f',NULL,0,1,'Cacafuti y tal pascual',NULL),
	(108,'2012-01-23 06:00:00','2012-01-26 19:00:00','e12355137c','',1,14,'',NULL),
	(107,'2012-01-26 16:00:00','2012-01-26 20:00:00','e12355137c','',1,8,'Necesito que el santo conserje vaya a abrirme la puerta a las 15:00',NULL),
	(106,'2012-01-25 11:00:00','2012-01-25 14:00:00','e09258810e','',0,1,'',NULL),
	(111,'2012-02-06 12:00:00','2012-02-06 13:00:00','e09258810e','',0,1,'capilla a Sr. Urrea',NULL),
	(109,'2012-01-27 10:00:00','2012-01-27 13:00:00','e12355137c','',0,1,'No sé ni lo que estoy reservando',NULL),
	(110,'2012-02-03 11:30:00','2012-02-03 13:30:00','e09258810e','pepe pimto',0,1,'para tomar el té',NULL);

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
	(3,'Habitación Diego de Muros',3,'Habitación Diego de Muros',1,1,29,3,0),
	(11,'Habitación Gratiniano Nieto',3,'Habitación Gratiniano Nieto',0,0,50,3,0),
	(4,'Habitación Juan Marquina',3,'Habitación Juan Marquina',1,1,40,3,0),
	(5,'Habitacion Cardenal Mendoza',3,'Habitación privada Cardenal Mendoza (SUITE)',1,1,39,3,1),
	(6,'Paraninfo',4,'Paraninfo de la UVa',0,0,0,1,0),
	(7,'Aula Mergelina',4,'Aula Mergelina de la Facultad de Derecho',0,0,0,1,0),
	(8,'Aula Triste',3,'Aula Triste del Palacio de Santa Cruz',0,0,0,1,0),
	(9,'Capilla',3,'Capilla del Palacio de Santa Cruz',0,0,0,1,0),
	(10,'Patio',3,'Patio del Palacio de Santa Cruz',0,0,0,1,0),
	(12,'Habitación Rector Mergelina',3,'Habitación Rector Mergelina',0,0,50,3,0),
	(13,'Habitación Colegio San Bartolomé',3,'Habitación Colegio San Bartolomé',0,0,50,3,0),
	(14,'Habitación Alfonso Foncea',3,'Habitación Alfonso Foncea',0,0,50,3,0);

/*!40000 ALTER TABLE `salas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
