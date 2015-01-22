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
			$this->result = $this->util->db->Execute("SELECT cc_capacidad_fld AS size FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$contractExtractBasicData->plate."'");
			$result = $this->result->FetchRow();
			if($result != null) {
				if($contractExtractBasicData->numPassengers > $result['size']) {
					$respCode = 3;
				}
			}
		}
		if($respCode == 0) {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$this->result = $this->util->db->Execute("INSERT INTO cc_formcontract_tbl VALUES('".$result['number']."',
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
				$this->util->db->Execute("DELETE FROM cc_formcontract_tbl WHERE cc_id_fld = '".$result['number']."'");
				$respCode = 1;
			}
		}
		return $respCode;
	}

	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'cc_formcontract_tbl'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM dual");
	}

	function getContractExtract($number) {
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
														 datediff(cc_fecharegr_fld, cc_fechasali_fld)+1 as dias,
														 cc_escolar_fld as escolar
												  from cc_formcontract_tbl
												  WHERE cc_id_fld = ".$number);
	}
 }
?>