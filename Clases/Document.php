<?php

class Document
{
	var $util;
	var $result;
	
	function Document()
	{
		$this->util = new Utilities();
	}

	function addDocument($documentData)
	{
		$respCode = 0;			
		$documentBasicData = $documentData->documentFormBasicData->documentFormBasic;
		$documentInsurance = $documentData->documentFormInsuranceData->documentFormInsurance;
		$documentCoverage = $documentData->documentFormCoverageData->documentFormCoverage;
		$documentComments = $documentData->documentFormCommentsData->documentFormComments;
		$this->result = $this->util->db->Execute("SELECT * FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$documentBasicData->plate."'");
		if($this->result->FetchRow()) {
			$this->result = $this->util->db->Execute("INSERT INTO CC_DOCUMENTO_TBL VALUES('".$documentBasicData->number."',
																						  '".$documentBasicData->documentType."',
																						  '".$documentBasicData->plate."',
																						  STR_TO_DATE('".$documentInsurance->dateOfIssue->month."/".$documentInsurance->dateOfIssue->day."/".$documentInsurance->dateOfIssue->year."','%m/%d/%Y'),
																						  STR_TO_DATE('".$documentInsurance->expirationDate->month."/".$documentInsurance->expirationDate->day."/".$documentInsurance->expirationDate->year."','%m/%d/%Y'),
																						  '".$documentInsurance->insurance."',
																						  '".$documentCoverage->coverage."',
																						  '".$documentBasicData->transitAgency."',
																						  '".$documentComments->details."')");
			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM CC_DOCUMENTO_TBL WHERE CC_PLACA_FLD = '".$documentBasicData->plate."' AND 
																		CC_IDENTIFICADOR_FLD = '".$documentBasicData->number."' AND 
																		CC_TIPO_DOCUM_FLD = '".$documentBasicData->documentType."'");								   
				$respCode = 1;
			}
		}
		else {
			$respCode = 2;
		}
		return $respCode;
	}
	
	function getDocument($number, $plate, $documentType) {
		$this->result = $this->util->db->Execute("SELECT CC_IDENTIFICADOR_FLD AS number,
														 CC_TIPO_DOCUM_FLD AS documentType,
														 CC_PLACA_FLD AS plate,
														 DATE_FORMAT(CC_FECHA_EXP_FLD, '%m/%d/%Y') AS dateOfIssue,
														 DATE_FORMAT(CC_FECHA_VEN_FLD, '%m/%d/%Y') AS expirationDate,
														 CC_NOMBRE_ASE_FLD AS insurance,
														 CC_COBERTURA_FLD AS coverage,
														 CC_ORG_TRAN_FLD AS transitAgency,
														 CC_OBSERVACIONES_FLD AS details
												  FROM CC_DOCUMENTO_TBL
												  WHERE CC_PLACA_FLD = '".$plate."' AND 
														CC_IDENTIFICADOR_FLD = '".$number."' AND
														CC_TIPO_DOCUM_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$documentType."' AND CC_CAMPO_FLD = 'cc_tipo_docum_fld')");
	}
	
	function modifyDocument($documentData, $number, $plate, $documentType) {
		$respCode = 0;			
		$this->util->db->Execute("DELETE FROM CC_DOCUMENTO_TBL WHERE CC_PLACA_FLD = '".$plate."' AND 
																	CC_IDENTIFICADOR_FLD = '".$number."' AND 
																	CC_TIPO_DOCUM_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$documentType."' AND CC_CAMPO_FLD = 'cc_tipo_docum_fld')");
		$respCode = $this->addDocument($documentData);
		return $respCode;
	}
 }
?>