﻿# Host: localhost  (Version: 5.6.16)
# Date: 2014-07-29 22:11:51
# Generator: MySQL-Front 5.3  (Build 4.133)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "cc_address_tbl"
#

DROP TABLE IF EXISTS `cc_address_tbl`;
CREATE TABLE `cc_address_tbl` (
  `cc_tipo_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_nume_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_direccion_fld` varchar(255) DEFAULT NULL,
  `cc_telefono_fld` varchar(255) DEFAULT NULL,
  `cc_celular_fld` varchar(255) DEFAULT NULL,
  `cc_email_fld` varchar(255) DEFAULT NULL,
  `cc_codigoDept_fld` int(4) DEFAULT NULL,
  `cc_codCiudad_fld` int(4) DEFAULT NULL,
  PRIMARY KEY (`cc_tipo_doc_fld`,`cc_nume_doc_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_ciudad_tbl"
#

DROP TABLE IF EXISTS `cc_ciudad_tbl`;
CREATE TABLE `cc_ciudad_tbl` (
  `cc_codigoDept_fld` int(4) NOT NULL AUTO_INCREMENT,
  `cc_codCiudad_fld` int(4) NOT NULL DEFAULT '0',
  `cc_descripc_fld` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cc_codigoDept_fld`,`cc_codCiudad_fld`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

#
# Structure for table "cc_contract_tbl"
#

DROP TABLE IF EXISTS `cc_contract_tbl`;
CREATE TABLE `cc_contract_tbl` (
  `cc_id_fld` bigint(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `cc_objetoCont_fld` varchar(255) DEFAULT NULL,
  `cc_nume_doc_fld` varchar(255) DEFAULT NULL,
  `cc_placa_fld` varchar(255) DEFAULT NULL,
  `cc_numbuses_fld` int(3) DEFAULT NULL,
  `cc_numPasajeros_fld` int(11) DEFAULT NULL,
  `cc_fechaSali_fld` date DEFAULT NULL,
  `cc_fechaRegr_fld` date DEFAULT NULL,
  `cc_horaSali_fld` varchar(255) DEFAULT NULL,
  `cc_horaRegr_fld` varchar(255) DEFAULT NULL,
  `cc_origen_fld` varchar(255) DEFAULT NULL,
  `cc_destino_fld` varchar(255) DEFAULT NULL,
  `cc_dirSalida_fld` varchar(255) DEFAULT NULL,
  `cc_fechaFirma_fld` date DEFAULT NULL,
  `cc_costoContrato_fld` decimal(10,0) DEFAULT NULL,
  `cc_abono_fld` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`cc_id_fld`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Structure for table "cc_customer_tbl"
#

DROP TABLE IF EXISTS `cc_customer_tbl`;
CREATE TABLE `cc_customer_tbl` (
  `cc_tipo_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_nume_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_banco_fld` varchar(255) DEFAULT NULL,
  `cc_tipoCuenta_fld` varchar(255) DEFAULT NULL,
  `cc_numcuenta_fld` varchar(255) DEFAULT NULL,
  `cc_personacontacto_fld` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cc_tipo_doc_fld`,`cc_nume_doc_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_departamento_tbl"
#

DROP TABLE IF EXISTS `cc_departamento_tbl`;
CREATE TABLE `cc_departamento_tbl` (
  `cc_codigoDept_fld` int(4) NOT NULL AUTO_INCREMENT,
  `cc_descripc_fld` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cc_codigoDept_fld`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

#
# Structure for table "cc_documento_tbl"
#

DROP TABLE IF EXISTS `cc_documento_tbl`;
CREATE TABLE `cc_documento_tbl` (
  `cc_identificador_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_tipo_docum_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_placa_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_fecha_exp_fld` date DEFAULT NULL,
  `cc_fecha_ven_fld` date DEFAULT NULL,
  `cc_nombre_ase_fld` varchar(255) DEFAULT NULL,
  `cc_cobertura_fld` varchar(255) DEFAULT NULL,
  `cc_org_tran_fld` varchar(255) DEFAULT NULL,
  `cc_observaciones_fld` blob,
  PRIMARY KEY (`cc_identificador_fld`,`cc_tipo_docum_fld`,`cc_placa_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_fields_tbl"
#

DROP TABLE IF EXISTS `cc_fields_tbl`;
CREATE TABLE `cc_fields_tbl` (
  `cc_campo_fld` varchar(20) NOT NULL DEFAULT '',
  `cc_descripcion_fld` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cc_campo_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_formcontract_tbl"
#

DROP TABLE IF EXISTS `cc_formcontract_tbl`;
CREATE TABLE `cc_formcontract_tbl` (
  `cc_id_fld` bigint(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `cc_objetoCont_fld` varchar(255) DEFAULT NULL,
  `cc_nume_doc_fld` varchar(255) DEFAULT NULL,
  `cc_placa_fld` varchar(255) DEFAULT NULL,
  `cc_numbuses_fld` int(3) DEFAULT NULL,
  `cc_numPasajeros_fld` int(11) DEFAULT NULL,
  `cc_fechaSali_fld` date DEFAULT NULL,
  `cc_fechaRegr_fld` date DEFAULT NULL,
  `cc_horaSali_fld` varchar(255) DEFAULT NULL,
  `cc_horaRegr_fld` varchar(255) DEFAULT NULL,
  `cc_origen_fld` varchar(255) DEFAULT NULL,
  `cc_destino_fld` varchar(255) DEFAULT NULL,
  `cc_dirSalida_fld` varchar(255) DEFAULT NULL,
  `cc_escolar_fld` int(1) DEFAULT '0',
  PRIMARY KEY (`cc_id_fld`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

#
# Structure for table "cc_formocacional_tbl"
#

DROP TABLE IF EXISTS `cc_formocacional_tbl`;
CREATE TABLE `cc_formocacional_tbl` (
  `cc_id_fld` bigint(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `cc_objetoCont_fld` varchar(255) DEFAULT NULL,
  `cc_nume_doc_fld` varchar(255) DEFAULT NULL,
  `cc_placa_fld` varchar(255) DEFAULT NULL,
  `cc_numbuses_fld` int(3) DEFAULT NULL,
  `cc_numPasajeros_fld` int(11) DEFAULT NULL,
  `cc_fechaSali_fld` date DEFAULT NULL,
  `cc_fechaRegr_fld` date DEFAULT NULL,
  `cc_horaSali_fld` varchar(255) DEFAULT NULL,
  `cc_horaRegr_fld` varchar(255) DEFAULT NULL,
  `cc_origen_fld` varchar(255) DEFAULT NULL,
  `cc_destino_fld` varchar(255) DEFAULT NULL,
  `cc_dirSalida_fld` varchar(255) DEFAULT NULL,
  `cc_conductor1_fld` varchar(255) DEFAULT NULL,
  `cc_conductor2_fld` varchar(255) DEFAULT NULL,
  `CC_ENCARGADO_FLD` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cc_id_fld`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

#
# Structure for table "cc_imagenes_tbl"
#

DROP TABLE IF EXISTS `cc_imagenes_tbl`;
CREATE TABLE `cc_imagenes_tbl` (
  `cc_identificador_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_nombre_fld` varchar(255) DEFAULT NULL,
  `cc_prioridad_fld` int(2) DEFAULT NULL,
  PRIMARY KEY (`cc_identificador_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_navegacion_tbl"
#

DROP TABLE IF EXISTS `cc_navegacion_tbl`;
CREATE TABLE `cc_navegacion_tbl` (
  `cc_page_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_type_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_url_fld` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cc_page_fld`,`cc_type_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_per_veh_tbl"
#

DROP TABLE IF EXISTS `cc_per_veh_tbl`;
CREATE TABLE `cc_per_veh_tbl` (
  `cc_tipo_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_nume_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_placa_fld` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cc_tipo_doc_fld`,`cc_nume_doc_fld`,`cc_placa_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_person_tbl"
#

DROP TABLE IF EXISTS `cc_person_tbl`;
CREATE TABLE `cc_person_tbl` (
  `cc_tipo_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_nume_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_Fnombre_fld` varchar(255) DEFAULT NULL,
  `cc_fechaNac_fld` date DEFAULT NULL,
  `cc_codCiudad_fld` int(4) DEFAULT NULL,
  `cc_detalles_fld` blob,
  PRIMARY KEY (`cc_tipo_doc_fld`,`cc_nume_doc_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_propcond_tbl"
#

DROP TABLE IF EXISTS `cc_propcond_tbl`;
CREATE TABLE `cc_propcond_tbl` (
  `cc_tipo_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_nume_doc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_type_pc_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_banco_fld` varchar(255) DEFAULT NULL,
  `cc_tipoCuenta_fld` varchar(255) DEFAULT NULL,
  `cc_numcuenta_fld` varchar(255) DEFAULT NULL,
  `cc_catLicencia_fld` varchar(255) DEFAULT NULL,
  `cc_numLicencia_fld` varchar(255) DEFAULT NULL,
  `cc_fchVencLicencia_fld` datetime DEFAULT NULL,
  PRIMARY KEY (`cc_tipo_doc_fld`,`cc_nume_doc_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_user_tbl"
#

DROP TABLE IF EXISTS `cc_user_tbl`;
CREATE TABLE `cc_user_tbl` (
  `CC_USER_ID_FLD` varchar(30) NOT NULL DEFAULT '',
  `CC_PSSWRD_FLD` varchar(32) DEFAULT NULL,
  `cc_role_fld` varchar(255) DEFAULT NULL,
  `cc_estado_fld` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`CC_USER_ID_FLD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_valores_tbl"
#

DROP TABLE IF EXISTS `cc_valores_tbl`;
CREATE TABLE `cc_valores_tbl` (
  `cc_campo_fld` varchar(20) NOT NULL DEFAULT '',
  `cc_valor_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_descripcion_fld` varchar(255) DEFAULT NULL,
  `cc_estado_fld` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`cc_campo_fld`,`cc_valor_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Structure for table "cc_vehicle_tbl"
#

DROP TABLE IF EXISTS `cc_vehicle_tbl`;
CREATE TABLE `cc_vehicle_tbl` (
  `cc_placa_fld` varchar(255) NOT NULL DEFAULT '',
  `cc_codigoInterno_fld` varchar(255) DEFAULT NULL,
  `cc_marca_fld` varchar(255) DEFAULT NULL,
  `cc_modelo_fld` varchar(255) DEFAULT NULL,
  `cc_clase_fld` varchar(255) DEFAULT NULL,
  `cc_tipo_fld` varchar(255) DEFAULT NULL,
  `cc_capacidad_fld` varchar(255) DEFAULT NULL,
  `cc_num_motor_fld` varchar(255) DEFAULT NULL,
  `cc_num_chasis_fld` varchar(255) DEFAULT NULL,
  `cc_lin_cilindr_fld` varchar(255) DEFAULT NULL,
  `cc_color_fld` varchar(255) DEFAULT NULL,
  `cc_detalles_fld` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cc_placa_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP VIEW IF EXISTS `cc_contract_vw`;
CREATE VIEW `cc_contract_vw` AS 
  select `transporto`.`cc_contract_tbl`.`cc_id_fld` AS `Consecutivo`,`transporto`.`cc_contract_tbl`.`cc_objetoCont_fld` AS `Objeto_Contrato`,`transporto`.`cc_contract_tbl`.`cc_nume_doc_fld` AS `Numero_Documento`,`transporto`.`cc_contract_tbl`.`cc_placa_fld` AS `Placa`,`transporto`.`cc_contract_tbl`.`cc_numbuses_fld` AS `Numero_Buses`,`transporto`.`cc_contract_tbl`.`cc_fechaSali_fld` AS `Fecha_Salida`,`transporto`.`cc_contract_tbl`.`cc_fechaRegr_fld` AS `Fecha_Regreso`,`transporto`.`cc_contract_tbl`.`cc_horaSali_fld` AS `Hora_Salida`,`transporto`.`cc_contract_tbl`.`cc_horaRegr_fld` AS `Hora_Regreso`,`transporto`.`cc_contract_tbl`.`cc_origen_fld` AS `Origen`,`transporto`.`cc_contract_tbl`.`cc_destino_fld` AS `Destino`,`transporto`.`cc_contract_tbl`.`cc_dirSalida_fld` AS `Direccion_Salida` from `transporto`.`cc_contract_tbl`;

DROP VIEW IF EXISTS `cc_customer_vw`;
CREATE VIEW `cc_customer_vw` AS 
  select (select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_tipo_doc_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `cus`.`cc_tipo_doc_fld`))) AS `Tipo_Identificacion`,`cus`.`cc_nume_doc_fld` AS `Numero_Documento`,`per`.`cc_Fnombre_fld` AS `Nombre`,`per`.`cc_fechaNac_fld` AS `Fecha_Nacimiento`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_banco_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `cus`.`cc_banco_fld`))) AS `Banco`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_tipoCuenta_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `cus`.`cc_tipoCuenta_fld`))) AS `Tipo_Cuenta`,`cus`.`cc_numcuenta_fld` AS `Numero_Cuenta`,`adr`.`cc_direccion_fld` AS `Direccion`,`adr`.`cc_telefono_fld` AS `Telefono`,`adr`.`cc_celular_fld` AS `Celular`,`adr`.`cc_email_fld` AS `Email`,`dep`.`cc_descripc_fld` AS `Departamento`,`cit`.`cc_descripc_fld` AS `Ciudad` from ((`transporto`.`cc_customer_tbl` `cus` join `transporto`.`cc_person_tbl` `per`) left join ((`transporto`.`cc_address_tbl` `adr` join `transporto`.`cc_departamento_tbl` `dep`) join `transporto`.`cc_ciudad_tbl` `cit`) on(((`per`.`cc_tipo_doc_fld` = `adr`.`cc_tipo_doc_fld`) and (`per`.`cc_nume_doc_fld` = `adr`.`cc_nume_doc_fld`) and (`adr`.`cc_codigoDept_fld` = `dep`.`cc_codigoDept_fld`) and (`adr`.`cc_codigoDept_fld` = `cit`.`cc_codigoDept_fld`) and (`adr`.`cc_codCiudad_fld` = `cit`.`cc_codCiudad_fld`)))) where ((`cus`.`cc_tipo_doc_fld` = `per`.`cc_tipo_doc_fld`) and (`cus`.`cc_nume_doc_fld` = `per`.`cc_nume_doc_fld`));

DROP VIEW IF EXISTS `cc_documentos_vw`;
CREATE VIEW `cc_documentos_vw` AS 
  select (case when ((to_days(`a`.`cc_fecha_ven_fld`) - to_days(curdate())) < 0) then concat((to_days(`a`.`cc_fecha_ven_fld`) - to_days(curdate())),' dias - Vencido') when (((to_days(`a`.`cc_fecha_ven_fld`) - to_days(curdate())) >= 1) and ((to_days(`a`.`cc_fecha_ven_fld`) - to_days(curdate())) <= 30)) then concat((to_days(`a`.`cc_fecha_ven_fld`) - to_days(curdate())),' dias - Por vencer') else concat((to_days(`a`.`cc_fecha_ven_fld`) - to_days(curdate())),' dias - Vigente') end) AS `Estado`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_tipo_docum_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `a`.`cc_tipo_docum_fld`))) AS `Documento`,`a`.`cc_identificador_fld` AS `Numero`,`a`.`cc_placa_fld` AS `Placa`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_tipo_doc_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `c`.`cc_tipo_doc_fld`))) AS `Tipo_Identificacion`,`c`.`cc_nume_doc_fld` AS `Numero_Documento`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_type_pc_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `c`.`cc_type_pc_fld`))) AS `Tipo_Persona`,`a`.`cc_fecha_exp_fld` AS `Fecha_Expedicion`,`a`.`cc_fecha_ven_fld` AS `Fecha_Vencimiento`,`a`.`cc_cobertura_fld` AS `Cobertura`,`a`.`cc_org_tran_fld` AS `Organismo_Transito`,`a`.`cc_observaciones_fld` AS `Observaciones` from (((`transporto`.`cc_documento_tbl` `a` join `transporto`.`cc_per_veh_tbl` `b`) join `transporto`.`cc_propcond_tbl` `c`) join `transporto`.`cc_person_tbl` `d`) where ((`a`.`cc_placa_fld` = `b`.`cc_placa_fld`) and (`b`.`cc_tipo_doc_fld` = `c`.`cc_tipo_doc_fld`) and (`b`.`cc_nume_doc_fld` = `c`.`cc_nume_doc_fld`) and (`c`.`cc_tipo_doc_fld` = `d`.`cc_tipo_doc_fld`) and (`c`.`cc_nume_doc_fld` = `d`.`cc_nume_doc_fld`) and (`c`.`cc_type_pc_fld` = 1)) order by 1;

DROP VIEW IF EXISTS `cc_formcontract_vw`;
CREATE VIEW `cc_formcontract_vw` AS 
  select `transporto`.`cc_formcontract_tbl`.`cc_id_fld` AS `Consecutivo`,`transporto`.`cc_formcontract_tbl`.`cc_objetoCont_fld` AS `Objeto_Contrato`,`transporto`.`cc_formcontract_tbl`.`cc_nume_doc_fld` AS `Numero_Documento`,`transporto`.`cc_formcontract_tbl`.`cc_placa_fld` AS `Placa`,`transporto`.`cc_formcontract_tbl`.`cc_numbuses_fld` AS `Numero_Buses`,`transporto`.`cc_formcontract_tbl`.`cc_fechaSali_fld` AS `Fecha_Salida`,`transporto`.`cc_formcontract_tbl`.`cc_fechaRegr_fld` AS `Fecha_Regreso`,`transporto`.`cc_formcontract_tbl`.`cc_horaSali_fld` AS `Hora_Salida`,`transporto`.`cc_formcontract_tbl`.`cc_horaRegr_fld` AS `Hora_Regreso`,`transporto`.`cc_formcontract_tbl`.`cc_origen_fld` AS `Origen`,`transporto`.`cc_formcontract_tbl`.`cc_destino_fld` AS `Destino`,`transporto`.`cc_formcontract_tbl`.`cc_dirSalida_fld` AS `Direccion_Salida` from `transporto`.`cc_formcontract_tbl`;

DROP VIEW IF EXISTS `cc_formocacional_vw`;
CREATE VIEW `cc_formocacional_vw` AS 
  select `transporto`.`cc_formocacional_tbl`.`cc_id_fld` AS `Consecutivo`,`transporto`.`cc_formocacional_tbl`.`cc_objetoCont_fld` AS `Objeto_Contrato`,`transporto`.`cc_formocacional_tbl`.`cc_nume_doc_fld` AS `Numero_Documento`,`transporto`.`cc_formocacional_tbl`.`cc_placa_fld` AS `Placa`,`transporto`.`cc_formocacional_tbl`.`cc_numbuses_fld` AS `Numero_Buses`,`transporto`.`cc_formocacional_tbl`.`cc_fechaSali_fld` AS `Fecha_Salida`,`transporto`.`cc_formocacional_tbl`.`cc_fechaRegr_fld` AS `Fecha_Regreso`,`transporto`.`cc_formocacional_tbl`.`cc_horaSali_fld` AS `Hora_Salida`,`transporto`.`cc_formocacional_tbl`.`cc_horaRegr_fld` AS `Hora_Regreso`,`transporto`.`cc_formocacional_tbl`.`cc_origen_fld` AS `Origen`,`transporto`.`cc_formocacional_tbl`.`cc_destino_fld` AS `Destino`,`transporto`.`cc_formocacional_tbl`.`cc_dirSalida_fld` AS `Direccion_Salida` from `transporto`.`cc_formocacional_tbl`;

DROP VIEW IF EXISTS `cc_prodcon_vw`;
CREATE VIEW `cc_prodcon_vw` AS 
  select (select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_tipo_doc_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `per`.`cc_tipo_doc_fld`))) AS `Tipo_Identificacion`,`per`.`cc_nume_doc_fld` AS `Numero_Documento`,`per`.`cc_Fnombre_fld` AS `Nombre`,`per`.`cc_fechaNac_fld` AS `Fecha_Nacimiento`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_type_pc_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `pp`.`cc_type_pc_fld`))) AS `Tipo`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_banco_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `pp`.`cc_banco_fld`))) AS `Banco`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_tipoCuenta_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `pp`.`cc_tipoCuenta_fld`))) AS `Tipo_Cuenta`,`pp`.`cc_numcuenta_fld` AS `Numero_de_Cuenta`,`adr`.`cc_direccion_fld` AS `Direccion`,`adr`.`cc_telefono_fld` AS `Telefono`,`adr`.`cc_celular_fld` AS `Celular`,`adr`.`cc_email_fld` AS `Email`,`dep`.`cc_descripc_fld` AS `Departamento`,`cit`.`cc_descripc_fld` AS `Ciudad` from ((`transporto`.`cc_propcond_tbl` `pp` join `transporto`.`cc_person_tbl` `per`) left join ((`transporto`.`cc_address_tbl` `adr` join `transporto`.`cc_departamento_tbl` `dep`) join `transporto`.`cc_ciudad_tbl` `cit`) on(((`per`.`cc_tipo_doc_fld` = `adr`.`cc_tipo_doc_fld`) and (`per`.`cc_nume_doc_fld` = `adr`.`cc_nume_doc_fld`) and (`adr`.`cc_codigoDept_fld` = `dep`.`cc_codigoDept_fld`) and (`adr`.`cc_codigoDept_fld` = `cit`.`cc_codigoDept_fld`) and (`adr`.`cc_codCiudad_fld` = `cit`.`cc_codCiudad_fld`)))) where ((`pp`.`cc_tipo_doc_fld` = `per`.`cc_tipo_doc_fld`) and (`pp`.`cc_nume_doc_fld` = `per`.`cc_nume_doc_fld`));

