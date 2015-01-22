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
		$this->result = $this->util->db->Execute("SELECT * FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$documentBasicData->plate."'");
		if($this->result->FetchRow()) {
			$this->result = $this->util->db->Execute("INSERT INTO cc_documento_tbl VALUES('".$documentBasicData->number."',
																						  '".$documentBasicData->documentType."',
																						  '".$documentBasicData->plate."',
																						  STR_TO_DATE('".$documentInsurance->dateOfIssue->month."/".$documentInsurance->dateOfIssue->day."/".$documentInsurance->dateOfIssue->year."','%m/%d/%Y'),
																						  STR_TO_DATE('".$documentInsurance->expirationDate->month."/".$documentInsurance->expirationDate->day."/".$documentInsurance->expirationDate->year."','%m/%d/%Y'),
																						  '".$documentInsurance->insurance."',
																						  '".$documentCoverage->coverage."',
																						  '".$documentBasicData->transitAgency."',
																						  '".$documentComments->details."')");
			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM cc_documento_tbl WHERE cc_placa_fld = '".$documentBasicData->plate."' AND
																		cc_identificador_fld = '".$documentBasicData->number."' AND
																		cc_tipo_docum_fld = '".$documentBasicData->documentType."'");
				$respCode = 1;
			}
		}
		else {
			$respCode = 2;
		}
		return $respCode;
	}

	function getDocument($number, $plate, $documentType) {
		$this->result = $this->util->db->Execute("SELECT cc_identificador_fld AS number,
														 cc_tipo_docum_fld AS documentType,
														 cc_placa_fld AS plate,
														 DATE_FORMAT(cc_fecha_exp_fld, '%m/%d/%Y') AS dateOfIssue,
														 DATE_FORMAT(cc_fecha_ven_fld, '%m/%d/%Y') AS expirationDate,
														 cc_nombre_ase_fld AS insurance,
														 cc_cobertura_fld AS coverage,
														 cc_org_tran_fld AS transitAgency,
														 cc_observaciones_fld AS details
												  FROM cc_documento_tbl
												  WHERE cc_placa_fld = '".$plate."' AND
														cc_identificador_fld = '".$number."' AND
														cc_tipo_docum_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$documentType."' AND cc_campo_fld = 'cc_tipo_docum_fld')");
	}

	function modifyDocument($documentData, $number, $plate, $documentType) {
		$respCode = 0;
		$this->util->db->Execute("DELETE FROM cc_documento_tbl WHERE cc_placa_fld = '".$plate."' AND
																	cc_identificador_fld = '".$number."' AND
																	cc_tipo_docum_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$documentType."' AND cc_campo_fld = 'cc_tipo_docum_fld')");
		$respCode = $this->addDocument($documentData);
		return $respCode;
	}
 }
?>