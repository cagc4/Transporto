# Host: localhost  (Version: 5.5.8)
# Date: 2015-03-19 22:02:56
# Generator: MySQL-Front 5.3  (Build 4.121)

/*!40101 SET NAMES utf8 */;

CREATE VIEW `cc_mantenimientos_vw` AS 
  select `cc_mantenimientos_tbl`.`cc_id_fld` AS `Identificador`,(select `cc_valores_tbl`.`cc_descripcion_fld` from `cc_valores_tbl` where ((`cc_valores_tbl`.`cc_campo_fld` = 'cc_mantenimiento_fld') and (`cc_valores_tbl`.`cc_valor_fld` = `cc_mantenimientos_tbl`.`cc_tipo_fld`))) AS `Tipo_Mantenimiento`,`cc_mantenimientos_tbl`.`cc_placa_fld` AS `Placa`,`cc_mantenimientos_tbl`.`cc_fecha_fld` AS `Fecha_Mantenimiento`,`cc_mantenimientos_tbl`.`cc_proximo_fld` AS `Proximo_Mantenimiento`,`cc_mantenimientos_tbl`.`cc_kilometraje_fld` AS `Kilometraje` from `cc_mantenimientos_tbl` where (`cc_mantenimientos_tbl`.`cc_estado_fld` = 'A');
