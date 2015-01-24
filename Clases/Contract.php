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
			$this->result = $this->util->db->Execute("SELECT cc_capacidad_fld AS size FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$contractBasicData->plate."'");
			$result = $this->result->FetchRow();
			if($result != null) {
				if($contractBasicData->numPassengers > $result['size']) {
					$respCode = 3;
				}
			}
		}*/
		$separators = array(' ','-');
		$plates = strtoupper(str_replace($separators, '', $contractBasicData->plate));
		$contractBasicData->plate = $plates;
		if(strlen($plates) > 0) {
			$capacidad = 0;
			if(strlen($plates) > 6) {
				if(strpos($plates, ',') > 0) {
					if($contractBasicData->totalBuses != '') {
						if($contractBasicData->totalBuses == (substr_count($plates, ',') + 1)) {
							$plates = explode(',', $plates);
							foreach($plates as $plate) {
								$this->result = $this->util->db->Execute("SELECT cc_capacidad_fld AS size FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$plate."'");
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
					$this->result = $this->util->db->Execute("SELECT cc_capacidad_fld AS size FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$plates."'");
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
			$this->result = $this->util->db->Execute("INSERT INTO cc_contract_tbl VALUES('".$result['number']."',
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
				$this->util->db->Execute("DELETE FROM cc_contract_tbl WHERE cc_id_fld = '".$result['number']."'");
				$respCode = 6;
			}
		}
		return $respCode;
	}

	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'cc_contract_tbl'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM dual");
	}

	function getContract($number) {
		$this->result = $this->util->db->Execute("SELECT cc_id_fld as consecutivo,
														 cc_objetocont_fld as objetos,
														 cc_nume_doc_fld as numeroDoc,
														 cc_placa_fld as placa,
														 cc_numbuses_fld as busesCon,
														 cc_numpasajeros_fld as numPas,
														 cc_fechasali_fld as fechasalida,
														 cc_fecharegr_fld as fecharegreso,
														 cc_horasali_fld as horasalida,
														 cc_horaregr_fld as horaregreso,
														 cc_origen_fld as origen,
														 cc_destino_fld as destino,
														 cc_dirsalida_fld as direSalida,
														 cc_fechafirma_fld as fechaFirma,
														 cast(cc_costocontrato_fld as char) as total,
														 cast(cc_abono_fld as char) as abono,
														 datediff(cc_fecharegr_fld, cc_fechasali_fld)+1 as dias
												  FROM cc_contract_tbl
												  WHERE cc_id_fld = ".$number);
	}
 }
?>