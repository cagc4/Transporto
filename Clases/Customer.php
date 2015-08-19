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
		$this->result = $this->util->db->Execute("INSERT INTO cc_person_tbl VALUES('".$customerBasicData->docType."',
																				   '".$customerBasicData->docNum."',
																				   '".$customerBasicData->name."',
																				   STR_TO_DATE('".$customerBasicData->birthDate->month."/".$customerBasicData->birthDate->day."/".$customerBasicData->birthDate->year."','%m/%d/%Y'),
																				   '".$customerBasicData->cityExpedition."',
																				   '".$customerComments->details."')");
		if($this->result) {
			$this->result = $this->util->db->Execute("INSERT INTO cc_customer_tbl VALUES('".$customerBasicData->docType."',
																					     '".$customerBasicData->docNum."',
																					     '".$customerFinancialData->bank."',
																					     '".$customerFinancialData->acctType."',
																					     '".$customerFinancialData->acctNum."',
																					     '".$customerBasicData->contact."')");
			if($this->result) {
				$this->result = $this->util->db->Execute("INSERT INTO cc_address_tbl VALUES('".$customerBasicData->docType."',
																						    '".$customerBasicData->docNum."',
																						    '".$customerLocationData->address."',
																						    '".$customerContactData->phone."',
																						    '".$customerContactData->celPhone."',
																						    '".$customerContactData->email."',
																						    '".$customerLocationData->state."',
																						    '".$customerLocationData->city."')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM cc_address_tbl WHERE cc_tipo_doc_fld = '".$customerBasicData->docType."' AND cc_nume_doc_fld = '".$customerBasicData->docNum."'");
					$this->util->db->Execute("DELETE FROM cc_customer_tbl WHERE cc_tipo_doc_fld = '".$customerBasicData->docType."' AND cc_nume_doc_fld = '".$customerBasicData->docNum."'");
					$this->util->db->Execute("DELETE FROM cc_person_tbl WHERE cc_tipo_doc_fld = '".$customerBasicData->docType."' AND cc_nume_doc_fld = '".$customerBasicData->docNum."'");
					$respCode = 1;
				}
			}
			else {
				$this->util->db->Execute("DELETE FROM cc_customer_tbl WHERE cc_tipo_doc_fld = '".$customerBasicData->docType."' AND cc_nume_doc_fld = '".$customerBasicData->docNum."'");
				$this->util->db->Execute("DELETE FROM cc_person_tbl WHERE cc_tipo_doc_fld = '".$customerBasicData->docType."' AND cc_nume_doc_fld = '".$customerBasicData->docNum."'");
				$respCode = 1;
			}
		}
		else {
			$this->util->db->Execute("DELETE FROM cc_person_tbl WHERE cc_tipo_doc_fld = '".$customerBasicData->docType."' AND cc_nume_doc_fld = '".$customerBasicData->docNum."'");
			$respCode = 1;
		}
		return $respCode;
	}

	function getCustomer($docNum, $docType) {
		$this->result = $this->util->db->Execute("SELECT p.cc_tipo_doc_fld as docType,
														 p.cc_nume_doc_fld as docNum,
														 p.cc_fnombre_fld as name,
														 date_format(p.cc_fechanac_fld, '%m/%d/%y') as birthDate,
														 p.cc_codciudad_fld as cityExpedition,
														 p.cc_detalles_fld as details,
														 c.cc_banco_fld as bank,
														 c.cc_tipocuenta_fld as acctType,
														 c.cc_numcuenta_fld as acctNum,
														 c.cc_personacontacto_fld as contact,
														 d.cc_direccion_fld as address,
														 d.cc_telefono_fld as phone,
														 d.cc_celular_fld as celPhone,
														 d.cc_email_fld as email,
														 d.cc_codigodept_fld as state,
														 d.cc_codciudad_fld as city
												  from (cc_person_tbl p inner join cc_customer_tbl c on p.cc_tipo_doc_fld = c.cc_tipo_doc_fld and p.cc_nume_doc_fld = c.cc_nume_doc_fld) inner join cc_address_tbl d on p.cc_tipo_doc_fld = d.cc_tipo_doc_fld and p.cc_nume_doc_fld = d.cc_nume_doc_fld
												  where p.cc_nume_doc_fld = '".$docNum."' AND p.cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
	}

	function modifyCustomer($customerData, $custId) {
		$respCode = 0;
		$customerCommentsData = $customerData->customerFormCommentsData->customerFormComments;
		$this->util->db->Execute("DELETE FROM cc_address_tbl WHERE cc_nume_doc_fld = '".$custId."'");
		$this->util->db->Execute("DELETE FROM cc_customer_tbl WHERE cc_nume_doc_fld = '".$custId."'");
		$this->util->db->Execute("DELETE FROM cc_person_tbl WHERE cc_nume_doc_fld = '".$custId."'");
		$respCode = $this->addCustomer($customerData);
		return $respCode;
	}
 }
?>