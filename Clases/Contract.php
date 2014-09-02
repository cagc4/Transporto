<?php

class Contract
{
	var $util;
	var $result;
	
	function Contract()
	{
		$this->util = new Utilities();
	}

	function addContract($contractData)
	{
		$respCode = 0;
		
		$contractBasicData = $contractData->contractFormBasicData->contractFormBasic;
		$contractLocationData = $contractData->contractFormLocationData->contractFormLocation;
		$contractScheduleData = $contractData->contractFormScheduleData->contractFormSchedule;
		$contractConditionData = $contractData->contractFormConditionData->contractFormCondition;
		/*if($contractBasicData->plate != '') {
			$this->result = $this->util->db->Execute("SELECT CC_CAPACIDAD_FLD AS size FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$contractBasicData->plate."'");
			$result = $this->result->FetchRow();
			if($result != null) {
				if($contractBasicData->numPassengers > $result['size']) {
					$respCode = 3;
				}
			}
		}*/
		$separators = array(' ','-');
		$plates = strtoupper(str_replace($separators, '', $contractBasicData->plate));
		if(strlen($plates) > 0) {
			$capacidad = 0;
			if(strlen($plates) > 6) {
				if(strpos($plates, ',') > 0) {
					if($contractBasicData->totalBuses != '') {
						if($contractBasicData->totalBuses == (substr_count($plates, ',') + 1)) {
							$plates = explode(',', $plates);
							foreach($auxPlates as $plate) {
								$this->result = $this->util->db->Execute("SELECT CC_CAPACIDAD_FLD AS size FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".str_replace($separators, '', $auxPlates)."'");
								$result = $this->result->FetchRow();
								if($result != null) {
									$capacidad = $capacidad + $result['size'];
								}
								else {
									$respCode = 2;
									break;
								}
							}							
						}
						else {
							$respCode = 5;
						}
					}
					else {
						$respCode = 4;
					}
				}
				else {
					$respCode = 1;
				}
			}
			else {
				if($contractBasicData->totalBuses == 1) {
					$this->result = $this->util->db->Execute("SELECT CC_CAPACIDAD_FLD AS size FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$plates."'");
					$result = $this->result->FetchRow();
					if($result != null) {
						$capacidad = $result['size'];
					}
					else {
						$respCode = 2;
					}
				}
				else {
					$respCode = 5;
				}
			}
			if($respCode == 0) {
				if($contractBasicData->numPassengers > $capacidad) {
					$respCode = 3;
				}
			}
		}
		if($respCode == 0) {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$this->result = $this->util->db->Execute("INSERT INTO CC_CONTRACT_TBL VALUES('".$result['number']."',
																					 '".$contractBasicData->object."',
																					 '".$contractBasicData->number."',
																					 '".$plates."',
																					 '".$contractBasicData->totalBuses."',
																					 '".$contractBasicData->numPassengers."',
																					 STR_TO_DATE('".$contractScheduleData->outputDate->month."/".$contractScheduleData->outputDate->day."/".$contractScheduleData->outputDate->year."','%m/%d/%Y'),
																					 STR_TO_DATE('".$contractScheduleData->returnDate->month."/".$contractScheduleData->returnDate->day."/".$contractScheduleData->returnDate->year."','%m/%d/%Y'),
																					 '".$contractScheduleData->outputTime."',
																					 '".$contractScheduleData->returnTime."',
																					 '".$contractLocationData->provenience."',
																					 '".$contractLocationData->destination."',
																					 '".$contractLocationData->outputAddress."',
																					 STR_TO_DATE('".$contractConditionData->contractFirm->month."/".$contractConditionData->contractFirm->day."/".$contractConditionData->contractFirm->year."','%m/%d/%Y'),
																					 '".$contractConditionData->contractCost."',
																					 '".$contractConditionData->advance."')");
			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM CC_CONTRACT_TBL WHERE CC_ID_FLD = '".$result['number']."'");
				$respCode = 6;
			}
		}
		return $respCode;
	}
	
	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'CC_CONTRACT_TBL'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM DUAL");
	}
	
	function getContract($number) {
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
														 CC_FECHAFIRMA_FLD AS fechaFirma,
														 CAST(CC_COSTOCONTRATO_FLD AS CHAR) AS total,
														 CAST(CC_ABONO_FLD AS CHAR) AS abono,
														 DATEDIFF(CC_FECHAREGR_FLD, CC_FECHASALI_FLD)+1 AS dias														 
												  FROM CC_CONTRACT_TBL 
												  WHERE CC_ID_FLD = ".$number);
	}
 }
?>