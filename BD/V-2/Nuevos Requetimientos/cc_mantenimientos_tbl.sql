# Host: localhost  (Version: 5.5.8)
# Date: 2015-03-19 22:02:42
# Generator: MySQL-Front 5.3  (Build 4.121)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "cc_mantenimientos_tbl"
#

CREATE TABLE `cc_mantenimientos_tbl` (
  `cc_id_fld` int(11) NOT NULL AUTO_INCREMENT,
  `cc_tipo_fld` varchar(255) DEFAULT NULL,
  `cc_placa_fld` varchar(255) DEFAULT NULL,
  `cc_fecha_fld` date DEFAULT NULL,
  `cc_proximo_fld` date DEFAULT NULL,
  `cc_kilometraje_fld` decimal(20,2) DEFAULT NULL,
  `cc_responsable_fld` varchar(255) DEFAULT NULL,
  `cc_lugar_fld` varchar(255) DEFAULT NULL,
  `cc_observaciones_fld` blob,
  `cc_estado_fld` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`cc_id_fld`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
