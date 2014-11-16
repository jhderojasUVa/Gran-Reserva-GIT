# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.49)
# Database: gran_reserva
# Generation Time: 2011-10-14 13:33:09 +0200
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
	(1,'2011-10-10 09:00:00','2011-10-10 09:30:00','e09338789f',0,1,'Testo di testa.\nTesto di testa la pesta.'),
	(2,'2011-09-10 09:00:00','2011-09-30 09:00:00','e09338789f',0,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed commodo, est vitae luctus placerat, metus ante dignissim nisi, in suscipit tortor quam nec nisl. Maecenas commodo nulla in tortor mattis ut ultricies velit bibendum. Nullam dui nunc, malesuada ac gravida id, mollis non sapien. Suspendisse potenti. Sed commodo sapien et quam egestas tincidunt. Aliquam diam libero, lobortis sed consectetur et, convallis id metus. Ut massa enim, ornare id eleifend ut, elementum eu justo. Sed at pretium nisl. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam in arcu ipsum. Nunc non velit id eros molestie porta at vel elit. Duis nisi elit, pulvinar quis aliquet ut, ullamcorper vitae ante.'),
	(3,'2011-09-27 09:00:00','2011-09-27 10:00:00','e09338789f',0,1,'Integer vitae arcu erat. Curabitur a orci quis orci sodales sollicitudin. Pellentesque in enim leo. Phasellus placerat ultricies arcu, eget luctus quam faucibus vitae. Phasellus sodales tristique massa ac suscipit. Donec tempor, tortor at fringilla dictum, lacus eros ultrices mi, in tempus mi sapien sed lacus. Donec pulvinar rutrum ante id malesuada. Vivamus bibendum commodo dolor, id adipiscing ipsum pretium vitae. Nunc congue iaculis lectus non posuere. Nullam est enim, tristique pretium commodo vel, suscipit sit amet mauris. Cras placerat, massa eget luctus tristique, massa turpis viverra dui, a consectetur nulla mi sit amet felis. Nullam aliquam, dolor vel vulputate adipiscing, orci quam tristique quam, vel rhoncus tortor nunc scelerisque erat. Nulla ultricies aliquet congue.'),
	(4,'2011-10-05 11:00:00','2011-10-05 12:00:00','e09338789f',0,1,'Esto es un texto de ejemplo'),
	(5,'2011-10-06 11:00:00','2011-10-06 13:00:00','e09338789f',0,1,'Cooococococococo'),
	(18,'2011-10-10 11:00:00','2011-10-10 12:00:00','e09338789f',0,1,'sdfklgnusdñoig7vsñeorituaño7xbñxo<8b7cilrt67vbl<ku ytlUYÑEi867vbñ48<7ÑB(/ñOIUv87bñr687'),
	(17,'2011-10-09 17:00:00','2011-10-09 18:00:00','e09338789f',0,1,'cacacacaca'),
	(16,'2011-10-12 09:00:00','2011-10-12 10:00:00','e09338789f',0,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed commodo, est vitae luctus placerat, metus ante dignissim nisi, in suscipit tortor quam nec nisl. Maecenas commodo nulla in tortor mattis ut ultricies velit bibendum. Nullam dui nunc, malesuada ac gravida id, mollis non sapien. Suspendisse potenti. Sed commodo sapien et quam egestas tincidunt. Aliquam diam libero, lobortis sed consectetur et, convallis id metus. Ut massa enim, ornare id eleifend ut, elementum eu justo. Sed at pretium nisl. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam in arcu ipsum. Nunc non velit id eros molestie porta at vel elit. Duis nisi elit, pulvinar quis aliquet ut, ullamcorper vitae ante.'),
	(19,'2011-10-13 12:00:00','2011-10-13 15:00:00','e09338789f',0,1,'This a test andercor o algo asin 2'),
	(20,'2011-10-15 09:00:00','2011-10-15 11:00:00','e09338789f',0,1,'Hot stuff!'),
	(21,'2011-10-14 13:00:00','2011-10-14 16:00:00','e09338789f',0,1,'I guan your jot tuff');

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
	(1,'Salon grande 1',1,'Esto es una prueba',0,1,NULL,1);

/*!40000 ALTER TABLE `salas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
