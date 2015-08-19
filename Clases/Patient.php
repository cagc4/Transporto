<?php

class Patient
{
	var $util;
	var $result;

	function Patient()
	{
		$this->util = new Utilities();
	}

	function addPatient($patientData)	{
		$respCode = 0;

		$patientBasicData = $patientData->patientFormBasicData->patientFormBasic;
		$patientCommentsData = $patientData->patientFormCommentsData->patientFormComments;
		$this->result = $this->util->db->Execute("INSERT INTO cc_patient_tbl VALUES('".$patientBasicData->docType."',
																					 '".$patientBasicData->docNum."',
																					 '".$patientFinancialData->bank."',
																					 '".$patientFinancialData->acctType."',
																					 '".$patientFinancialData->acctNum."',
																					 '".$patientBasicData->contact."')");
			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM cc_patient_tbl WHERE cc_tipo_doc_fld = '".$patientBasicData->docType."' AND cc_nume_doc_fld = '".$patientBasicData->docNum."'");
				$respCode = 1;
			}
		return $respCode;
	}

	function getPatient($docNum, $docType) {
		$this->result = $this->util->db->Execute("SELECT cc_tipo_doc_fld as docType,
														 cc_nume_doc_fld as docNum,
														 cc_nombre_fld as name,														 
														 cc_apellido_fld as lastName,
														 cc_direccion_fld as address,
														 cc_telefono as phone,
														 cc_sede_fld as venue,
														 cc_observaciones_fld as details
												  from cc_patient_tbl
												  where cc_nume_doc_fld = '".$docNum."' AND cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
	}

	function modifyPatient($patientData, $docNum, $docType) {
		$respCode = 0;
		$this->util->db->Execute("DELETE FROM cc_patient_tbl WHERE cc_nume_doc_fld = '".$docNum."' AND cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
		$respCode = $this->addPatient($patientData);
		return $respCode;
	}
 }
?>