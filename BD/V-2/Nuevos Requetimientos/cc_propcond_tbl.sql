# Host: localhost  (Version: 5.5.8)
# Date: 2015-03-17 22:49:45
# Generator: MySQL-Front 5.3  (Build 4.121)

/*!40101 SET NAMES utf8 */;

#
# Alter Structure for table "cc_propcond_tbl"
#

ALTER TABLE `cc_propcond_tbl` 
  ADD `cc_eps_fld` varchar(2) DEFAULT NULL,
  ADD `cc_arl_fld` varchar(2) DEFAULT NULL,
  ADD `cc_pensiones_cesantias_fld` varchar(2) DEFAULT NULL,
  ADD `cc_centro_reconocimiento_fld` varchar(255) DEFAULT NULL,
);
