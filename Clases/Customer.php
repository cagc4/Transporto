<?php

class Customer
{
	var $util;
	var $result;
	
	function Customer()
	{
		$this->util = new Utilities();
	}

	function addCustomer($customerData)	{
		$respCode = 0;
		
		$customerBasicData = $customerData->customerFormBasicData->customerFormBasic;
		$customerContactData = $customerData->customerFormContactData->customerFormContact;
		$customerLocationData = $customerData->customerFormLocationData->customerFormLocation;
		$customerFinancialData = $customerData->customerFormFinancialData->customerFormFinancial;
		$customerCommentsData = $customerData->customerFormCommentsData->customerFormComments;
		$this->result = $this->util->db->Execute("INSERT INTO CC_PERSON_TBL VALUES('".$customerBasicData->docType."',
																				   '".$customerBasicData->docNum."',
																				   '".$customerBasicData->name."',
																				   STR_TO_DATE('".$customerBasicData->birthDate->month."/".$customerBasicData->birthDate->day."/".$customerBasicData->birthDate->year."','%m/%d/%Y'),
																				   '".$customerBasicData->cityExpedition."',
																				   '".$customerComments->details."')");
		if($this->result) {
			$this->result = $this->util->db->Execute("INSERT INTO CC_CUSTOMER_TBL VALUES('".$customerBasicData->docType."',
																					     '".$customerBasicData->docNum."',
																					     '".$customerFinancialData->bank."',
																					     '".$customerFinancialData->acctType."',
																					     '".$customerFinancialData->acctNum."',
																					     '".$customerBasicData->contact."')");
			if($this->result) {
				$this->result = $this->util->db->Execute("INSERT INTO CC_ADDRESS_TBL VALUES('".$customerBasicData->docType."',
																						    '".$customerBasicData->docNum."',
																						    '".$customerLocationData->address."',
																						    '".$customerContactData->phone."',
																						    '".$customerContactData->celPhone."',
																						    '".$customerContactData->email."',
																						    '".$customerLocationData->state."',
																						    '".$customerLocationData->city."')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM CC_ADDRESS_TBL WHERE CC_TIPO_DOC_FLD = '".$customerBasicData->docType."' AND CC_NUME_DOC_FLD = '".$customerBasicData->docNum."'");
					$this->util->db->Execute("DELETE FROM CC_CUSTOMER_TBL WHERE CC_TIPO_DOC_FLD = '".$customerBasicData->docType."' AND CC_NUME_DOC_FLD = '".$customerBasicData->docNum."'");
					$this->util->db->Execute("DELETE FROM CC_PERSON_TBL WHERE CC_TIPO_DOC_FLD = '".$customerBasicData->docType."' AND CC_NUME_DOC_FLD = '".$customerBasicData->docNum."'");									   
					$respCode = 1;
				}
			}
			else {
				$this->util->db->Execute("DELETE FROM CC_CUSTOMER_TBL WHERE CC_TIPO_DOC_FLD = '".$customerBasicData->docType."' AND CC_NUME_DOC_FLD = '".$customerBasicData->docNum."'");
				$this->util->db->Execute("DELETE FROM CC_PERSON_TBL WHERE CC_TIPO_DOC_FLD = '".$customerBasicData->docType."' AND CC_NUME_DOC_FLD = '".$customerBasicData->docNum."'");									   
				$respCode = 1;
			}
		}
		else {
			$this->util->db->Execute("DELETE FROM CC_PERSON_TBL WHERE CC_TIPO_DOC_FLD = '".$customerBasicData->docType."' AND CC_NUME_DOC_FLD = '".$customerBasicData->docNum."'");
			$respCode = 1;
		}
		return $respCode;
	}
	
	function getCustomer($docNum, $docType) {
		$this->result = $this->util->db->Execute("SELECT P.CC_TIPO_DOC_FLD AS docType,
														 P.CC_NUME_DOC_FLD AS docNum,
														 P.CC_FNOMBRE_FLD AS name,
														 DATE_FORMAT(P.CC_FECHANAC_FLD, '%m/%d/%Y') AS birthDate,
														 P.CC_CODCIUDAD_FLD AS cityExpedition,
														 P.CC_DETALLES_FLD AS details,
														 C.CC_BANCO_FLD AS bank,
														 C.CC_TIPOCUENTA_FLD AS acctType,
														 C.CC_NUMCUENTA_FLD AS acctNum,
														 C.CC_PERSONACONTACTO_FLD AS contact,
														 D.CC_DIRECCION_FLD AS address,
														 D.CC_TELEFONO_FLD AS phone,
														 D.CC_CELULAR_FLD AS celPhone,
														 D.CC_EMAIL_FLD AS email,
														 D.CC_CODIGODEPT_FLD AS state,
														 D.CC_CODCIUDAD_FLD AS city
												  FROM (CC_PERSON_TBL P INNER JOIN CC_CUSTOMER_TBL C ON P.CC_TIPO_DOC_FLD = C.CC_TIPO_DOC_FLD AND P.CC_NUME_DOC_FLD = C.CC_NUME_DOC_FLD) INNER JOIN CC_ADDRESS_TBL D ON P.CC_TIPO_DOC_FLD = D.CC_TIPO_DOC_FLD AND P.CC_NUME_DOC_FLD = D.CC_NUME_DOC_FLD
												  WHERE P.CC_NUME_DOC_FLD = '".$docNum."' AND P.CC_TIPO_DOC_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$docType."' AND CC_CAMPO_FLD = 'cc_tipo_doc_fld')");
	}
	
	function modifyCustomer($customerData, $custId, $docType) {
		$respCode = 0;
		$customerCommentsData = $customerData->customerFormCommentsData->customerFormComments;
		$this->util->db->Execute("DELETE FROM CC_ADDRESS_TBL WHERE CC_NUME_DOC_FLD = '".$custId."' AND CC_TIPO_DOC_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$docType."' AND CC_CAMPO_FLD = 'cc_tipo_doc_fld')");
		$this->util->db->Execute("DELETE FROM CC_CUSTOMER_TBL WHERE CC_NUME_DOC_FLD = '".$custId."' AND CC_TIPO_DOC_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$docType."' AND CC_CAMPO_FLD = 'cc_tipo_doc_fld')");
		$this->util->db->Execute("DELETE FROM CC_PERSON_TBL WHERE CC_NUME_DOC_FLD = '".$custId."' AND CC_TIPO_DOC_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$docType."' AND CC_CAMPO_FLD = 'cc_tipo_doc_fld')");
		$respCode = $this->addCustomer($customerData);
		return $respCode;
	}
 }
?>