<?php

class Fuec
{
	var $util;
	var $result;
	
	function Fuec()
	{
		$this->util = new Utilities();
	}

	function addFuec($fuecData, $numFuec, $numContract)
	{
		$respCode = 0;		
		$fuecBasicData = $fuecData->fuecFormBasicData->fuecFormBasic;
		$this->result = $this->util->db->Execute("INSERT INTO CC_FUEC_TBL VALUES (0, '" . $numFuec . "', " . $numContract . ")");
		if($this->result) {
			foreach($fuecBasicData as $fuec) {
				$this->result = $this->util->db->Execute("INSERT INTO CC_FUEC_OCUPANTES_TBL VALUES (0, '" . $numFuec . "', '" . $fuec->docType . "', '" . $fuec->docNum . "', '" . $fuec->name . "')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM CC_FUEC_TBL WHERE CC_NUMERO_FUEC_FLD = ".$numFuec);
					$this->util->db->Execute("DELETE FROM CC_FUEC_OCUPANTES_TBL WHERE CC_NUMERO_FUEC_FLD = ".$numFuec);
					$respCode = 2;
					break;
				}
			}
		}
		else {
			$this->util->db->Execute("DELETE FROM CC_FUEC_TBL WHERE CC_NUMERO_FUEC_FLD = ".$numFuec);
			$respCode = 1;
		}
		return $respCode;
	}
	
	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'CC_FUEC_TBL'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM DUAL");
	}
	
	function getFuec($number) {
		$this->result = $this->util->db->Execute("SELECT CC_ID_FLD AS consecutivo,
														 CC_OBJETOCONT_FLD AS objetoS,
														 CC_NUME_DOC_FLD AS numeroDoc,
														 CC_PLACA_FLD AS placa,
														 CC_NUMBUSES_FLD AS busesCon,
														 CC_NUMPASAJEROS_FLD AS numPas,
														 CC_FECHASALI_FLD AS fechasalida,
														 CC_FECHAREGR_FLD AS fecharegreso,
														 CC_HORASALI_FLD AS horasalida,
														 CC_HORAREGR_FLD AS horaregreso,
														 CC_ORIGEN_FLD AS origen,
														 CC_DESTINO_FLD AS destino,
														 CC_DIRSALIDA_FLD AS direSalida,
														 CC_FECHAFIRMA_FLD AS fechaFirma,
														 CAST(CC_COSTOCONTRATO_FLD AS CHAR) AS total,
														 CAST(CC_ABONO_FLD AS CHAR) AS abono,
														 DATEDIFF(CC_FECHAREGR_FLD, CC_FECHASALI_FLD)+1 AS dias														 
												  FROM CC_CONTRACT_TBL 
												  WHERE CC_ID_FLD = ".$number);
	}
 }
?>