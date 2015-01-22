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
		$this->result = $this->util->db->Execute("INSERT INTO cc_person_tbl VALUES('".$transporterBasicData->docType."',
																				   '".$transporterBasicData->docNum."',
																				   '".$transporterBasicData->name."',
																			       STR_TO_DATE('".$transporterBasicData->birthDate->month."/".$transporterBasicData->birthDate->day."/".$transporterBasicData->birthDate->year."','%m/%d/%Y'),
																				   '".$transporterBasicData->cityExpedition."',
																				   '".$transporterCommentsData->details."')");
		if($this->result) {
			$this->result = $this->util->db->Execute("INSERT INTO cc_propcond_tbl VALUES('".$transporterBasicData->docType."',
																						 '".$transporterBasicData->docNum."',
																						 '".$transporterBasicData->ownerType."',
																						 '".$transporterFinancialData->bank."',
																						 '".$transporterFinancialData->acctType."',
																						 '".$transporterFinancialData->acctNum."',
																						 '".$transporterLicenseData->licenseCategory."',
																						 '".$transporterLicenseData->licenseNum."',
																						 STR_TO_DATE('".$transporterLicenseData->expirationDate->month."/".$transporterLicenseData->expirationDate->day."/".$transporterLicenseData->expirationDate->year."','%m/%d/%Y'))");
			if($this->result) {
				$this->result = $this->util->db->Execute("INSERT INTO cc_address_tbl VALUES('".$transporterBasicData->docType."',
																							'".$transporterBasicData->docNum."',
																							'".$transporterLocationData->address."',
																							'".$transporterContactData->phone."',
																							'".$transporterContactData->celPhone."',
																							'".$transporterContactData->email."',
																							'".$transporterLocationData->state."',
																							'".$transporterLocationData->city."')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM cc_address_tbl WHERE cc_tipo_doc_fld = '".$transporterBasicData->docType."' AND cc_nume_doc_fld = '".$transporterBasicData->docNum."'");
					$this->util->db->Execute("DELETE FROM cc_propcond_tbl WHERE cc_tipo_doc_fld = '".$transporterBasicData->docType."' AND cc_nume_doc_fld = '".$transporterBasicData->docNum."'");
					$this->util->db->Execute("DELETE FROM cc_person_tbl WHERE cc_tipo_doc_fld = '".$transporterBasicData->docType."' AND cc_nume_doc_fld = '".$transporterBasicData->docNum."'");
					$respCode = 1;
				}
			}
			else {
				$this->util->db->Execute("DELETE FROM cc_propcond_tbl WHERE cc_tipo_doc_fld = '".$transporterBasicData->docType."' AND cc_nume_doc_fld = '".$transporterBasicData->docNum."'");
				$this->util->db->Execute("DELETE FROM cc_person_tbl WHERE cc_tipo_doc_fld = '".$transporterBasicData->docType."' AND cc_nume_doc_fld = '".$transporterBasicData->docNum."'");
				$respCode = 1;
			}
		}
		else {
			$this->util->db->Execute("DELETE cc_person_tbl WHERE cc_tipo_doc_fld = '".$transporterBasicData->docType."' AND cc_nume_doc_fld = '".$transporterBasicData->docNum."'");
			$respCode = 1;
		}
		return $respCode;
	}

	function getTransporter($docNum, $docType) {
		$this->result = $this->util->db->Execute("SELECT P.cc_tipo_doc_fld AS docType,
														 P.cc_nume_doc_fld AS docNum,
														 P.cc_fnombre_fld AS name,
														 DATE_FORMAT(P.cc_fechanac_fld, '%m/%d/%Y') AS birthDate,
														 P.cc_codciudad_fld AS cityExpedition,
														 P.cc_detalles_fld AS details,
														 PC.cc_type_pc_fld AS ownerType,
														 PC.cc_banco_fld AS bank,
														 PC.cc_tipocuenta_fld AS acctType,
														 PC.cc_numcuenta_fld AS acctNum,
														 PC.cc_catlicencia_fld AS licenseCategory,
														 PC.cc_numlicencia_fld AS licenseNum,
														 DATE_FORMAT(PC.cc_fchvenclicencia_fld, '%m/%d/%Y') AS expirationDate,
														 D.cc_direccion_fld AS address,
														 D.cc_telefono_fld AS phone,
														 D.cc_celular_fld AS celPhone,
														 D.cc_email_fld AS email,
														 D.cc_codigodept_fld AS state,
														 D.cc_codciudad_fld AS city
												  FROM (cc_person_tbl P INNER JOIN cc_propcond_tbl PC ON P.cc_tipo_doc_fld = PC.cc_tipo_doc_fld AND P.cc_nume_doc_fld = PC.cc_nume_doc_fld) INNER JOIN cc_address_tbl D ON P.cc_tipo_doc_fld = D.cc_tipo_doc_fld AND P.cc_nume_doc_fld = D.cc_nume_doc_fld
												  WHERE P.cc_nume_doc_fld = '".$docNum."' AND P.cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
	}

	function modifyTransporter($transporterData, $custId, $docType) {
		$respCode = 0;
		$this->util->db->Execute("DELETE FROM cc_address_tbl WHERE cc_nume_doc_fld = '".$custId."' AND cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
		$this->util->db->Execute("DELETE FROM cc_propcond_tbl WHERE cc_nume_doc_fld = '".$custId."' AND cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
		$this->util->db->Execute("DELETE FROM cc_person_tbl WHERE cc_nume_doc_fld = '".$custId."' AND cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
		$respCode = $this->addTransporter($transporterData);
		return $respCode;
	}
 }
?>