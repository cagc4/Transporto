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
			$this->result = $this->util->db->Execute("SELECT CC_CAPACIDAD_FLD AS size FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$casualTravelBasicData->plate."'");
			$result = $this->result->FetchRow();
			if($result['size'] == null) {
				$respCode = 2;
			}
			else {
				if($casualTravelBasicData->numPassengers > $result['size']) {
					$respCode = 3;
				}
				$this->result = $this->util->db->Execute("SELECT (CASE WHEN ((TO_DAYS(CC_FECHA_VEN_FLD) - TO_DAYS(CURDATE())) < 0) THEN ((TO_DAYS(CC_FECHA_VEN_FLD) - TO_DAYS(CURDATE())))
																	   WHEN (((TO_DAYS(CC_FECHA_VEN_FLD) - TO_DAYS(CURDATE())) >= 1) AND ((TO_DAYS(CC_FECHA_VEN_FLD) - TO_DAYS(CURDATE())) <= 30)) THEN ((TO_DAYS(CC_FECHA_VEN_FLD) - TO_DAYS(CURDATE())))
																	   ELSE ((TO_DAYS(CC_FECHA_VEN_FLD) - TO_DAYS(CURDATE()))) END) AS Estado
														  FROM CC_DOCUMENTO_TBL
														  WHERE CC_PLACA_FLD = '".$casualTravelBasicData->plate."'");
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
				$this->result = $this->util->db->Execute("SELECT CC_NUME_DOC_FLD AS driverone FROM CC_PROPCOND_TBL WHERE CC_NUME_DOC_FLD = '".$casualTravelDriversData->driverone."' AND CC_TYPE_PC_FLD = '02'");
				$result = $this->result->FetchRow();
				if($result['driverone'] == null) {
					$respCode = 5;
				}
			}
		}
		if($respCode == 0) {
			if($casualTravelDriversData->drivertwo != '') {
				$this->result = $this->util->db->Execute("SELECT CC_NUME_DOC_FLD AS drivertwo FROM CC_PROPCOND_TBL WHERE CC_NUME_DOC_FLD = '".$casualTravelDriversData->drivertwo."' AND CC_TYPE_PC_FLD = '02'");
				$result = $this->result->FetchRow();
				if($result['drivertwo'] == null) {
					$respCode = 6;
				}
			}
		}
		if($respCode == 0) {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$this->result = $this->util->db->Execute("INSERT INTO CC_FORMOCACIONAL_TBL VALUES('".$result['number']."',
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
				$this->util->db->Execute("DELETE FROM CC_FORMOCACIONAL_TBL WHERE CC_ID_FLD = '".$result['number']."'");
				$respCode = 1;
			}
		}
		return $respCode;
	}
	
	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'CC_FORMOCACIONAL_TBL'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM DUAL");
	}
	
	function getCasualTravel($number) {
		$this->result = $this->util->db->Execute("SELECT CC_ID_FLD AS consecutivo,
														 CC_OBJETOCONT_FLD AS objetoS,
														 CC_NUME_DOC_FLD AS numeroDoc,
														 CC_PLACA_FLD AS placa,
														 CC_NUMBUSES_FLD AS busesCon,
														 CC_NUMPASAJEROS_FLD AS numPas,
														 CC_FECHASALI_FLD AS fechasalida,
														 CC_FECHAREGR_FLD AS fecharegreso,
														 CC_HORASALI_FLD AS horasalida,
														 CC_HORAREGR_FLD AS horaregreso,
														 CC_ORIGEN_FLD AS origen,
														 CC_DESTINO_FLD AS destino,
														 CC_DIRSALIDA_FLD AS direSalida,
														 CC_CONDUCTOR1_FLD AS conductor1,
														 CC_CONDUCTOR2_FLD AS conductor2,
														 CC_ENCARGADO_FLD AS responsible
												  FROM CC_FORMOCACIONAL_TBL 
												  WHERE CC_ID_FLD = ".$number);
	}
	
	function getServiceOrder($number) {
		$resultSO = $this->util->db->Execute("SELECT F.CC_ID_FLD AS consecutivo,
													 F.CC_OBJETOCONT_FLD AS objetoS,
													 F.CC_PLACA_FLD AS placa,
													 CONCAT(F.CC_FECHASALI_FLD, ' ', F.CC_HORASALI_FLD) AS fechasalida,
													 CONCAT(F.CC_FECHAREGR_FLD, ' ', F.CC_HORAREGR_FLD) AS fecharegreso,
													 F.CC_DIRSALIDA_FLD AS origen,
													 F.CC_DESTINO_FLD AS destino,
													 F.CC_ENCARGADO_FLD AS responsable
											  FROM CC_FORMOCACIONAL_TBL F
											  WHERE F.CC_ID_FLD = ".$number);
		$resultP = $this->util->db->Execute("SELECT P.CC_FNOMBRE_FLD AS persona,
													A.CC_CELULAR_FLD AS celular,
													( SELECT PV.CC_FNOMBRE_FLD FROM CC_PERSON_TBL PV WHERE PV.CC_NUME_DOC_FLD = F.CC_CONDUCTOR1_FLD  )  AS conductor,
													C.CC_TIPO_DOC_FLD AS tipoID,
													C.CC_NUME_DOC_FLD AS numID
											 FROM CC_FORMOCACIONAL_TBL F INNER JOIN CC_PERSON_TBL P ON F.CC_NUME_DOC_FLD = P.CC_NUME_DOC_FLD INNER JOIN CC_CUSTOMER_TBL C ON P.CC_NUME_DOC_FLD = C.CC_NUME_DOC_FLD INNER JOIN CC_ADDRESS_TBL A ON C.CC_NUME_DOC_FLD = A.CC_NUME_DOC_FLD
											 WHERE F.CC_ID_FLD = ".$number);
		$resultSO = $resultSO->FetchRow();
		if($resultP) {
			$resultP = $resultP->FetchRow();
			if($resultP['tipoID'] == 'nt') {
				$resultP = $this->util->db->Execute("SELECT CC_PERSONACONTACTO_FLD AS persona,
															'".$resultP['celular']."' AS celular,
															'".$resultP['conductor']."' AS conductor
													 FROM CC_CUSTOMER_TBL WHERE CC_TIPO_DOC_FLD = '".$resultP['tipoID']."' AND CC_NUME_DOC_FLD = '".$resultP['numID']."'");
				$resultP = $resultP->FetchRow();
			}
			if($resultP['conductor'] == '') {
				$resultP = $this->util->db->Execute("SELECT '".$resultP['persona']."' AS persona,
															'".$resultP['celular']."' AS celular,
															(SELECT P.CC_FNOMBRE_FLD FROM CC_PER_VEH_TBL PV INNER JOIN CC_PERSON_TBL P ON PV.CC_NUME_DOC_FLD = P.CC_NUME_DOC_FLD INNER JOIN CC_PROPCOND_TBL PC ON P.CC_NUME_DOC_FLD = PC.CC_NUME_DOC_FLD WHERE PV.CC_PLACA_FLD = '".$resultSO['placa']."' AND PC.CC_TYPE_PC_FLD = '01') AS conductor
													 FROM DUAL");
				$resultP = $resultP->FetchRow();
			}			
		}
		if($resultSO['responsable'] == '') {
			$this->result = $this->util->db->Execute("SELECT '".$resultSO['consecutivo']."' AS consecutivo,
															 '".$resultSO['objetoS']."' AS objetoS,
															 '".$resultSO['placa']."' AS placa,
															 '".$resultSO['fechasalida']."' AS fechasalida,
															 '".$resultSO['fecharegreso']."' AS fecharegreso,
															 '".$resultSO['origen']."' AS origen,
															 '".$resultSO['destino']."' AS destino,
															 '".$resultP['persona']."' AS persona,
															 '".$resultP['celular']."' AS celular,
															 '".$resultP['conductor']."' AS conductor
													  FROM DUAL");
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
													  FROM DUAL");
		}
	}
 }
?>