DROP VIEW IF EXISTS `cc_users_vw`;
CREATE VIEW `cc_users_vw` AS 
  select `a`.`CC_USER_ID_FLD` AS `Usuario`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_role_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `a`.`cc_role_fld`))) AS `Role`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_estado_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `a`.`cc_estado_fld`))) AS `Estado` from `transporto`.`cc_user_tbl` `a`;

DROP VIEW IF EXISTS `cc_valores_vw`;
CREATE VIEW `cc_valores_vw` AS 
  select `b`.`cc_descripcion_fld` AS `Campo`,`a`.`cc_valor_fld` AS `Valor`,`a`.`cc_descripcion_fld` AS `Descripcion`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_state_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `a`.`cc_estado_fld`))) AS `Estado` from (`transporto`.`cc_valores_tbl` `a` join `transporto`.`cc_fields_tbl` `b`) where (`a`.`cc_campo_fld` = `b`.`cc_campo_fld`);

DROP VIEW IF EXISTS `cc_vehicle_vw`;
CREATE VIEW `cc_vehicle_vw` AS 
  select `a`.`cc_placa_fld` AS `Placa`,`a`.`cc_codigoInterno_fld` AS `Codigo_Interno`,`d`.`cc_tipo_doc_fld` AS `Tipo_Identificacion`,`d`.`cc_nume_doc_fld` AS `Numero_Documento`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_type_pc_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `c`.`cc_type_pc_fld`))) AS `Tipo_Persona`,`a`.`cc_modelo_fld` AS `Modelo`,(select `transporto`.`cc_valores_tbl`.`cc_descripcion_fld` from `transporto`.`cc_valores_tbl` where ((`transporto`.`cc_valores_tbl`.`cc_campo_fld` = 'cc_clase_fld') and (`transporto`.`cc_valores_tbl`.`cc_valor_fld` = `a`.`cc_clase_fld`))) AS `Tipo`,`a`.`cc_capacidad_fld` AS `Capacidad` from (((`transporto`.`cc_vehicle_tbl` `a` join `transporto`.`cc_per_veh_tbl` `b`) join `transporto`.`cc_propcond_tbl` `c`) join `transporto`.`cc_person_tbl` `d`) where ((`a`.`cc_placa_fld` = `b`.`cc_placa_fld`) and (`b`.`cc_tipo_doc_fld` = `c`.`cc_tipo_doc_fld`) and (`b`.`cc_nume_doc_fld` = `c`.`cc_nume_doc_fld`) and (`c`.`cc_tipo_doc_fld` = `d`.`cc_tipo_doc_fld`) and (`c`.`cc_nume_doc_fld` = `d`.`cc_nume_doc_fld`) and (`c`.`cc_type_pc_fld` = '01')) order by 1;