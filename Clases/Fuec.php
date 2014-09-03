<?php

class Fuec
{
	var $util;
	var $result;
	
	function Fuec()
	{
		$this->util = new Utilities();
	}

	function addFuec($fuecData)
	{
		$respCode = 0;		
		$fuecGeneralData = $fuecData->fuecFormGeneralData->fuecFormGeneral;
		$fuecResponsibleData = $fuecData->fuecFormResponsibleData->fuecFormResponsible;
		$fuecDriver1Data = $fuecData->fuecFormDriver1Data->fuecFormDriver1;
		$fuecDriver2Data = $fuecData->fuecFormDriver2Data->fuecFormDriver2;
		
		$this->result = $this->util->db->Execute("SELECT CC_PLACA_FLD AS plate FROM CC_CONTRACT_TBL WHERE CC_ID_FLD = " . $fuecGeneralData->contractNumber);
		$result = $this->result->FetchRow();
		$separators = array(' ','-');
		$plate = strtoupper(str_replace($separators, '', $fuecGeneralData->plate));
		if($result) {
			if(strpos($result['plate'], $plate) === false) {
				$respCode = 2;
			}
		}
		else {
			$respCode = 1;
		}
		if($respCode == 0) {
			$this->result = $this->util->db->Execute("SELECT * FROM CC_PROPCOND_TBL WHERE CC_TIPO_DOC_FLD = '" . $fuecDriver1Data->docTypeDriver1 . "' AND
																						  CC_NUME_DOC_FLD = '" . $fuecDriver1Data->docNumDriver1 . "' AND
																						  CC_TYPE_PC_FLD = '02'");
			$result = $this->result->FetchRow();
			if($result) {
				if($fuecDriver2Data->docTypeDriver2 != '' && $fuecDriver2Data->docTypeDriver2 != '') {
					$this->result = $this->util->db->Execute("SELECT * FROM CC_PROPCOND_TBL WHERE CC_TIPO_DOC_FLD = '" . $fuecDriver2Data->docTypeDriver2 . "' AND
																								  CC_NUME_DOC_FLD = '" . $fuecDriver2Data->docNumDriver2 . "' AND
																								  CC_TYPE_PC_FLD = '02'");
					$result = $this->result->FetchRow();
					if(!$result) {
						$respCode = 4;
					}
				}
			}
			else {
				$respCode = 3;
			}
		}
		if($respCode == 0) {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$numFuec = '376009200' . date('Y') . str_pad($fuecGeneralData->contractNumber, 4, "0", STR_PAD_LEFT) . $result['number'];
			
			$this->result = $this->util->db->Execute("INSERT INTO CC_FUEC_TBL VALUES (0, '" . $numFuec . "',
																						  " . $fuecGeneralData->contractNumber . ",
																						 '" . $plate . "',
																						 '" . $fuecGeneralData->agreement . "',
																						 '" . $fuecResponsibleData->docTypeResponsible . "',
																						 '" . $fuecResponsibleData->docNumResponsible . "',
																						 '" . $fuecResponsibleData->phoneResponsible . "',
																						 '" . $fuecResponsibleData->addressResponsible . "',
																						 '" . $fuecDriver1Data->docTypeDriver1 . "',
																						 '" . $fuecDriver1Data->docNumDriver1 . "',
																						 '" . $fuecDriver2Data->docTypeDriver2 . "',
																						 '" . $fuecDriver2Data->docNumDriver2 . "')");
			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM CC_FUEC_TBL WHERE CC_NUMERO_FUEC_FLD = ".$numFuec);
				$respCode = 99;
			}
			else {
				$_SESSION['number'] = $numFuec;
			}
		}
		return $respCode;
	}
	
	function addFuecPassenger($fuecPassengerData, $numFuec)
	{
		$respCode = 0;
		$fuecBasicData = $fuecPassengerData->fuecFormBasicData->fuecFormBasic;
		$this->result = $this->util->db->Execute("SELECT (V.CC_CAPACIDAD_FLD - (SELECT COUNT(*) FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '" . $numFuec . "')) AS size 
											FROM CC_FUEC_TBL F INNER JOIN CC_VEHICLE_TBL V ON F.CC_PLACA_FLD = V.CC_PLACA_FLD WHERE F.CC_NUMERO_FUEC_FLD = '" . $numFuec . "'");
		$result = $this->result->FetchRow();
		if($result['size'] > 1) {
			foreach($fuecBasicData as $fuec) {
				$this->result = $this->util->db->Execute("INSERT INTO CC_FUEC_OCUPANTES_TBL VALUES (0, '" . $numFuec . "', '" . $fuec->docType . "', '" . $fuec->docNum . "', '" . $fuec->name . "')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = ".$numFuec);
					$respCode = 99;
					break;
				}
			}
		}
		else {
			if($result['size'] == 1) {
				$fuec = $fuecBasicData;
				$this->result = $this->util->db->Execute("INSERT INTO CC_FUEC_OCUPANTES_TBL VALUES (0, '" . $numFuec . "', '" . $fuec->docType . "', '" . $fuec->docNum . "', '" . $fuec->name . "')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = ".$numFuec);
					$respCode = 99;
					break;
				}
			}
			else {
				$respCode = 1;
			}
		}
		return $respCode;
	}
	
	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'CC_FUEC_TBL'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM DUAL");
	}
	
	function getPassengersFuec($number) {
		$this->result = $this->util->db->Execute("SELECT CC_TIPO_DOC_FLD AS docType,
														 CC_NUM_ID_FLD AS docNum,
														 CC_NOMBRE_FLD AS name
												  FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '" . $number . "'");
	}
	
	function modifyFuecPassenger($fuecPassengerData, $numFuec) {
		return 99;
	}
	
	function getFuec($number) {
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