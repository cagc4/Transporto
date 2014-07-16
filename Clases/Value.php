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
		$this->result = $this->util->db->Execute("INSERT INTO CC_VALORES_TBL VALUES('".$valueBasicData->fieldValue."',
																					'".$valueBasicData->value."',
																					'".$valueBasicData->description."',
																					'A')");
		if(!$this->result) {
			$this->util->db->Execute("DELETE FROM CC_VALORES_TBL WHERE CC_CAMPO_FLD = '".$userBasicData->fieldValue."' AND CC_VALOR_FLD = '".$userBasicData->value."'");								   
			$respCode = 1;
		}
		return $respCode;
	}
	
	function getValue($field, $value) {
		$this->result = $this->util->db->Execute("SELECT V.CC_CAMPO_FLD AS fieldValue,
														 V.CC_VALOR_FLD AS value,
														 V.CC_DESCRIPCION_FLD AS description,
														 V.CC_ESTADO_FLD AS state
												  FROM CC_FIELDS_TBL F INNER JOIN CC_VALORES_TBL V ON F.CC_CAMPO_FLD = V.CC_CAMPO_FLD
												  WHERE F.CC_DESCRIPCION_FLD = '".$field."' AND V.CC_VALOR_FLD = '".$value."'");
	}
	
	function modifyValue($valueData) {
		$respCode = 0;			
		$valueBasicData = $valueData->valueFormBasicData->valueFormBasic;
		$this->result = $this->util->db->Execute("UPDATE CC_VALORES_TBL SET CC_DESCRIPCION_FLD = '".$valueBasicData->description."',
																		    CC_ESTADO_FLD = '".$valueBasicData->state."'
												  WHERE CC_CAMPO_FLD = '".$valueBasicData->fieldValue."' AND CC_VALOR_FLD = '".$valueBasicData->value."'");
		if(!$this->result) {
			$respCode = 1;
		}
		return $respCode;
	}
 }
?>