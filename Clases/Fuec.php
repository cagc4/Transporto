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
																						 '" . $fuecResponsibleData->nameResponsible . "',
																						 '" . $fuecResponsibleData->phoneResponsible . "',
																						 '" . $fuecResponsibleData->addressResponsible . "',
																						 '" . $fuecDriver1Data->docTypeDriver1 . "',
																						 '" . $fuecDriver2Data->docNumDriver2 . "',
																						 '" . $fuecDriver2Data->docTypeDriver2 . "',
																						 '" . $fuecDriver1Data->docNumDriver1 . "')");
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

	function addFuecPassenger($fuecPassengerData, $numFuec)	{
		$respCode = 0;
		$fuecBasicData = $fuecPassengerData->fuecFormBasicData->fuecFormBasic;
		if(is_array($fuecBasicData)) {
			foreach($fuecBasicData as $fuec) {
				if($fuec->docNum != '') {
					$this->getNextConsecutivePassenger($numFuec);
					$result = $this->result->FetchRow();
					$this->result = $this->util->db->Execute("INSERT INTO CC_FUEC_OCUPANTES_TBL VALUES (0, " . ($result['number'] + 1)	 . ", '" . $numFuec . "', '" . $fuec->docType . "', '" . $fuec->docNum . "', '" . $fuec->name . "')");
					if(!$this->result) {
						$this->util->db->Execute("DELETE FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '".$numFuec."'");
						$respCode = 99;
						break;
					}
				}
			}
		}
		else {
			if($fuecBasicData->docNum != '') {
				$this->getNextConsecutivePassenger($numFuec);
				$result = $this->result->FetchRow();
				$this->result = $this->util->db->Execute("INSERT INTO CC_FUEC_OCUPANTES_TBL VALUES (0, " . ($result['number'] + 1) . ", '" . $numFuec . "', '" . $fuecBasicData->docType . "', '" . $fuecBasicData->docNum . "', '" . $fuecBasicData->name . "')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '".$numFuec."'");
					$respCode = 99;
					break;
				}
			}
		}
		return $respCode;
	}

	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'CC_FUEC_TBL'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM DUAL");
	}

	function getNextConsecutivePassenger($number) {
		$this->result = $this->util->db->Execute("SELECT IFNULL(MAX(CC_ID_OCUPANTE_FLD), 0) AS number FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '" . $number . "'");
	}

	function getPassengersFuec($number) {
		$this->result = $this->util->db->Execute("SELECT CC_TIPO_DOC_FLD AS docType,
														 CC_NUM_ID_FLD AS docNum,
														 CC_NOMBRE_FLD AS name
												  FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '" . $number . "'");
	}

	function getPassengerFuec($number, $numberId) {
		$this->result = $this->util->db->Execute("SELECT CC_TIPO_DOC_FLD AS docType,
														 CC_NUM_ID_FLD AS docNum,
														 CC_NOMBRE_FLD AS name
												  FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '" . $number . "' AND CC_ID_OCUPANTE_FLD = '" . $numberId . "'");
	}

	function getPassengerFuecView($number, $numberId) {
		$this->result = $this->util->db->Execute("SELECT CC_TIPO_DOC_FLD AS docType,
														 CC_NUM_ID_FLD AS docNum,
														 CC_NOMBRE_FLD AS name
												  FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '" . $number . "' AND CC_NUM_ID_FLD = '" . $numberId . "'");
	}

	function getCapacityAvailable($numFuec) {
		$this->result = $this->util->db->Execute("SELECT (V.CC_CAPACIDAD_FLD - (SELECT COUNT(*) FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '" . $numFuec . "')) AS size
							FROM CC_FUEC_TBL F INNER JOIN CC_VEHICLE_TBL V ON F.CC_PLACA_FLD = V.CC_PLACA_FLD WHERE F.CC_NUMERO_FUEC_FLD = '" . $numFuec . "'");
	}

	function modifyFuecPassenger($fuecPassengerData, $numFuec, $numberId) {
		$respCode = 0;
		$fuecModifyData = $fuecPassengerData->fuecFormModifyData->fuecFormModify;
		if($fuecModifyData->docNum != '') {
			$this->result = $this->util->db->Execute("UPDATE CC_FUEC_OCUPANTES_TBL SET
															 CC_TIPO_DOC_FLD = '" . $fuecModifyData->docType . "',
															 CC_NUM_ID_FLD = '" . $fuecModifyData->docNum . "',
															 CC_NOMBRE_FLD = '" . $fuecModifyData->name . "'
													  WHERE CC_NUMERO_FUEC_FLD = '".$numFuec."' AND CC_NUM_ID_FLD = '" . $numberId . "'");
		}
		else {
			$this->util->db->Execute("DELETE FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = '".$numFuec."' AND CC_NUM_ID_FLD = '" . $numberId . "'");
		}
		return $respcode;
	}

	function getFuec($numeroFuec) {
		$this->result = $this->util->db->Execute("SELECT	A.CC_NUM_CONTRATO_TBL, C.CC_FNOMBRE_FLD, B.CC_NUME_DOC_FLD, B.CC_OBJETOCONT_FLD,
															CONCAT('De ',B.CC_ORIGEN_FLD,' a ',B.CC_DESTINO_FLD),A.CC_CONVENIO_FLD,
															EXTRACT(DAY FROM B.CC_FECHASALI_FLD),EXTRACT(MONTH FROM B.CC_FECHASALI_FLD),EXTRACT(YEAR FROM B.CC_FECHASALI_FLD),
															EXTRACT(DAY FROM B.CC_FECHAREGR_FLD),EXTRACT(MONTH FROM B.CC_FECHAREGR_FLD),EXTRACT(YEAR FROM B.CC_FECHAREGR_FLD),
															A.CC_PLACA_FLD,D.CC_MODELO_FLD,
															(SELECT X.CC_DESCRIPCION_FLD FROM CC_VALORES_TBL X WHERE X.CC_CAMPO_FLD = 'CC_MARCA_FLD' AND X.CC_VALOR_FLD = D.CC_MARCA_FLD),
															(SELECT X.CC_DESCRIPCION_FLD FROM CC_VALORES_TBL X WHERE X.CC_CAMPO_FLD = 'CC_CLASE_FLD' AND X.CC_VALOR_FLD = D.CC_CLASE_FLD),
															D.CC_CODIGOINTERNO_FLD,
															(SELECT X.CC_IDENTIFICADOR_FLD FROM CC_DOCUMENTO_TBL X WHERE X.CC_PLACA_FLD = A.CC_PLACA_FLD AND X.CC_TIPO_DOCUM_FLD='01' ),
														   (SELECT X.CC_FNOMBRE_FLD FROM CC_PERSON_TBL X WHERE X.CC_TIPO_DOC_FLD = A.CC_TIPO_DOC_CONDUCTOR1_FLD AND X.CC_NUME_DOC_FLD=A.CC_NUM_DOC_CONDUCTOR1_FLD)
															,A.CC_NUM_DOC_CONDUCTOR1_FLD
															,(SELECT X.CC_NUMLICENCIA_FLD FROM CC_PROPCOND_TBL X WHERE X.CC_TIPO_DOC_FLD = A.CC_TIPO_DOC_CONDUCTOR1_FLD AND X.CC_NUME_DOC_FLD=A.CC_NUM_DOC_CONDUCTOR1_FLD)
															,(SELECT DATE_FORMAT(X.CC_FCHVENCLICENCIA_FLD,'%d/%m/%Y') FROM CC_PROPCOND_TBL X WHERE X.CC_TIPO_DOC_FLD = A.CC_TIPO_DOC_CONDUCTOR1_FLD AND X.CC_NUME_DOC_FLD=A.CC_NUM_DOC_CONDUCTOR1_FLD)
															,(SELECT X.CC_FNOMBRE_FLD FROM CC_PERSON_TBL X WHERE X.CC_TIPO_DOC_FLD = A.CC_TIPO_DOC_CONDUCTOR2_FLD AND X.CC_NUME_DOC_FLD=A.CC_NUM_DOC_CODUCTOR2_FLD)
															, A.CC_NUM_DOC_CODUCTOR2_FLD
															,(SELECT X.CC_NUMLICENCIA_FLD FROM CC_PROPCOND_TBL X WHERE X.CC_TIPO_DOC_FLD = A.CC_TIPO_DOC_CONDUCTOR2_FLD AND X.CC_NUME_DOC_FLD=A.CC_NUM_DOC_CODUCTOR2_FLD)
															,(SELECT DATE_FORMAT(X.CC_FCHVENCLICENCIA_FLD,'%d/%m/%Y') FROM CC_PROPCOND_TBL X WHERE X.CC_TIPO_DOC_FLD = A.CC_TIPO_DOC_CONDUCTOR2_FLD AND X.CC_NUME_DOC_FLD=A.CC_NUM_DOC_CODUCTOR2_FLD)
												  			,A.CC_NOMBRE_RESPONSABLE_FLD
															,A.CC_NUM_DOC_RESPONSABLE_FLD
															,A.CC_TEL_RESPONSABLE_FLD
        													,A.CC_DIR_RESPONSABLE_FLD
        										  FROM    	CC_FUEC_TBL A, CC_CONTRACT_TBL B , CC_PERSON_TBL C , CC_VEHICLE_TBL D
												  WHERE		A.CC_NUM_CONTRATO_TBL = B.CC_ID_FLD
												  AND     	B.CC_NUME_DOC_FLD = C.CC_NUME_DOC_FLD
												  AND     	A.CC_PLACA_FLD = D.CC_PLACA_FLD
												  AND		A.CC_NUMERO_FUEC_FLD = '".$numeroFuec."'");
	}
 }
?>