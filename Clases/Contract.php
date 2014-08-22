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
		if($contractBasicData->plate != '') {			
			$this->result = $this->util->db->Execute("SELECT CC_CAPACIDAD_FLD AS size FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$contractBasicData->plate."'");
			$result = $this->result->FetchRow();
			if($result != null) {
				if($contractBasicData->numPassengers > $result['size']) {
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
																					 '".$contractBasicData->plate."',
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
				$respCode = 1;
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