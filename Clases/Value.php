<?php

class Value
{
	var $util;
	var $result;

	function Value()
	{
		$this->util = new Utilities();
	}

	function addValue($valueData)
	{
		$respCode = 0;
		$valueBasicData = $valueData->valueFormBasicData->valueFormBasic;
		$this->result = $this->util->db->Execute("INSERT INTO cc_valores_tbl VALUES('".$valueBasicData->fieldValue."',
																					'".$valueBasicData->value."',
																					'".$valueBasicData->description."',
																					'A')");
		if(!$this->result) {
			$this->util->db->Execute("DELETE FROM cc_valores_tbl WHERE cc_campo_fld = '".$userBasicData->fieldValue."' AND cc_valor_fld = '".$userBasicData->value."'");
			$respCode = 1;
		}
		return $respCode;
	}

	function getValue($field, $value) {
		$this->result = $this->util->db->Execute("SELECT V.cc_campo_fld AS fieldValue,
														 V.cc_valor_fld AS value,
														 V.cc_descripcion_fld AS description,
														 V.cc_estado_fld AS state
												  FROM cc_fields_tbl F INNER JOIN cc_valores_tbl V ON F.cc_campo_fld = V.cc_campo_fld
												  WHERE F.cc_descripcion_fld = '".$field."' AND V.cc_valor_fld = '".$value."'");
	}

	function modifyValue($valueData) {
		$respCode = 0;
		$valueBasicData = $valueData->valueFormBasicData->valueFormBasic;
		$this->result = $this->util->db->Execute("UPDATE cc_valores_tbl SET cc_descripcion_fld = '".$valueBasicData->description."',
																		    cc_estado_fld = '".$valueBasicData->state."'
												  WHERE cc_campo_fld = '".$valueBasicData->fieldValue."' AND cc_valor_fld = '".$valueBasicData->value."'");
		if(!$this->result) {
			$respCode = 1;
		}
		return $respCode;
	}
 }
?>