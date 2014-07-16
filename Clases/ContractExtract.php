<?php

class ContractExtract
{
	var $util;
	var $result;
	
	function ContractExtract()
	{
		$this->util = new Utilities();
	}

	function addContractExtract($contractExtractData)
	{
		$respCode = 0;
		
		$contractExtractBasicData = $contractExtractData->contractExtractFormBasicData->contractExtractFormBasic;
		$contractExtractLocationData = $contractExtractData->contractExtractFormLocationData->contractExtractFormLocation;
		$contractExtractScheduleData = $contractExtractData->contractExtractFormScheduleData->contractExtractFormSchedule;
		if($contractExtractBasicData->plate != '') {
			$this->result = $this->util->db->Execute("SELECT CC_CAPACIDAD_FLD AS size FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$contractExtractBasicData->plate."'");
			if(!$this->result) {
				$respCode = 2;
			}
			else {
				$result = $this->result->FetchRow();
				if($casualTravelBasicData->numPassengers > $result['size']) {
					$respCode = 3;
				}
			}
		}
		if($respCode == 0) {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$this->result = $this->util->db->Execute("INSERT INTO CC_FORMCONTRACT_TBL VALUES('".$result['number']."',
																					 '".$contractExtractBasicData->object."',
																					 '".$contractExtractBasicData->number."',
																					 '".$contractExtractBasicData->plate."',
																					 '".$contractExtractBasicData->totalBuses."',
																					 '".$contractExtractBasicData->numPassengers."',
																					 STR_TO_DATE('".$contractExtractScheduleData->outputDate->month."/".$contractExtractScheduleData->outputDate->day."/".$contractExtractScheduleData->outputDate->year."','%m/%d/%Y'),
																					 STR_TO_DATE('".$contractExtractScheduleData->returnDate->month."/".$contractExtractScheduleData->returnDate->day."/".$contractExtractScheduleData->returnDate->year."','%m/%d/%Y'),
																					 '".$contractExtractScheduleData->outputTime."',
																					 '".$contractExtractScheduleData->returnTime."',
																					 '".$contractExtractLocationData->provenience."',
																					 '".$contractExtractLocationData->destination."',
																					 '".$contractExtractLocationData->outputAddress."',
																					 '".!empty($contractExtractBasicData->school)."')");
			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM CC_FORMCONTRACT_TBL WHERE CC_ID_FLD = '".$result['number']."'");
				$respCode = 1;
			}
		}
		return $respCode;
	}
	
	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'CC_FORMCONTRACT_TBL'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 11, 0) AS number FROM DUAL");
	}
	
	function getContractExtract($number) {
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
														 DATEDIFF(CC_FECHAREGR_FLD, CC_FECHASALI_FLD)+1 AS dias,
														 CC_ESCOLAR_FLD AS escolar
												  FROM CC_FORMCONTRACT_TBL 
												  WHERE CC_ID_FLD = ".$number);
	}
 }
?>