<?php

class CasualTravel
{
	var $util;
	var $result;

	function CasualTravel()
	{
		$this->util = new Utilities();
	}

	function addCasualTravel($casualTravelData)
	{
		$respCode = 0;

		$casualTravelBasicData = $casualTravelData->casualTravelFormBasicData->casualTravelFormBasic;
		$casualTravelLocationData = $casualTravelData->casualTravelFormLocationData->casualTravelFormLocation;
		$casualTravelScheduleData = $casualTravelData->casualTravelFormScheduleData->casualTravelFormSchedule;
		$casualTravelDriversData = $casualTravelData->casualTravelFormDriversData->casualTravelFormDrivers;
		if($casualTravelBasicData->plate != '') {
			$this->result = $this->util->db->Execute("SELECT cc_capacidad_fld AS size FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$casualTravelBasicData->plate."'");
			$result = $this->result->FetchRow();
			if($result['size'] == null) {
				$respCode = 2;
			}
			else {
				if($casualTravelBasicData->numPassengers > $result['size']) {
					$respCode = 3;
				}
				$this->result = $this->util->db->Execute("SELECT (CASE WHEN ((TO_DAYS(cc_fecha_ven_fld) - TO_DAYS(CURDATE())) < 0) THEN ((TO_DAYS(cc_fecha_ven_fld) - TO_DAYS(CURDATE())))
																	   WHEN (((TO_DAYS(cc_fecha_ven_fld) - TO_DAYS(CURDATE())) >= 1) AND ((TO_DAYS(cc_fecha_ven_fld) - TO_DAYS(CURDATE())) <= 30)) THEN ((TO_DAYS(cc_fecha_ven_fld) - TO_DAYS(CURDATE())))
																	   ELSE ((TO_DAYS(cc_fecha_ven_fld) - TO_DAYS(CURDATE()))) END) AS Estado
														  FROM cc_documento_tbl
														  WHERE cc_placa_fld = '".$casualTravelBasicData->plate."'");
				$result = $this->result->FetchRow();
				if($result['Estado'] == null) {
					$respCode = 4;
				}
				else {
					do {
						if($result['Estado'] < 0) {
							$respCode = 4;
							break;
						}
					}while($result = $this->result->FetchRow());
				}
			}
		}
		if($respCode == 0) {
			if($casualTravelDriversData->driverone != '') {
				$this->result = $this->util->db->Execute("SELECT cc_nume_doc_fld AS driverone FROM cc_propcond_tbl WHERE cc_nume_doc_fld = '".$casualTravelDriversData->driverone."' AND cc_type_pc_fld in ('01','02')");
				$result = $this->result->FetchRow();
				if($result['driverone'] == null) {
					$respCode = 5;
				}
			}
		}
		if($respCode == 0) {
			if($casualTravelDriversData->drivertwo != '') {
				$this->result = $this->util->db->Execute("SELECT cc_nume_doc_fld AS drivertwo FROM cc_propcond_tbl WHERE cc_nume_doc_fld = '".$casualTravelDriversData->drivertwo."' AND cc_type_pc_fld in ('01','02')");
				$result = $this->result->FetchRow();
				if($result['drivertwo'] == null) {
					$respCode = 6;
				}
			}
		}
		if($respCode == 0) {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$this->result = $this->util->db->Execute("INSERT INTO cc_formocacional_tbl VALUES('".$result['number']."',
																					 '".$casualTravelBasicData->object."',
																					 '".$casualTravelBasicData->number."',
																					 '".$casualTravelBasicData->plate."',
																					 '".$casualTravelBasicData->totalBuses."',
																					 '".$casualTravelBasicData->numPassengers."',
																					 STR_TO_DATE('".$casualTravelScheduleData->outputDate->month."/".$casualTravelScheduleData->outputDate->day."/".$casualTravelScheduleData->outputDate->year."','%m/%d/%Y'),
																					 STR_TO_DATE('".$casualTravelScheduleData->returnDate->month."/".$casualTravelScheduleData->returnDate->day."/".$casualTravelScheduleData->returnDate->year."','%m/%d/%Y'),
																					 '".$casualTravelScheduleData->outputTime."',
																					 '".$casualTravelScheduleData->returnTime."',
																					 '".$casualTravelLocationData->provenience."',
																					 '".$casualTravelLocationData->destination."',
																					 '".$casualTravelLocationData->outputAddress."',
																					 '".$casualTravelDriversData->driverone."',
																					 '".$casualTravelDriversData->drivertwo."',
																					 '".$casualTravelBasicData->responsible."')");

			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM cc_formocacional_tbl WHERE cc_id_fld = '".$result['number']."'");
				$respCode = 1;
			}
		}
		return $respCode;
	}

	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'cc_formocacional_tbl'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM dual");
	}

	function getCasualTravel($number) {
		$this->result = $this->util->db->Execute("SELECT cc_id_fld as consecutivo,
														 cc_objetocont_fld as objetos,
														 cc_nume_doc_fld as numerodoc,
														 cc_placa_fld as placa,
														 cc_numbuses_fld as busescon,
														 cc_numpasajeros_fld as numpas,
														 cc_fechasali_fld as fechasalida,
														 cc_fecharegr_fld as fecharegreso,
														 cc_horasali_fld as horasalida,
														 cc_horaregr_fld as horaregreso,
														 cc_origen_fld as origen,
														 cc_destino_fld as destino,
														 cc_dirsalida_fld as diresalida,
														 cc_conductor1_fld as conductor1,
														 cc_conductor2_fld as conductor2,
														 cc_encargado_fld as responsible
												  FROM cc_formocacional_tbl
												  WHERE cc_id_fld = ".$number);
	}

	function getServiceOrder($number) {
		$resultSO = $this->util->db->Execute("SELECT f.cc_id_fld as consecutivo,
													 f.cc_objetocont_fld as objetos,
													 f.cc_placa_fld as placa,
													 concat(f.cc_fechasali_fld, ' ', f.cc_horasali_fld) as fechasalida,
													 concat(f.cc_fecharegr_fld, ' ', f.cc_horaregr_fld) as fecharegreso,
													 f.cc_dirsalida_fld as origen,
													 f.cc_destino_fld as destino,
													 f.cc_encargado_fld as responsable
											  from cc_formocacional_tbl f
											  where f.cc_id_fld = ".$number);
		$resultP = $this->util->db->execute("select p.cc_fnombre_fld as persona,
													a.cc_celular_fld as celular,
													( select pv.cc_fnombre_fld from cc_person_tbl pv where pv.cc_nume_doc_fld = f.cc_conductor1_fld  )  as conductor,
													c.cc_tipo_doc_fld as tipoid,
													c.cc_nume_doc_fld as numid
											 from cc_formocacional_tbl f inner join cc_person_tbl p on f.cc_nume_doc_fld = p.cc_nume_doc_fld inner join cc_customer_tbl c on p.cc_nume_doc_fld = c.cc_nume_doc_fld inner join cc_address_tbl a on c.cc_nume_doc_fld = a.cc_nume_doc_fld
											 where f.cc_id_fld = ".$number);
		$resultSO = $resultSO->FetchRow();
		if($resultP) {
			$resultP = $resultP->FetchRow();
			if($resultP['tipoid'] == 'nt') {
				$resultP = $this->util->db->Execute("SELECT cc_personacontacto_fld AS persona,
															'".$resultP['celular']."' AS celular,
															'".$resultP['conductor']."' AS conductor
													 FROM cc_customer_tbl WHERE cc_tipo_doc_fld = '".$resultP['tipoid']."' AND cc_nume_doc_fld = '".$resultP['numid']."'");
				$resultP = $resultP->FetchRow();
			}
			if($resultP['conductor'] == '') {
				$resultP = $this->util->db->Execute("SELECT '".$resultP['persona']."' AS persona,
															'".$resultP['celular']."' AS celular,
															(SELECT P.cc_fnombre_fld FROM cc_per_veh_tbl PV INNER JOIN cc_person_tbl P ON PV.cc_nume_doc_fld = P.cc_nume_doc_fld INNER JOIN cc_propcond_tbl PC ON P.cc_nume_doc_fld = PC.cc_nume_doc_fld WHERE PV.cc_placa_fld = '".$resultSO['placa']."' AND PC.cc_type_pc_fld = '01') AS conductor
													 FROM dual");
				$resultP = $resultP->FetchRow();
			}
		}
		if($resultSO['responsable'] == '') {
			$this->result = $this->util->db->Execute("SELECT '".$resultSO['consecutivo']."' AS consecutivo,
															 '".$resultSO['objetos']."' AS objetoS,
															 '".$resultSO['placa']."' AS placa,
															 '".$resultSO['fechasalida']."' AS fechasalida,
															 '".$resultSO['fecharegreso']."' AS fecharegreso,
															 '".$resultSO['origen']."' AS origen,
															 '".$resultSO['destino']."' AS destino,
															 '".$resultP['persona']."' AS persona,
															 '".$resultP['celular']."' AS celular,
															 '".$resultP['conductor']."' AS conductor
													  FROM dual");
		}
		else {
			$this->result = $this->util->db->Execute("SELECT '".$resultSO['consecutivo']."' AS consecutivo,
															 '".$resultSO['objetoS']."' AS objetoS,
															 '".$resultSO['placa']."' AS placa,
															 '".$resultSO['fechasalida']."' AS fechasalida,
															 '".$resultSO['fecharegreso']."' AS fecharegreso,
															 '".$resultSO['origen']."' AS origen,
															 '".$resultSO['destino']."' AS destino,
															 '".$resultSO['responsable']."' AS persona,
															 '".$resultP['celular']."' AS celular,
															 '".$resultP['conductor']."' AS conductor
													  FROM dual");
		}
	}
 }
?>