<?php

class Transporter
{
	var $util;
	var $result;
	
	function Transporter()
	{
		$this->util = new Utilities();
	}

	function addTransporter($transporterData)
	{
		$respCode = 0;		
		$transporterBasicData = $transporterData->transporterFormBasicData->transporterFormBasic;
		$transporterContactData = $transporterData->transporterFormContactData->transporterFormContact;
		$transporterLocationData = $transporterData->transporterFormLocationData->transporterFormLocation;
		$transporterLicenseData = $transporterData->transporterFormLicenseData->transporterFormLicense;
		$transporterFinancialData = $transporterData->transporterFormFinancialData->transporterFormFinancial;
		$transporterCommentsData = $transporterData->transporterFormCommentsData->transporterFormComments;
		$this->result = $this->util->db->Execute("INSERT INTO CC_PERSON_TBL VALUES('".$transporterBasicData->docType."',
																				   '".$transporterBasicData->docNum."',
																				   '".$transporterBasicData->name."',
																			       STR_TO_DATE('".$transporterBasicData->birthDate->month."/".$transporterBasicData->birthDate->day."/".$transporterBasicData->birthDate->year."','%m/%d/%Y'),
																				   '".$transporterBasicData->cityExpedition."',
																				   '".$transporterCommentsData->details."')");
		if($this->result) {
			$this->result = $this->util->db->Execute("INSERT INTO CC_PROPCOND_TBL VALUES('".$transporterBasicData->docType."',
																						 '".$transporterBasicData->docNum."',
																						 '".$transporterBasicData->ownerType."',
																						 '".$transporterFinancialData->bank."',
																						 '".$transporterFinancialData->acctType."',
																						 '".$transporterFinancialData->acctNum."',
																						 '".$transporterLicenseData->licenseCategory."',
																						 '".$transporterLicenseData->licenseNum."',
																						 STR_TO_DATE('".$transporterLicenseData->expirationDate->month."/".$transporterLicenseData->expirationDate->day."/".$transporterLicenseData->expirationDate->year."','%m/%d/%Y'))");
			if($this->result) {
				$this->result = $this->util->db->Execute("INSERT INTO CC_ADDRESS_TBL VALUES('".$transporterBasicData->docType."',
																							'".$transporterBasicData->docNum."',
																							'".$transporterLocationData->address."',
																							'".$transporterContactData->phone."',
																							'".$transporterContactData->celPhone."',
																							'".$transporterContactData->email."',
																							'".$transporterLocationData->state."',
																							'".$transporterLocationData->city."')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM CC_ADDRESS_TBL WHERE CC_TIPO_DOC_FLD = '".$transporterBasicData->docType."' AND CC_NUME_DOC_FLD = '".$transporterBasicData->docNum."'");
					$this->util->db->Execute("DELETE FROM CC_PROPCOND_TBL WHERE CC_TIPO_DOC_FLD = '".$transporterBasicData->docType."' AND CC_NUME_DOC_FLD = '".$transporterBasicData->docNum."'");
					$this->util->db->Execute("DELETE FROM CC_PERSON_TBL WHERE CC_TIPO_DOC_FLD = '".$transporterBasicData->docType."' AND CC_NUME_DOC_FLD = '".$transporterBasicData->docNum."'");									   
					$respCode = 1;
				}
			}
			else {
				$this->util->db->Execute("DELETE FROM CC_PROPCOND_TBL WHERE CC_TIPO_DOC_FLD = '".$transporterBasicData->docType."' AND CC_NUME_DOC_FLD = '".$transporterBasicData->docNum."'");
				$this->util->db->Execute("DELETE FROM CC_PERSON_TBL WHERE CC_TIPO_DOC_FLD = '".$transporterBasicData->docType."' AND CC_NUME_DOC_FLD = '".$transporterBasicData->docNum."'");									   
				$respCode = 1;
			}
		}
		else {
			$this->util->db->Execute("DELETE CC_PERSON_TBL WHERE CC_TIPO_DOC_FLD = '".$transporterBasicData->docType."' AND CC_NUME_DOC_FLD = '".$transporterBasicData->docNum."'");
			$respCode = 1;
		}
		return $respCode;
	}
	
	function getTransporter($docNum, $docType) {
		$this->result = $this->util->db->Execute("SELECT P.CC_TIPO_DOC_FLD AS docType,
														 P.CC_NUME_DOC_FLD AS docNum,
														 P.CC_FNOMBRE_FLD AS name,
														 DATE_FORMAT(P.CC_FECHANAC_FLD, '%m/%d/%Y') AS birthDate,
														 P.CC_CODCIUDAD_FLD AS cityExpedition,
														 P.CC_DETALLES_FLD AS details,
														 PC.CC_TYPE_PC_FLD AS ownerType,
														 PC.CC_BANCO_FLD AS bank,
														 PC.CC_TIPOCUENTA_FLD AS acctType,
														 PC.CC_NUMCUENTA_FLD AS acctNum,
														 PC.CC_CATLICENCIA_FLD AS licenseCategory,
														 PC.CC_NUMLICENCIA_FLD AS licenseNum,
														 DATE_FORMAT(PC.CC_FCHVENCLICENCIA_FLD, '%m/%d/%Y') AS expirationDate,
														 D.CC_DIRECCION_FLD AS address,
														 D.CC_TELEFONO_FLD AS phone,
														 D.CC_CELULAR_FLD AS celPhone,
														 D.CC_EMAIL_FLD AS email,
														 D.CC_CODIGODEPT_FLD AS state,
														 D.CC_CODCIUDAD_FLD AS city
												  FROM (CC_PERSON_TBL P INNER JOIN CC_PROPCOND_TBL PC ON P.CC_TIPO_DOC_FLD = PC.CC_TIPO_DOC_FLD AND P.CC_NUME_DOC_FLD = PC.CC_NUME_DOC_FLD) INNER JOIN CC_ADDRESS_TBL D ON P.CC_TIPO_DOC_FLD = D.CC_TIPO_DOC_FLD AND P.CC_NUME_DOC_FLD = D.CC_NUME_DOC_FLD
												  WHERE P.CC_NUME_DOC_FLD = '".$docNum."' AND P.CC_TIPO_DOC_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$docType."' AND CC_CAMPO_FLD = 'cc_tipo_doc_fld')");
	}
	
	function modifyTransporter($transporterData, $custId, $docType) {
		$respCode = 0;
		$this->util->db->Execute("DELETE FROM CC_ADDRESS_TBL WHERE CC_NUME_DOC_FLD = '".$custId."' AND CC_TIPO_DOC_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$docType."' AND CC_CAMPO_FLD = 'cc_tipo_doc_fld')");
		$this->util->db->Execute("DELETE FROM CC_PROPCOND_TBL WHERE CC_NUME_DOC_FLD = '".$custId."' AND CC_TIPO_DOC_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$docType."' AND CC_CAMPO_FLD = 'cc_tipo_doc_fld')");
		$this->util->db->Execute("DELETE FROM CC_PERSON_TBL WHERE CC_NUME_DOC_FLD = '".$custId."' AND CC_TIPO_DOC_FLD = (SELECT CC_VALOR_FLD FROM CC_VALORES_TBL WHERE CC_DESCRIPCION_FLD = '".$docType."' AND CC_CAMPO_FLD = 'cc_tipo_doc_fld')");									   
		$respCode = $this->addTransporter($transporterData);
		return $respCode;
	}
 }
?>