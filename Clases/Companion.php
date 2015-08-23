<?php

class Companion
{
	var $util;
	var $result;

	function Companion()
	{
		$this->util = new Utilities();
	}

	function addCompanion($companionData)	{
		$respCode = 0;

		$companionBasicData = $companionData->companionFormBasicData->companionFormBasic;
		$companionCommentsData = $companionData->companionFormCommentsData->companionFormComments;
		$this->result = $this->util->db->Execute("INSERT INTO cc_companion_tbl VALUES('".$companionBasicData->docType."',
																					 '".$companionBasicData->docNum."',
																					 '".$companionBasicData->name."',
																					 '".$companionBasicData->lastName."',
																					 '".$companionBasicData->address."',
																					 '".$companionBasicData->phone."',
																					 '".$companionCommentsData->details."')");
			if(!$this->result) {
				$this->util->db->Execute("DELETE FROM cc_companion_tbl WHERE cc_tipo_doc_fld = '".$companionBasicData->docType."' AND cc_nume_doc_fld = '".$companionBasicData->docNum."'");
				$respCode = 1;
			}
		return $respCode;
	}

	function getCompanion($docNum, $docType) {
		$this->result = $this->util->db->Execute("SELECT cc_tipo_doc_fld as docType,
														 cc_nume_doc_fld as docNum,
														 cc_nombre_fld as name,														 
														 cc_apellido_fld as lastName,
														 cc_direccion_fld as address,
														 cc_telefono as phone,
														 cc_observaciones_fld as details
												  from cc_companion_tbl
												  where cc_nume_doc_fld = '".$docNum."' AND cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
	}

	function modifyCompanion($companionData, $docNum, $docType) {
		$respCode = 0;
		$this->util->db->Execute("DELETE FROM cc_companion_tbl WHERE cc_nume_doc_fld = '".$docNum."' AND cc_tipo_doc_fld = (SELECT cc_valor_fld FROM cc_valores_tbl WHERE cc_descripcion_fld = '".$docType."' AND cc_campo_fld = 'cc_tipo_doc_fld')");
		$respCode = $this->addCompanion($companionData);
		return $respCode;
	}
 }
?>