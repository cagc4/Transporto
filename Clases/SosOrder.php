<?php

class SosOrder
{
	var $util;
	var $result;

	function SosOrder()
	{
		$this->util = new Utilities();
	}

	function addSosOrder($sosData) {
		$respCode = 0;
		$sosPatientData = $sosData->sosFormPatientData->sosFormPatient;
		$sosSourceData = $sosData->sosFormSourceData->sosFormSource;
		$sosDestination1Data = $sosData->sosFormDestination1Data->sosFormDestination1;
		$sosDestination2Data = $sosData->sosFormDestination2Data->sosFormDestination2;
		$sosDriverVehicleData = $sosData->sosFormDriverVehicleData->sosFormDriverVehicle;
		
		if($sosDriverVehicleData->plate != '') {
			$this->result = $this->util->db->Execute("SELECT cc_placa_fld FROM cc_vehicle_tbl WHERE cc_placa_fld = '" . $sosDriverVehicleData->plate . "'");
			$result = $this->result->FetchRow();
			if(!$result) {
				$respCode = 1;
			}
		}
        
        if($respCode == 0) {
			if($sosPatientData->docTypePatient != '' && $sosPatientData->docNumPatient != '') {
				$this->result = $this->util->db->Execute("SELECT * FROM cc_paciente_tbl WHERE cc_tipo_doc_fld = '" . $sosPatientData->docTypePatient . "' AND
																							  cc_nume_doc_fld = '" . $sosPatientData->docNumPatient . "'");
				$result = $this->result->FetchRow();
				if(!$result) {
					$respCode = 2;
				}
			}
		}
        
	   if($respCode == 0) {
			if($sosPatientData->docTypeCompanion != '' && $sosPatientData->docNumCompanion != '') {
				$this->result = $this->util->db->Execute("SELECT * FROM cc_acompanante_tbl WHERE cc_tipo_doc_fld = '" . $sosPatientData->docTypeCompanion . "' AND
																								 cc_nume_doc_fld = '" . $sosPatientData->docNumCompanion . "'");
				$result = $this->result->FetchRow();
				if(!$result) {
					$respCode = 3;
				}
				else {
					if($sosPatientData->relationship != '') {
						$this->result = $this->util->db->Execute("SELECT * FROM cc_pac_acomp_tbl WHERE cc_tipo_doc_fld = '" . $sosPatientData->docTypePatient . "' AND
																									   cc_nume_doc_fld = '" . $sosPatientData->docNumPatient . "' AND
																									   cc_tipo_doc_a_fld = '" . $sosPatientData->docTypeCompanion . "' AND
																									   cc_nume_doc_a_fld = '" . $sosPatientData->docNumCompanion . "'");
						$result = $this->result->FetchRow();
						if($result) {
							$this->util->db->Execute("UPDATE cc_pac_acomp_tbl SET cc_parentezco_fld = '" . $sosPatientData->relationship . "' 
																			WHERE cc_tipo_doc_fld = '" . $sosPatientData->docTypePatient . "' AND
																				  cc_nume_doc_fld = '" . $sosPatientData->docNumPatient . "' AND
																				  cc_tipo_doc_a_fld = '" . $sosPatientData->docTypeCompanion . "' AND
																				  cc_nume_doc_a_fld = '" . $sosPatientData->docNumCompanion ."'");
						}
						else {
                            
                            $this->result =$this->util->db->Execute("INSERT INTO cc_pac_acomp_tbl VALUES('".$sosPatientData->docTypePatient."',
                                                                                                         '".$sosPatientData->docNumPatient."',
                                                                                                         '".$sosPatientData->docTypeCompanion."',
                                                                                                         '".$sosPatientData->docNumCompanion."',
                                                                                                         '" .$sosPatientData->relationship."')");
						       
                        }
					}
					else {
						//$respCode = 4;
					}
				}
			}
		}
        
        if($respCode == 0) {
			if($sosDriverVehicleData->docTypeDriver != '' && $sosDriverVehicleData->docNumDriver != '') {
				$this->result = $this->util->db->Execute("SELECT * FROM cc_propcond_tbl WHERE cc_tipo_doc_fld = '" . $sosDriverVehicleData->docTypeDriver . "' AND
																							  cc_nume_doc_fld = '" . $sosDriverVehicleData->docNumDriver . "' AND
																							  cc_type_pc_fld in ('01','02')");
				$result = $this->result->FetchRow();
				if(!$result) {
					$respCode = 5;
				}
			}
		}
		if($respCode == 0) {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$_SESSION['number'] = $result['number'];
			$this->result = $this->util->db->Execute("INSERT INTO cc_sos_orden_tbl VALUES (0, '" . $sosPatientData->authNumber . "',
																						      '" . $sosPatientData->docTypePatient . "',
																							  '" . $sosPatientData->docNumPatient . "',
																						 	  '" . $sosPatientData->docTypeCompanion . "',
																						 	  '" . $sosPatientData->docNumCompanion . "',
																						 	  '" . $sosSourceData->source . "',
																						 	  '" . $sosSourceData->phone . "',
																							  STR_TO_DATE('".$sosSourceData->collectDate->month."/".$sosSourceData->collectDate->day."/".$sosSourceData->collectDate->year."','%m/%d/%Y'),
																						 	  '" . $sosSourceData->collectTime . "',
																						 	  '" . $sosDestination1Data->destination1 . "',
																							  STR_TO_DATE('".$sosDestination1Data->outputDate1->month."/".$sosDestination1Data->outputDate1->day."/".$sosDestination1Data->outputDate1->year."','%m/%d/%Y'),
																						 	  '" . $sosDestination1Data->time1 . "',
																							  '" . $sosDestination1Data->cost1 . "',
																						 	  '" . $sosDestination2Data->destination2 . "',
																							  STR_TO_DATE('".$sosDestination2Data->outputDate2->month."/".$sosDestination2Data->outputDate2->day."/".$sosDestination2Data->outputDate2->year."','%m/%d/%Y'),
																						 	  '" . $sosDestination2Data->time2 . "',
																						 	  '" . $sosDestination2Data->cost2 . "',
																						 	  '" . $sosDriverVehicleData->plate . "',
																						 	  '" . $sosDriverVehicleData->docTypeDriver . "',
																						 	  '" . $sosDriverVehicleData->docNumDriver . "')");
			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM cc_sos_orden_tbl WHERE cc_id_fld = ".$_SESSION['number']);
				$respCode = 99;
			}
		}
		return $respCode;
	}

	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'cc_sos_orden_tbl'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM DUAL");
	}
	
	function copySosOrder($numeroSosOrder) {
		$respCode = 0;
		$this->result = $this->util->db->Execute("INSERT INTO cc_sos_orden_tbl (SELECT 0,
																					   cc_id_autoriza_fld AS authNumber,
																					   cc_tipo_doc_fld AS docTypePatient,
																					   cc_nume_doc_fld AS docNumPatient,
																					   cc_tipo_doc_a_fld AS docTypeCompanion,
																					   cc_nume_doc_a_fld AS docNumCompanion,
																					   cc_origen_fld AS source,
																					   cc_telefono_fld AS phone,
																					   cc_fecha_fld AS collectDate,	
																					   cc_hora_fld AS collectTime,
																					   cc_destino_fld AS destination1,
																					   cc_fecha_d_fld AS outputDate1,
																					   cc_hora_d_fld AS time1,
																					   cc_servicio1_fld AS cost1,
																					   cc_destino2_fld AS destination2,
																					   cc_fecha_d2_fld AS outputDate2,
																					   cc_hora_d2_fld AS time2,
																					   cc_servicio2_fld AS cost2,
																					   cc_placa_fld AS plate,
																					   cc_tipo_doc_c_fld AS docTypeDriver,
																					   cc_nume_doc_c_fld AS docNumDriver
																				FROM cc_sos_orden_tbl WHERE cc_id_fld = '".$numeroSosOrder."')");
		if(!$this->result) {
			$respCode = 99;
		}
		else {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$_SESSION['number'] = $result['number'] - 1;
		}
		return $respCode;		
	}
	
	function modifySosOrder($sosData, $numeroSosOrder) {
		$respCode = 0;
		$sosPatientData = $sosData->sosFormPatientData->sosFormPatient;
		$sosSourceData = $sosData->sosFormSourceData->sosFormSource;
		$sosDestination1Data = $sosData->sosFormDestination1Data->sosFormDestination1;
		$sosDestination2Data = $sosData->sosFormDestination2Data->sosFormDestination2;
		$sosDriverVehicleData = $sosData->sosFormDriverVehicleData->sosFormDriverVehicle;
		/*
		if($sosDriverVehicleData->plate != '') {
			$this->result = $this->util->db->Execute("SELECT cc_placa_fld FROM cc_vehicle_tbl WHERE cc_placa_fld = '" . $sosDriverVehicleData->plate . "'");
			$result = $this->result->FetchRow();
			if(!$result) {
				$respCode = 1;
			}
		}
		if($respCode == 0) {
			if($sosPatientData->docTypePatient != '' && $sosPatientData->docNumPatient != '') {
				$this->result = $this->util->db->Execute("SELECT * FROM cc_paciente_tbl WHERE cc_tipo_doc_fld = '" . $sosPatientData->docTypePatient . "' AND
																							  cc_nume_doc_fld = '" . $sosPatientData->docNumPatient . "'");
				$result = $this->result->FetchRow();
				if(!$result) {
					$respCode = 2;
				}
			}
		}
		if($respCode == 0) {
			if($sosPatientData->docTypeCompanion != '' && $sosPatientData->docNumCompanion != '') {
				$this->result = $this->util->db->Execute("SELECT * FROM cc_acompanante_tbl WHERE cc_tipo_doc_fld = '" . $sosPatientData->docTypeCompanion . "' AND
																								 cc_nume_doc_fld = '" . $sosPatientData->docNumCompanion . "'");
				$result = $this->result->FetchRow();
				if(!$result) {
					$respCode = 3;
				}
				else {
					if($sosPatientData->relationship != '') {
						$this->result = $this->util->db->Execute("SELECT * FROM cc_pac_acomp_tbl WHERE cc_tipo_doc_fld = '" . $sosPatientData->docTypePatient . "' AND
																									   cc_nume_doc_fld = '" . $sosPatientData->docNumPatient . "' AND
																									   cc_tipo_doc_a_fld = '" . $sosPatientData->docTypeCompanion . "' AND
																									   cc_nume_doc_a_fld = '" . $sosPatientData->docNumCompanion . "'");
						$result = $this->result->FetchRow();
						if($result) {
							$this->util->db->Execute("UPDATE cc_pac_acomp_tbl SET cc_parentezco_fld = '" . $sosPatientData->relationship . "' 
																			WHERE cc_tipo_doc_fld = '" . $sosPatientData->docTypePatient . "' AND
																				  cc_nume_doc_fld = '" . $sosPatientData->docNumPatient . "' AND
																				  cc_tipo_doc_a_fld = '" . $sosPatientData->docTypeCompanion . "' AND
																				  cc_nume_doc_a_fld = '" . $sosPatientData->docNumCompanion . "'");
						}
						else {
							$this->util->db->Execute("INSERT INTO cc_pac_acomp_tbl VALUES('" . $sosPatientData->docTypePatient . "',
																						  '" . $sosPatientData->docNumPatient . "',
																						  '" . $sosPatientData->docTypeCompanion . "',
																						  '" . $sosPatientData->docNumCompanion . "',
																						  '" . $sosPatientData->relationship . "'");
						}
					}
					else {
						$respCode = 4;
					}
				}
			}
		}
		if($respCode == 0) {
			if($sosDriverVehicleData->docTypeDriver != '' && $sosDriverVehicleData->docNumDriver != '') {
				$this->result = $this->util->db->Execute("SELECT * FROM cc_propcond_tbl WHERE cc_tipo_doc_fld = '" . $sosDriverVehicleData->docTypeDriver . "' AND
																							  cc_nume_doc_fld = '" . $sosDriverVehicleData->docNumDriver . "' AND
																							  cc_type_pc_fld in ('01','02')");
				$result = $this->result->FetchRow();
				if(!$result) {
					$respCode = 5;
				}
			}
		}*/
		if($respCode == 0) {
			$this->result = $this->util->db->Execute("update table cc_sos_orden_tbl set cc_id_autoriza_fld = '" . $sosPatientData->authNumber . "',
																						cc_tipo_doc_fld = '" . $sosPatientData->docTypePatient . "',
																				  		cc_nume_doc_fld = '" . $sosPatientData->docNumPatient . "',
																				  		cc_tipo_doc_a_fld = '" . $sosPatientData->docTypeCompanion . "',
																				  		cc_nume_doc_a_fld = '" . $sosPatientData->docNumCompanion . "',
																				  		cc_origen_fld = '" . $sosSourceData->source . "',
																				  		cc_telefono_fld = '" . $sosSourceData->phone . "',
																				  		cc_fecha_fld = STR_TO_DATE('".$sosSourceData->collectDate->month."/".$sosSourceData->collectDate->day."/".$sosSourceData->collectDate->year."','%m/%d/%Y'),
																				  		cc_hora_fld = '" . $sosSourceData->collectTime . "',
																				  		cc_destino_fld = '" . $sosDestination1Data->destination1 . "',
																				  		cc_fecha_d_fld = STR_TO_DATE('".$sosDestination1Data->outputDate1->month."/".$sosDestination1Data->outputDate1->day."/".$sosDestination1Data->outputDate1->year."','%m/%d/%Y'),
																				  		cc_hora_d_fld = '" . $sosDestination1Data->time1 . "',
																				  		cc_servicio1_fld = '" . $sosDestination1Data->cost1 . "',
																				  		cc_destino2_fld = '" . $sosDestination2Data->destination2 . "',
																				  		cc_fecha_d2_fld = STR_TO_DATE('".$sosDestination2Data->outputDate2->month."/".$sosDestination2Data->outputDate2->day."/".$sosDestination2Data->outputDate2->year."','%m/%d/%Y'),
																				  		cc_hora_d2_fld = '" . $sosDestination2Data->time2 . "',
																				  		cc_servicio2_fld = '" . $sosDestination2Data->cost2 . "',
																				  		cc_placa_fld = '" . $sosDriverVehicleData->plate . "',
																				  		cc_tipo_doc_c_fld = '" . $sosDriverVehicleData->docTypeDriver . "',
																				  		cc_nume_doc_c_fld = '" . $sosDriverVehicleData->docNumDriver . "'
														where	cc_id_fld = '".$numeroSosOrder."'");
			if(!$this->result) {
				$respCode = 99;
			}
		}
	}
	
	function getSosOrderReport($numeroSosOrder) {
		$this->result = $this->util->db->Execute("select  
                                                    sos.cc_id_autoriza_fld AS authNumber
                                                    ,upper(sos.cc_tipo_doc_fld) AS docTypePatient
                                                    ,sos.cc_nume_doc_fld AS docNumPatient
                                                    ,(select concat(pc.cc_nombre_fld, ' ', pc.cc_apellido_fld) from cc_paciente_tbl pc where pc.cc_tipo_doc_fld = sos.cc_tipo_doc_fld  AND pc.cc_nume_doc_fld = sos.cc_nume_doc_fld ) AS patient
                                                    ,upper(sos.cc_tipo_doc_a_fld) AS docTypeCompanion
                                                    ,sos.cc_nume_doc_a_fld AS docNumCompanion
                                                    ,concat((select concat(pc.cc_nombre_fld, ' ', pc.cc_apellido_fld) from cc_acompanante_tbl pc where pc.cc_tipo_doc_fld = sos.cc_tipo_doc_a_fld  AND pc.cc_nume_doc_fld = sos.cc_nume_doc_a_fld ), ' - ', (select cc_descripcion_fld from cc_valores_tbl where cc_campo_fld = 'cc_parentezco_fld' and cc_valor_fld = (select cc_parentezco_fld from cc_pac_acomp_tbl where cc_tipo_doc_fld = sos.cc_tipo_doc_fld AND cc_nume_doc_fld = sos.cc_nume_doc_fld AND cc_tipo_doc_a_fld = sos.cc_tipo_doc_a_fld AND cc_nume_doc_a_fld = sos.cc_nume_doc_a_fld))) AS companion
                                                    ,sos.cc_origen_fld AS source
                                                    ,sos.cc_telefono_fld AS phone
                                                    ,concat(DATE_FORMAT(sos.cc_fecha_fld, '%Y-%m-%d'), ' ', sos.cc_hora_fld) AS collectDate
                                                    ,sos.cc_destino_fld AS destination1
                                                    ,concat(DATE_FORMAT(sos.cc_fecha_d_fld, '%Y-%m-%d'), ' ', sos.cc_hora_d_fld) AS outputDate1
                                                    ,sos.cc_servicio1_fld AS cost1
                                                    ,sos.cc_destino2_fld AS destination2
                                                    ,concat(DATE_FORMAT(sos.cc_fecha_d2_fld, '%Y-%m-%d'), ' ', sos.cc_hora_d2_fld) AS outputDate2
                                                    ,sos.cc_servicio2_fld AS cost2
                                                    ,sos.cc_placa_fld AS plate
                                                    ,(select pr.cc_Fnombre_fld from cc_propcond_tbl drv inner join cc_person_tbl pr on drv.cc_tipo_doc_fld = pr.cc_tipo_doc_fld and drv.cc_nume_doc_fld = pr.cc_nume_doc_fld where drv.cc_tipo_doc_fld = sos.cc_tipo_doc_c_fld AND drv.cc_nume_doc_fld = sos.cc_nume_doc_c_fld) AS driver
                                                    from cc_sos_orden_tbl sos
													where	cc_id_fld = '".$numeroSosOrder."'");
	}

	function getSosOrder($numeroSosOrder) {
		$this->result = $this->util->db->Execute("select 	cc_id_autoriza_fld AS authNumber,
															cc_tipo_doc_fld AS docTypePatient,
															cc_nume_doc_fld AS docNumPatient,
															cc_tipo_doc_a_fld AS docTypeCompanion,
															cc_nume_doc_a_fld AS docNumCompanion,
															cc_origen_fld AS source,
															cc_telefono_fld AS phone,
															DATE_FORMAT(cc_fecha_fld, '%m/%d/%Y') AS collectDate,															
															cc_hora_fld AS collectTime,
															cc_destino_fld AS destination1,
															DATE_FORMAT(cc_fecha_d_fld, '%m/%d/%Y') AS outputDate1,
															cc_hora_d_fld AS time1,
															cc_servicio1_fld AS cost1,
															cc_destino2_fld AS destination2,
															DATE_FORMAT(cc_fecha_d2_fld, '%m/%d/%Y') AS outputDate2,
															cc_hora_d2_fld AS time2,
															cc_servicio2_fld AS cost2,
															cc_placa_fld AS plate,
															cc_tipo_doc_c_fld AS docTypeDriver,
															cc_nume_doc_c_fld AS docNumDriver,
															(select cc_parentezco_fld from cc_pac_acomp_tbl 
															 where cc_tipo_doc_fld = docTypePatient AND
																   cc_nume_doc_fld = docNumPatient AND
																   cc_tipo_doc_a_fld = docTypeCompanion AND
																   cc_nume_doc_a_fld = docNumCompanion) AS relationship
													from cc_sos_orden_tbl
													where	cc_id_fld = '".$numeroSosOrder."'");
	}
 }
?>